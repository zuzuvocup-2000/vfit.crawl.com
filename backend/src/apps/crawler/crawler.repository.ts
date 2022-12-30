import { Injectable } from '@nestjs/common';
import { InjectModel } from '@nestjs/mongoose';
import { Model, Types } from 'mongoose';
import {
  Sitemap,
  SitemapDocument,
} from '../admin/sitemap/schema/sitemap.schema';
import { Site, SiteDocument } from '../admin/site/schema/site.schema';
import { ASC_FILTER, NUMBER_DATE_LOOP_CRAWL_PRODUCT, NUMBER_DATE_LOOP_CRAWL_SITEMAP, STATUS_SITE, STATUS_SITE_MAP, TYPE_CRAWL } from 'src/common/constants/app';
import { Url, UrlDocument } from '../admin/sitemap/schema/url.schema';

@Injectable()
export class CrawlerRepository {
  constructor(
    @InjectModel(Sitemap.name) private sitemapModel: Model<SitemapDocument>,
    @InjectModel(Site.name) private siteModel: Model<SiteDocument>,
    @InjectModel(Url.name) private urlModel: Model<UrlDocument>,
  ) { }

  /** sites  */

  async getSiteCrawl(): Promise<Site[]> {
    try {
      return await this.siteModel.find({ status: STATUS_SITE.ACTIVE }).sort({ platformId: ASC_FILTER });
    } catch (error) {
    }
  }

  async getSiteCrawlSitemap(): Promise<Site[]> {
    let date = new Date();
    date.setDate(date.getDate() - NUMBER_DATE_LOOP_CRAWL_SITEMAP);
    try {
      return await this.siteModel.find(
        {
          status: STATUS_SITE.ACTIVE,
          // crawlSitemapAt: { $lte: date }
        }
      );
    } catch (error) {
      console.log(error);
    }
  }

  /**
   * Get all sitemaps pending
   * @return {array} Sitemap[]
   */
  async getSitePendingCrawl(): Promise<Sitemap[]> {
    try {
      return await this.sitemapModel.aggregate([
        {
          $match: {
            status: STATUS_SITE_MAP.PENDING,
          },
        },
        {
          $lookup: {
            from: 'sites',
            localField: 'siteId',
            foreignField: '_id',
            as: 'site',
          },
        },
      ]);
    } catch (error) {
      console.log(error);
    }
  }

  async updateManySite() {
    let date = new Date();
    date.setDate(date.getDate() - NUMBER_DATE_LOOP_CRAWL_SITEMAP);
    try {
      return await this.siteModel.updateMany(
        {},
        {
          $set: {
            status: STATUS_SITE_MAP.ACTIVE,
            crawlUrlAt: date,
            crawlSitemapAt: date,
            typeCrawl: TYPE_CRAWL.HTTP_REQUEST,
            sitemap: true,
          }
        }
      )
    } catch (error) {
      console.log(error);
    }
  }

  /**
   * Update Site With Sitemap.
   * @param {string} url site.
   * @param {boolean} sitemap site.
   * @return {boolean}
   */
  async updateSiteWithSitemap(url: string, statusSitemap: boolean): Promise<boolean> {
    try {
      await this.siteModel.updateOne(
        { url },
        {
          $set: {
            sitemap: statusSitemap,
            crawlSitemapAt: new Date()
          }
        }
        ,
      );
      return true;
    } catch (error) {
      console.log(error);
    }
  }

  /** urls */

  /**
   * Create or Update Urls.
   * @param {sitemaps} list sitemap.
   * @param {object} site info.
   * @param {type} type sitemap.
   * @return {boolean}
   */
  async urlsBulkWrite(sitemaps, site: Site, type: number): Promise<boolean> {
    let date = new Date();
    date.setDate(date.getDate() - NUMBER_DATE_LOOP_CRAWL_PRODUCT);
    try {
      const updateSitemap = sitemaps.map(url => ({
        updateOne: {
          filter: {
            $and: [
              { siteId: site._id },
              { url: url.loc ? url.loc.replace('.gz', '') : url },
            ]
          },
          update: {
            $set: {
              siteId: site._id,
              url: url.loc ? url.loc.replace('.gz', '') : url,
              urlType: url.loc ? url.loc.replace('.gz', '') : url,
              status: STATUS_SITE_MAP.ACTIVE,
              crawlerAt: date,
              type,
            },
          },
          upsert: true,
        },
      }));
      await this.urlModel.bulkWrite(updateSitemap);
      return true;
    } catch (error) {
      console.log(error);
    }
  }

  /**
    * Update many Status Url.
    * @param {urls} list url.
    * @return {void}
  */
  async updateManyStatusUrl(urls: string[]): Promise<void> {
    try {
      await this.urlModel.updateMany(
        { url: urls },
        { $set: { status: STATUS_SITE_MAP.INACTIVE } },
      );
    } catch (error) {
      console.log(error);
    }
  }

  /** sitemaps */

  /**
   * Create or Update Sitemap.
   * @param {sitemaps} list sitemap.
   * @param {object} site info.
   * @param {type} type sitemap.
   * @return {boolean}
   */
  async sitemapBulkWrite(sitemaps, site: Site, type: number): Promise<boolean> {
    try {
      const updateSitemap = sitemaps.map(url => ({
        updateOne: {
          filter: { url: url.loc ? url.loc.replace('.gz', '') : url },
          update: {
            $set: {
              siteId: site._id,
              url: url.loc ? url.loc.replace('.gz', '') : url,
              urlType: url.loc ? url.loc.replace('.gz', '') : url,
              status: STATUS_SITE_MAP.ACTIVE,
              type,
            },
          },
          upsert: true,
        },
      }));
      await this.sitemapModel.bulkWrite(updateSitemap);
      return true;
    } catch (error) {
      console.log(error);
    }
  }

  /**
   * Update Status Sitemap.
   * @param {url} list sitemap.
   * @param {status} status.
   * @return {void}
   */
  async updateStatusSitemap(url: string, status: number): Promise<void> {
    try {
      await this.sitemapModel.updateOne(
        { url },
        { $set: { status } },
      );
    } catch (error) {
      console.log(error);
    }
  }
  /**
    * Count Urls of site.
    * @return {any[]} count of urls
  */
  async getGroupCoutUrlsOfSite(): Promise<any[]> {
    try {
      return await this.urlModel.aggregate([
        {
          $group: {
            _id: { siteId: "$siteId" },
            count: { $sum: 1 }
          }
        },
        {
          $lookup:
          {
            from: "sites",
            localField: "_id.siteId",
            foreignField: "_id",
            as: "site_details"
          }
        }
      ])
    } catch (error) {
      console.log(error);
    }
  }
}
