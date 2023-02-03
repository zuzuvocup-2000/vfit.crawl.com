/* eslint-disable no-unmodified-loop-condition */
/* eslint-disable @typescript-eslint/no-var-requires */
/* eslint-disable no-use-before-define */
/* eslint-disable no-await-in-loop */
import { HttpService } from '@nestjs/axios';
import { HttpStatus, Injectable } from '@nestjs/common';
import { CrawlerRepository } from '../crawler.repository';
import { setTimeout } from 'timers/promises';
import * as https from 'https';
import {
  ARTICLE_CONFIG_TYPE_ENUM,
  CATALOGUE_CONFIG_TYPE_ENUM,
  TYPE_CRAWL,
  TYPE_RATE,
} from 'src/common/constants/enum';
import { STATUS_URL } from 'src/common/constants/app';
import { parse } from 'muninn';
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
    const sites = await this.crawlerRepository.getSiteCrawl();
    sites.forEach(async (site) => {
      if (site['typeCrawl'] == TYPE_CRAWL.BROWSER) {
        await this.crawlingByBrowser(site);
      } else if (site['typeCrawl'] == TYPE_CRAWL.DOM) {
        await this.crawlingByHtmlDom(site);
      }
    });

    return sites;
  }

  async crawlingByBrowser(site): Promise<unknown> {
    const urls = await this.crawlerRepository.getUrlCrawlBySite(site);
    const configCatalogue = await this.crawlerRepository.getConfigCatalogueBySiteId(site);
    const configArticle = await this.crawlerRepository.getConfigArticleBySiteId(site);

    for (let index = 0; index < urls.length; index++) {
      const urlItem = urls[index];

      if ((typeof configCatalogue !== 'undefined' && configCatalogue.length > 0) || (typeof configArticle !== 'undefined' && configArticle.length > 0)) {
        const puppeteer = await this.setupPuppeteer(urlItem.url);

        const checkArticle = await this.handleArticleBrowser(puppeteer.page, configArticle, urlItem);
        if (!checkArticle) {
          const checkCatalogue = await this.handleArticleCatalogueBrowser(puppeteer.page, configCatalogue, urlItem);
          if (!checkCatalogue) await this.crawlerRepository.updateStatusUrl(urlItem['url'], STATUS_URL.INACTIVE);
        }
        // Run the crawler and wait for it to finish.
        await this.changeStatusCrawlUrl( urlItem );
        await puppeteer.browser.close();
      }
    }
    return true;
  }

  async crawlingByHtmlDom(site): Promise<unknown> {
    const urls = await this.crawlerRepository.getUrlCrawlBySite(site);
    const configCatalogue = await this.crawlerRepository.getConfigCatalogueBySiteId(site);
    const configArticle = await this.crawlerRepository.getConfigArticleBySiteId(site);

    for (let index = 0; index < urls.length; index++) {
      const urlItem = urls[index];

      if ((typeof configCatalogue !== 'undefined' && configCatalogue.length > 0) || (typeof configArticle !== 'undefined' && configArticle.length > 0)) {
        const responseSite = await this.getResponseAxios(urlItem.url);
        if (responseSite && responseSite['status'] === HttpStatus.OK) {
          // Set option and crawl data article by html dom
          const isCrawlArticle = await this.handleArticleDOM(urlItem, responseSite['data'], configArticle);
          if (!isCrawlArticle) {
            // Set option and crawl data catalogue by html dom
            await this.handleCatalogueDOM(urlItem, responseSite['data'], configCatalogue);
          }
        } else {
          await this.crawlerRepository.updateStatusUrl(urlItem['url'], STATUS_URL.INACTIVE);
        }
      }
    }
    return true;
  }

  /**
  * Set config to crawl data
  * @param {object} url.
  * @return {object} config
  */
  async handleCatalogueDOM(url, data, configCatalogue): Promise<boolean> {
    if (configCatalogue) {
      let isCrawl = false;
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
          await this.crawlerRepository.upsertCatalogue(url, resultCatalogueCrawl);
          isCrawl = true;
        }
      }
      if (!isCrawl) await this.crawlerRepository.updateStatusUrl(url['url'], STATUS_URL.INACTIVE);
    }
    return false;
  }

  async handleArticleDOM(url, data, configArticle): Promise<boolean> {
    let isCrawl = false;
    if (configArticle) {
      for (let index = 0; index < configArticle.length; index++) {
        const element = configArticle[index];
        const title = element.records.filter((obj) => {return obj.dataType === ARTICLE_CONFIG_TYPE_ENUM.TITLE;});
        const catalogue = element.records.filter((obj) => {return obj.dataType === ARTICLE_CONFIG_TYPE_ENUM.CATALOGUE_TITLE;});
        const description = element.records.filter((obj) => {return obj.dataType === ARTICLE_CONFIG_TYPE_ENUM.DESCRIPTION;});
        const content = element.records.filter((obj) => {return obj.dataType === ARTICLE_CONFIG_TYPE_ENUM.CONTENT;});
        const image = element.records.filter((obj) => {return obj.dataType === ARTICLE_CONFIG_TYPE_ENUM.IMAGE;});
        const rates = element.records.filter((obj) => {return obj.dataType === ARTICLE_CONFIG_TYPE_ENUM.RATE;});
        let ratesSelector = {};
        if (rates.length > 0) ratesSelector = JSON.parse(rates[0]['selector']);
        const config:unknown = {
          schema: {
            title: title.length > 0 ? title[0]['selector'] : undefined,
            catalogue: catalogue.length > 0 ? catalogue[0]['selector'] : undefined,
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
            comment: {
              selector: ratesSelector['comment'] ? ratesSelector['comment'] : undefined,
              type: 'array',
            },
            name: {
              selector: ratesSelector['name'] ? ratesSelector['name'] : undefined,
              type: 'array',
            },
          },
        };
        Object.keys(config['schema']).forEach(keyItem => !config['schema'][keyItem] && delete config['schema'][keyItem]);
        Object.keys(config['schema']).forEach(keyItem => typeof (config['schema'][keyItem]) === 'object' && config['schema'][keyItem].selector === undefined && delete config['schema'][keyItem]);
        const resultArticleCrawl:unknown = parse(data, config);
        if (resultArticleCrawl['title']) {
          resultArticleCrawl['rate'] = [];
          if (resultArticleCrawl['comment'].length > 0) {
            for (let index = 0; index < resultArticleCrawl['comment'].length; index++) {
              resultArticleCrawl['rate'].push({
                comment: resultArticleCrawl['comment'][index],
                name: resultArticleCrawl['name'][index],
              });
            }
          }
          await this.crawlerRepository.upsertArticle(url, resultArticleCrawl);
          isCrawl = true;
        }
      }
      return isCrawl ? true : false;
    }
    return false;
  }

  async handleArticleCatalogueBrowser(page, configCatalogue, urlItem): Promise<boolean> {
    let checkCatalogue = false;
    for (let index = 0; index < configCatalogue.length; index++) {
      const element = configCatalogue[index];
      const results = await page.evaluate((element, CATALOGUE_CONFIG_TYPE_ENUM) => {
        const titleSelector = (element.records[0].dataType == CATALOGUE_CONFIG_TYPE_ENUM.TITLE ? element.records[0].selector : '');
        const catalogue = {
          title: document.querySelector(titleSelector) ? document.querySelector(titleSelector).innerText : '',
        };
        return catalogue;
      }, element, CATALOGUE_CONFIG_TYPE_ENUM);
      if (results.title) {
        checkCatalogue = true;
        await this.crawlerRepository.upsertCatalogue(urlItem, results);
      }
    }

    return checkCatalogue;
  }

  async handleArticleBrowser(page, configArticle, urlItem): Promise<unknown> {
    let checkArticle = false;
    for (let index = 0; index < configArticle.length; index++) {
      const element = configArticle[index];

      const results = await page.evaluate((element, ARTICLE_CONFIG_TYPE_ENUM) => {
        const title = element.records.filter((obj) => { return obj.dataType === ARTICLE_CONFIG_TYPE_ENUM.TITLE; });
        const catalogue = element.records.filter((obj) => { return obj.dataType === ARTICLE_CONFIG_TYPE_ENUM.CATALOGUE_TITLE; });
        const description = element.records.filter((obj) => { return obj.dataType === ARTICLE_CONFIG_TYPE_ENUM.DESCRIPTION; });
        const content = element.records.filter((obj) => { return obj.dataType === ARTICLE_CONFIG_TYPE_ENUM.CONTENT; });
        const image = element.records.filter((obj) => { return obj.dataType === ARTICLE_CONFIG_TYPE_ENUM.IMAGE; });
        const article = {
          title: title.length > 0 && document.querySelector(title[0]['selector']) ? document.querySelector(title[0]['selector']).innerText : undefined,
          catalogue: catalogue.length > 0 && document.querySelector(catalogue[0]['selector']) ? document.querySelector(catalogue[0]['selector']).innerText : undefined,
          description: description.length > 0 && document.querySelector(description[0]['selector']) ? document.querySelector(description[0]['selector']).innerHTML : undefined,
          content: content.length > 0 && document.querySelector(content[0]['selector']) ? document.querySelector(content[0]['selector']).innerHTML : undefined,
          image: image.length > 0 && document.querySelector(image[0]['selector'] + ' img') ? Array.from(document.querySelectorAll(image[0]['selector'] + ' img'), img => img['src']) : undefined,
        };
        return article;
      }, element, ARTICLE_CONFIG_TYPE_ENUM);
      const rate = element.records.filter((obj) => { return obj.dataType === ARTICLE_CONFIG_TYPE_ENUM.RATE; });
      if (rate.length > 0) results.rate = await this.crawlRateArticle(rate, page);
      if (results.title) {
        checkArticle = true;
        await this.crawlerRepository.upsertArticle(urlItem, results);
      }
    }

    return checkArticle;
  }

  async crawlRateArticle(rate, page) {
    const param = JSON.parse(rate[0].selector);
    let comments = [];
    if (param.type == TYPE_RATE.PLUGIN) {
      await setTimeout(1000);
      const urlPlugin = await page.evaluate((element) => {
        return document.querySelector(element) ? document.querySelector(element).src : '';
      }, param.selector);
      if (urlPlugin != '') comments = await this.crawlRatePlugin(param, urlPlugin);
    } else if (param.type == TYPE_RATE.CLICK) {
      comments = await this.crawlRateEventClick(param, page);
    } else if (param.type == TYPE_RATE.SCROLL) {
      comments = await this.crawlRateEventScroll(param, page);
    }
    return comments;
  }

  async crawlRateEventScroll(param, page) {
    const rates = [];
    let condition = true;
    let height = 0;

    do {
      await page.evaluate('window.scrollTo(0, document.body.scrollHeight)');
      height = await page.evaluate('document.body.scrollHeight');
      condition = await this.checkHeight(page, height);
    } while (condition);

    const comments = await page.$$eval(param.comment, elements=> elements.map(item=>item.innerText));
    const names = await page.$$eval(param.name, elements=> elements.map(item=>item.innerText));
    if ( comments.length > 0) {
      for (let i = 0; i < comments.length; i++) {
        rates.push({
          name: names[i],
          comment: comments[i],
        });
      }
    }
    return rates;
  }

  async crawlRateEventClick(param, page) {
    let condition = true;
    do {
      await Promise.all([
        page.click(param.view_more),
      ]);
      condition = await this.isVisible(page, param.class_hide);
    } while (condition);

    const rates = [];
    const comments = await page.$$eval(param.comment, elements=> elements.map(item=>item.innerText));
    const names = await page.$$eval(param.name, elements=> elements.map(item=>item.innerText));
    if ( comments.length > 0) {
      for (let i = 0; i < comments.length; i++) {
        rates.push({
          name: names[i],
          comment: comments[i],
        });
      }
    }
    return rates;
  }

  async crawlRatePlugin(param, url) {
    const puppeteer = await this.setupPuppeteer(url);

    let condition = true;
    do {
      await Promise.all([
        puppeteer.page.click(param.view_more)
      ]);
      condition = await this.isVisible(puppeteer.page, param.view_more);
    } while (condition);

    const rates = [];
    const comments = await puppeteer.page.$$eval(param.comment, elements=> elements.map(item=>item.innerText));
    const names = await puppeteer.page.$$eval(param.name, elements=> elements.map(item=>item.innerText));
    if ( comments.length > 0) {
      for (let i = 0; i < comments.length; i++) {
        rates.push({
          name: names[i],
          comment: comments[i],
        });
      }
    }
    await puppeteer.browser.close();
    return rates;
  }

  async changeStatusCrawlUrl( urlItem ): Promise<boolean> {
    await this.crawlerRepository.updateStatusCrawlUrl(urlItem);
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

  async setupPuppeteer(url: string) {
    const puppeteer = require('puppeteer-extra');
    const blockResourcesPlugin = require('puppeteer-extra-plugin-block-resources')();
    puppeteer.use(blockResourcesPlugin);
    const browser = await puppeteer.launch({
      headless: true,
      args: [
        '--no-sandbox',
        '--disable-setuid-sandbox',
        '--disable-web-security',
        '--disable-features=IsolateOrigins,site-per-process',
      ],
    });
    blockResourcesPlugin.blockedTypes.add('image');
    blockResourcesPlugin.blockedTypes.add('media');
    blockResourcesPlugin.blockedTypes.add('font');
    blockResourcesPlugin.blockedTypes.add('texttrack');
    // blockResourcesPlugin.blockedTypes.add('xhr');
    // blockResourcesPlugin.blockedTypes.add('fetch');
    blockResourcesPlugin.blockedTypes.add('eventsource');
    blockResourcesPlugin.blockedTypes.add('websocket');
    blockResourcesPlugin.blockedTypes.add('manifest');
    blockResourcesPlugin.blockedTypes.add('other');
    const page = await browser.newPage();

    await page.goto(url, {
      waitUntil: 'domcontentloaded',
    });
    await page.setViewport({
      width: 1400,
      height: 800
    });
    return {
      browser: browser,
      page: page
    };
  }

  async isVisible(page, pathSelector) {
    await setTimeout(1500);
    const [element] = await page.$$(pathSelector);
    if (element === undefined) return false;
    return await page.evaluate((e) => {
      const style = window.getComputedStyle(e);
      return style && style.display !== 'none' && style.visibility !== 'hidden' && style.opacity !== '0';
    }, element);
  }

  async checkHeight(page, oldPage) {
    await setTimeout(1500);
    const height = await page.evaluate('document.body.scrollHeight');
    return (oldPage === height) ? false : true;
  }
}
