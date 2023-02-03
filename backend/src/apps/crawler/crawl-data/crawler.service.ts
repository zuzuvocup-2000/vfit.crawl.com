/* eslint-disable no-unmodified-loop-condition */
/* eslint-disable @typescript-eslint/no-var-requires */
/* eslint-disable no-use-before-define */
/* eslint-disable no-await-in-loop */
import { HttpService } from '@nestjs/axios';
import { Injectable } from '@nestjs/common';
import { CrawlerRepository } from '../crawler.repository';
import { setTimeout } from 'timers/promises';
import {
  ARTICLE_CONFIG_TYPE_ENUM,
  CATALOGUE_CONFIG_TYPE_ENUM,
  TYPE_CRAWL,
  TYPE_RATE,
  TYPE_RATE_STOP,
} from 'src/common/constants/enum';
import { STATUS_URL } from 'src/common/constants/app';
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

        const checkCatalogue = await this.handleArticleCatalogueBrowser(puppeteer.page, configCatalogue, urlItem);
        if (!checkCatalogue) {
          const checkArticle = await this.handleArticleBrowser(puppeteer.page, configArticle, urlItem);
          if (!checkArticle) await this.crawlerRepository.updateStatusUrl(urlItem['url'], STATUS_URL.INACTIVE);
        }
        // Run the crawler and wait for it to finish.
        await this.changeStatusCrawlUrl( urlItem );
        await puppeteer.browser.close();
      }
    }
    return true;
  }

  async crawlingByHtmlDom(site): Promise<unknown> {
    return true;
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
        const description = element.records.filter((obj) => { return obj.dataType === ARTICLE_CONFIG_TYPE_ENUM.DESCRIPTION; });
        const content = element.records.filter((obj) => { return obj.dataType === ARTICLE_CONFIG_TYPE_ENUM.CONTENT; });
        const image = element.records.filter((obj) => { return obj.dataType === ARTICLE_CONFIG_TYPE_ENUM.IMAGE; });
        const article = {
          title: title.length > 0 && document.querySelector(title[0]['selector']) ? document.querySelector(title[0]['selector']).innerText : undefined,
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
