/* eslint-disable @typescript-eslint/no-var-requires */
/* eslint-disable no-await-in-loop */
import { HttpService } from '@nestjs/axios';
import { Injectable } from '@nestjs/common';
import { TYPE_SITE } from 'src/common/constants/enum';
import { CrawlerRepository } from '../crawler.repository';
import { CheerioCrawler } from 'crawlee';
import { Site } from '../../admin/site/schema/site.schema';
@Injectable()
export class CrawlerAllUrlsService {
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
      const hrefs = [];
      for (const site of sites) {
        const crawler = new CheerioCrawler({
          async requestHandler({ request, enqueueLinks, log }) {
            log.info(request.url);
            hrefs.push(request.url);
            // Add all links from page to RequestQueue
            await enqueueLinks();
          },
        });
        // Run the crawler with initial request
        await crawler.run([site.url]);
        if (hrefs.length > 0) await this.urlsBulkWriteUrl(hrefs, site);
      }
      return hrefs;
    } catch (error) {
      console.log(error);
    }
  }

  /*
   * Upsert all urls.
   * @param {urls} list urls.
   * @param {object} site info.
   * @return {void}
   */
  async urlsBulkWriteUrl(urls, site: Site): Promise<void> {
    try {
      await this.crawlerRepository.urlsBulkWriteByBrowser(urls, site);
    } catch (error) {
      console.log(error);
    }
  }
}
