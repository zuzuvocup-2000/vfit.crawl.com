/* eslint-disable no-await-in-loop */
import { HttpService } from '@nestjs/axios';
import { HttpStatus, Injectable } from '@nestjs/common';
import {
  STATUS_URL,
} from 'src/common/constants/app';
import { CrawlerRepository } from './crawler.repository';
import * as https from 'https';
import { parse } from 'muninn';
import { Url } from '../admin/sitemap/schema/url.schema';
import { ARTICLE_CONFIG_TYPE_ENUM, CATALOGUE_CONFIG_TYPE_ENUM } from 'src/common/constants/enum';

@Injectable()
export class CrawlerService {
  constructor(
    private readonly httpService: HttpService,
    private readonly crawlerRepository: CrawlerRepository,
  ) {}

  /**
    * Crawler data from urls
    * @return {unknown} response
    */
  async crawlDataFromUrls(): Promise<unknown> {
    const allUrls = await this.crawlerRepository.getAllUrlsActive();
    for (let index = 0; index < allUrls.length; index++) {
      const urlItem = allUrls[index];
      const configCatalogue = await this.crawlerRepository.getConfigCatalogueBySiteId(urlItem);
      const configArticle = await this.crawlerRepository.getConfigArticleBySiteId(urlItem);
      if ((typeof configCatalogue !== 'undefined' && configCatalogue.length > 0) || (typeof configArticle !== 'undefined' && configArticle.length > 0)) {
        const responseSite = await this.getResponseAxios(urlItem.url);
        if (responseSite && responseSite['status'] === HttpStatus.OK) {
          // Set option and crawl data article by html dom
          const isCrawlArticle = await this.crawlDataArticle(urlItem, responseSite['data'], configArticle);

          if (!isCrawlArticle) {
            // Set option and crawl data catalogue by html dom
            await this.crawlDataCatalogue(urlItem, responseSite['data'], configCatalogue);
          }
        } else {
          await this.crawlerRepository.updateStatusUrl(urlItem['url'], STATUS_URL.INACTIVE);
        }
      }
    }

    return true;
  }

  /**
    * Get response data when send axios
    * @param {string} url
    * @return {unknown} response
    */
  async getResponseAxios(url: string): Promise<unknown> {
    try {
      return await this.httpService.axiosRef.get(url, {
        httpsAgent: new https.Agent({
          rejectUnauthorized: false,
          keepAlive: false,
        }),
      });
    } catch (error) {
      console.log(error);
    }
  }

  /**
    * Set config to crawl data
    * @param {object} url.
    * @return {object} config
    */
  async crawlDataCatalogue(url: Url, data, configCatalogue): Promise<boolean> {
    if (configCatalogue) {
      for (let index = 0; index < configCatalogue.length; index++) {
        const element = configCatalogue[index];
        // Set config selector
        const config = {
          schema: {
            title: (element.records[0].dataType == CATALOGUE_CONFIG_TYPE_ENUM.TITLE ? element.records[0].selector : ''),
          },
        };
        Object.keys(config.schema).forEach(keyItem => !config.schema[keyItem] && delete config.schema[keyItem]);
        // Crawl data and check to upsert
        const resultCatalogueCrawl = parse(data, config);
        if (resultCatalogueCrawl.title) {
          await this.crawlerRepository.upsertCatalogue(url, resultCatalogueCrawl, STATUS_URL.CRAWLING);
        } else {
          await this.crawlerRepository.updateStatusUrl(url['url'], STATUS_URL.INACTIVE);
        }
      }
    }
    return false;
  }

  async crawlDataArticle(url: Url, data, configArticle): Promise<boolean> {
    let isCrawl = false;
    if (configArticle) {
      for (let index = 0; index < configArticle.length; index++) {
        const element = configArticle[index];
        const title = element.records.filter((obj) => {return obj.dataType === ARTICLE_CONFIG_TYPE_ENUM.TITLE;});
        const description = element.records.filter((obj) => {return obj.dataType === ARTICLE_CONFIG_TYPE_ENUM.DESCRIPTION;});
        const content = element.records.filter((obj) => {return obj.dataType === ARTICLE_CONFIG_TYPE_ENUM.CONTENT;});
        const image = element.records.filter((obj) => {return obj.dataType === ARTICLE_CONFIG_TYPE_ENUM.IMAGE;});
        // const review = element.records.filter((obj) => {return obj.dataType === ARTICLE_CONFIG_TYPE_ENUM.RATE;});
        const config:unknown = {
          schema: {
            title: title.length > 0 ? title[0]['selector'] : undefined,
            description: {
              selector: description.length > 0 ? description[0]['selector'] : undefined,
              html: true
            },
            content: {
              selector: content.length > 0 ? content[0]['selector'] : undefined,
              html: true
            },
            image: {
              selector: image.length > 0 ? image[0]['selector'] : undefined,
              type: 'array',
              schema: {
                src: 'img@src',
              },
            },
          },
        };
        Object.keys(config['schema']).forEach(keyItem => !config['schema'][keyItem] && delete config['schema'][keyItem]);
        Object.keys(config['schema']).forEach(keyItem => typeof (config['schema'][keyItem]) === 'object' && config['schema'][keyItem].selector === undefined && delete config['schema'][keyItem]);

        const resultArticleCrawl = parse(data, config);
        if (resultArticleCrawl.title) {
          await this.crawlerRepository.upsertArticle(url, resultArticleCrawl, STATUS_URL.CRAWLING);
          isCrawl = true;
        }
      }
      return isCrawl ? true : false;
    }
    return false;
  }
}
