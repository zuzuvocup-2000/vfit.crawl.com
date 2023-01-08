/* eslint-disable @typescript-eslint/no-explicit-any */
import { Injectable } from '@nestjs/common';
import { InjectModel } from '@nestjs/mongoose';
import { Model } from 'mongoose';
import {
  Sitemap,
  SitemapDocument,
} from '../admin/sitemap/schema/sitemap.schema';
import { Site, SiteDocument } from '../admin/site/schema/site.schema';
import {
  ASC_FILTER,
  STATUS_ARTICLE,
  STATUS_SITE,
  STATUS_SITE_MAP,
  STATUS_URL,
} from 'src/common/constants/app';
import { Url, UrlDocument } from '../admin/sitemap/schema/url.schema';
import {
  CatalogueConfig,
  CatalogueConfigDocument,
} from '../admin/config-catalogue/schema/catalogue-config.schema';
import {
  Catalogue,
  CatalogueDocument,
} from '../admin/catalogue/schema/catalogue.schema';
import {
  ArticleConfig,
  ArticleConfigDocument,
} from '../admin/config-article/schema/article-config.schema';
import {
  Article,
  ArticleDocument,
} from '../admin/article/schema/article.schema';

@Injectable()
export class CrawlerRepository {
  constructor(
    @InjectModel(Sitemap.name) private sitemapModel: Model<SitemapDocument>,
    @InjectModel(Site.name) private siteModel: Model<SiteDocument>,
    @InjectModel(Url.name) private urlModel: Model<UrlDocument>,
    @InjectModel(Catalogue.name)
    private catalogueModel: Model<CatalogueDocument>,
    @InjectModel(Article.name)
    private articleModel: Model<ArticleDocument>,
    @InjectModel(CatalogueConfig.name)
    private catalogueConfigModel: Model<CatalogueConfigDocument>,
    @InjectModel(ArticleConfig.name)
    private articleConfigModel: Model<ArticleConfigDocument>,
  ) {}

  /*
   * get site
   * @return {site[]}
   */

  async getSiteCrawl(): Promise<Site[]> {
    try {
      return await this.siteModel
        .find({ status: STATUS_SITE.ACTIVE })
        .sort({ platformId: ASC_FILTER });
    } catch (error) {
      console.log(error);
    }
  }

  /*
   * get all urls
   * @return {url[]}
   */

  async getAllUrlsActive(): Promise<Url[]> {
    try {
      return await this.urlModel.find({ status: STATUS_URL.ACTIVE });
    } catch (error) {
      console.log(error);
    }
  }

  /*
   * get config catalogue
   * @return {url[]}
   */

  async getConfigCatalogueBySiteId(url: Url): Promise<any[]> {
    try {
      return await this.catalogueConfigModel.aggregate([
        { $match: { siteId: url.siteId } },
        {
          $group: {
            _id: '$group',
            records: { $push: '$$ROOT' }
          }
        },
      ]);
    } catch (error) {
      console.log(error);
    }
  }

  /*
   * get config article
   * @return {articleconfig[]}
   */

  async getConfigArticleBySiteId(url: Url): Promise<any[]> {
    try {
      // return await this.articleConfigModel.find({
      //   siteId: url.siteId,
      // });
      return await this.articleConfigModel.aggregate([
        { $match: { siteId: url.siteId } },
        {
          $group: {
            _id: '$group',
            records: { $push: '$$ROOT' }
          }
        },
      ]);
    } catch (error) {
      console.log(error);
    }
  }

  async upsertCatalogue(
    url: Url,
    result: any,
    _status: number,
  ): Promise<boolean> {
    try {
      await this.catalogueModel.updateOne(
        { urlId: url['_id'] },
        {
          $set: {
            siteId: url.siteId,
            urlId: url['_id'],
            url: url.url,
            title: result.title,
            status: STATUS_ARTICLE.ACTIVE,
          },
        },
        { upsert: true },
      );

      await this.updateStatusUrl(url.url, _status);
      console.log('upsert catalogue done');
      return true;
    } catch (error) {
      console.log(error);
    }
  }

  async upsertArticle(
    url: Url,
    result: any,
    _status: number,
  ): Promise<boolean> {
    try {
      await this.articleModel.updateOne(
        { urlId: url['_id'] },
        {
          $set: {
            siteId: url.siteId,
            urlId: url['_id'],
            url: url.url,
            title: result.title,
            content: (result.description ? result.description : '') + (result.content ? result.content : ''),
            urlImages: result.image ? result.image : [],
            status: STATUS_ARTICLE.ACTIVE,
          },
        },
        { upsert: true },
      );

      await this.updateStatusUrl(url.url, _status);
      console.log('upsert article done');
      return true;
    } catch (error) {
      console.log(error);
    }
  }

  async getSiteCrawlSitemap(): Promise<Site[]> {
    try {
      return await this.siteModel.find({
        status: STATUS_SITE.ACTIVE,
        // crawlSitemapAt: { $lte: date }
      });
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

  /**
   * Update Site With Sitemap.
   * @param {string} url site.
   * @param {boolean} sitemap site.
   * @return {boolean}
   */
  async updateSiteWithSitemap(
    url: string,
    statusSitemap: boolean,
  ): Promise<boolean> {
    try {
      await this.siteModel.updateOne(
        { url },
        {
          $set: {
            sitemap: statusSitemap,
            crawlSitemapAt: new Date(),
          },
        },
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
  async urlsBulkWrite(sitemaps, site: Site): Promise<boolean> {
    try {
      const updateSitemap = sitemaps.map(url => ({
        updateOne: {
          filter: {
            $and: [
              { siteId: site._id },
              { url: url.loc ? url.loc.replace('.gz', '') : url },
            ],
          },
          update: {
            $set: {
              siteId: site._id,
              url: url.loc ? url.loc.replace('.gz', '') : url,
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

  /** sitemaps */

  /**
   * Create or Update Sitemap.
   * @param {sitemaps} list sitemap.
   * @param {object} site info.
   * @return {boolean}
   */
  async sitemapBulkWrite(sitemaps, site: Site): Promise<boolean> {
    try {
      const updateSitemap = sitemaps.map(url => ({
        updateOne: {
          filter: { url: url.loc ? url.loc.replace('.gz', '') : url },
          update: {
            $set: {
              siteId: site._id,
              url: url.loc ? url.loc.replace('.gz', '') : url,
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
      await this.sitemapModel.updateOne({ url }, { $set: { status } });
    } catch (error) {
      console.log(error);
    }
  }

  /**
   * Update Status url.
   * @param {url} url.
   * @param {status} status.
   * @return {void}
   */
  async updateStatusUrl(url: string, status: number): Promise<void> {
    try {
      await this.urlModel.updateOne({ url }, { $set: { status } });
    } catch (error) {
      console.log(error);
    }
  }

  /**
   * Count Urls of site.
   * @return {any[]} count of urls
   */
  // eslint-disable-next-line @typescript-eslint/no-explicit-any
  async getGroupCoutUrlsOfSite(): Promise<any[]> {
    try {
      return await this.urlModel.aggregate([
        {
          $group: {
            _id: { siteId: '$siteId' },
            count: { $sum: 1 },
          },
        },
        {
          $lookup: {
            from: 'sites',
            localField: '_id.siteId',
            foreignField: '_id',
            as: 'site_details',
          },
        },
      ]);
    } catch (error) {
      console.log(error);
    }
  }
}
