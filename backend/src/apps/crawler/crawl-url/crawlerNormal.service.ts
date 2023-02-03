/* eslint-disable @typescript-eslint/no-var-requires */
/* eslint-disable no-await-in-loop */
import { HttpService } from '@nestjs/axios';
import { HttpStatus, Injectable } from '@nestjs/common';
import * as https from 'https';
import { CHECK_URL_DISABLED } from 'src/common/constants/app';
import { TYPE_SITE } from 'src/common/constants/enum';
import { CrawlerRepository } from '../crawler.repository';

@Injectable()
export class CrawlerNormalService {
  constructor(
    private readonly httpService: HttpService,
    private readonly crawlerRepository: CrawlerRepository,
  ) {}

  /*
   * Crawler Sitemap Pending.
   * @return {boolean}
   */
  async crawlUrl(): Promise<unknown> {
    try {
      const sites = await this.crawlerRepository.getSiteCrawlUrl(
        TYPE_SITE.NORMAL,
      );
      let urls = [];
      for (const site of sites) {
        urls = await this.getAllUrlsByAxios({
          index: 0,
          url: site.url,
          list: [site.url],
          site: site,
        });
      }
      return urls;
    } catch (error) {
      console.log(error);
    }
  }

  async getAllUrlsByAxios(param): Promise<[]> {
    const responseSite = await this.getResponseAxios(param.url);
    if (responseSite && responseSite['status'] === HttpStatus.OK) {
      const getHrefs = require('get-hrefs');
      console.log(param.url);
      const currentUrl = new URL(param.url);
      const urls = getHrefs(responseSite['data']);
      const uniqueHrefs = urls.filter((item, i, ar) => ar.indexOf(item) === i);
      const disableUrls = [];
      for (let index = 0; index < uniqueHrefs.length; index++) {
        CHECK_URL_DISABLED.forEach(async (item) => {
          if (uniqueHrefs[index].indexOf(item) >= 0)
            disableUrls.push(uniqueHrefs[index]);
        });
      }
      const urlsAccept = uniqueHrefs.filter((x) => !disableUrls.includes(x));
      const lists = urlsAccept.filter((i) => i.includes(currentUrl.origin));
      for (const url of urlsAccept.filter(
        (i) => !i.includes(currentUrl.origin),
      )) {
        if (this.isValidUrl(currentUrl.origin + url))
          lists.push(currentUrl.origin);
      }
      param.list = param.list.concat(lists).filter((item, i, ar) => ar.indexOf(item) === i);
      if (param.index + 1 != param.list.length) {
        await this.getAllUrlsByAxios({
          index: param.index + 1,
          url: param.list[param.index + 1],
          list: param.list,
          site: param.site,
        });
      }
      await this.crawlerRepository.urlsBulkWriteByBrowser(
        param.list,
        param.site,
      );
    }
    return param.list;
  }

  isValidUrl(urlString) {
    const urlPattern = new RegExp(
      '^(https?:\\/\\/)?' + // validate protocol
        '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|' + // validate domain name
        '((\\d{1,3}\\.){3}\\d{1,3}))' + // validate OR ip (v4) address
        '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*' + // validate port and path
        '(\\?[;&a-z\\d%_.~+=-]*)?' + // validate query string
        '(\\#[-a-z\\d_]*)?$',
      'i',
    ); // validate fragment locator
    return !!urlPattern.test(urlString);
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
}
