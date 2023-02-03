/* eslint-disable @typescript-eslint/no-var-requires */
/* eslint-disable no-await-in-loop */
import { HttpService } from '@nestjs/axios';
import { Injectable } from '@nestjs/common';
import { CHECK_URL_DISABLED } from 'src/common/constants/app';
import { TYPE_SITE } from 'src/common/constants/enum';
import { CrawlerRepository } from '../crawler.repository';

@Injectable()
export class CrawlerJavascriptService {
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
      const sites = await this.crawlerRepository.getSiteCrawlUrl(TYPE_SITE.NORMAL);
      for (const site of sites) {
        const urls = await this.getAllUrlsByBrowser({
          index: 0,
          url: site.url,
          list: [site.url],
          site: site,
        });
      }
      return sites;
    } catch (error) {
      console.log(error);
    }
  }

  async getAllUrlsByBrowser(param): Promise<[]> {
    const puppeteer = require('puppeteer-extra');
    const blockResourcesPlugin =
      require('puppeteer-extra-plugin-block-resources')();
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
    // blockResourcesPlugin.blockedTypes.add('document');
    // blockResourcesPlugin.blockedTypes.add('stylesheet');
    blockResourcesPlugin.blockedTypes.add('image');
    blockResourcesPlugin.blockedTypes.add('media');
    blockResourcesPlugin.blockedTypes.add('font');
    // blockResourcesPlugin.blockedTypes.add('script');
    blockResourcesPlugin.blockedTypes.add('texttrack');
    blockResourcesPlugin.blockedTypes.add('xhr');
    blockResourcesPlugin.blockedTypes.add('fetch');
    blockResourcesPlugin.blockedTypes.add('eventsource');
    blockResourcesPlugin.blockedTypes.add('websocket');
    blockResourcesPlugin.blockedTypes.add('manifest');
    blockResourcesPlugin.blockedTypes.add('other');
    const page = await browser.newPage();
    const currentUrl = new URL(param.url);
    await page.goto(param.url, {
      waitUntil: 'domcontentloaded',
    });
    console.log(param.url);
    // Get all urls in current page
    const hrefs = await page.$$eval('a', as => as.map(a => a.href));
    const uniqueHrefs = hrefs.filter((item, i, ar) => ar.indexOf(item) === i);
    // Check library disabled urls
    const disableUrls = [];
    for (let index = 0; index < uniqueHrefs.length; index++) {
      CHECK_URL_DISABLED.forEach(async (item) => {
        if (uniqueHrefs[index].indexOf(item) >= 0)
          disableUrls.push(uniqueHrefs[index]);
      });
    }
    const urlsAccept = uniqueHrefs.filter(x => !disableUrls.includes(x));

    // Get true urls
    const lists = urlsAccept.filter(i => i.includes(currentUrl.origin));
    for (const url of urlsAccept.filter(i => !i.includes(currentUrl.origin))) {
      if (this.isValidUrl(currentUrl.origin + url))
        lists.push(currentUrl.origin);
    }
    param.list = param.list.concat(lists).filter((item, i, ar) => ar.indexOf(item) === i);
    await browser.close();
    if (param.index + 1 != param.list.length) {
      await this.getAllUrlsByBrowser({
        index: param.index + 1,
        url: param.list[param.index + 1],
        list: param.list,
        page: page,
        site: param.site,
        browser: browser,
      });
    }
    await this.crawlerRepository.urlsBulkWriteByBrowser( param.list, param.site );
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
}
