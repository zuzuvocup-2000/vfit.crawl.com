/* eslint-disable @typescript-eslint/no-var-requires */
/* eslint-disable no-await-in-loop */
import { HttpService } from '@nestjs/axios';
import { Injectable } from '@nestjs/common';
import { TYPE_SITE } from 'src/common/constants/enum';
import { CrawlerRepository } from '../crawler.repository';
import { CheerioCrawler } from 'crawlee';
import { Site } from '../../admin/site/schema/site.schema';
import { Model } from 'mongoose';
import { Url, UrlDocument } from 'src/apps/admin/sitemap/schema/url.schema';
import { InjectModel } from '@nestjs/mongoose';
@Injectable()
export class CrawlerAllUrlsService {
  constructor(
    private readonly httpService: HttpService,
    private readonly crawlerRepository: CrawlerRepository,
    @InjectModel(Url.name) public urlModel: Model<UrlDocument>,
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
      const urlModel = this.urlModel;
      for (const site of sites) {
        const crawler = new CheerioCrawler({
          async requestHandler({ request, enqueueLinks }) {
            console.log(request.url);
            await urlModel.updateOne(
              { url: request.url },
              {
                $set: {
                  siteId: site['_id'],
                  url: request.url,
                },
              },
              { upsert: true },
            );
            await enqueueLinks();
          },
        });
        // Run the crawler with initial request
        await crawler.run([site.url]);
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
