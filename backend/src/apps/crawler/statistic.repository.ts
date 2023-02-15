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
import {
  Criteria,
  CriteriaDocument,
} from '../admin/criteria/schema/criteria.schema';
import { CRITERIA_TYPE_ENUM } from 'src/common/constants/enum';
import { Statistic, StatisticDocument } from '../admin/statistic/schema/statistic.schema';

@Injectable()
export class StatisticRepository {
  constructor(
    @InjectModel(Sitemap.name) private sitemapModel: Model<SitemapDocument>,
    @InjectModel(Site.name) private siteModel: Model<SiteDocument>,
    @InjectModel(Url.name) private urlModel: Model<UrlDocument>,
    @InjectModel(Catalogue.name)
    private catalogueModel: Model<CatalogueDocument>,
    @InjectModel(Article.name)
    private articleModel: Model<ArticleDocument>,
    @InjectModel(Criteria.name)
    private criteriaModel: Model<CriteriaDocument>,
    @InjectModel(CatalogueConfig.name)
    private catalogueConfigModel: Model<CatalogueConfigDocument>,
    @InjectModel(ArticleConfig.name)
    private articleConfigModel: Model<ArticleConfigDocument>,
    @InjectModel(Statistic.name)
    private statisticModel: Model<StatisticDocument>,
  ) {}

  /*
   * get all site
   * @return {site[]}
   */

  async getAllArticles(): Promise<Article[]> {
    try {
      return await this.articleModel
        .find({ status: STATUS_ARTICLE.ACTIVE })
        .select('title');
    } catch (error) {
      console.log(error);
    }
  }

  /*
   * get all site
   * @return {site[]}
   */

  async getAllArticlesByThread(threadNumber: number): Promise<Article[]> {
    try {
      return await this.articleModel.find({
        status: STATUS_ARTICLE.ACTIVE,
        threadNumber,
      });
    } catch (error) {
      console.log(error);
    }
  }

  /*
   * update thread number
   * @return {site[]}
   */

  async updateThreadNumberArticle(
    article: Article,
    threadNumber: number,
  ): Promise<void> {
    try {
      await this.articleModel.updateOne(
        { _id: article['_id'] },
        { $set: { threadNumber } },
      );
    } catch (error) {
      console.log(error);
    }
  }

  /*
   * get all criteria content
   * @return {site[]}
   */

  async getCriteriaContent(): Promise<Criteria[]> {
    try {
      return await this.criteriaModel.find({
        typeCriteria: CRITERIA_TYPE_ENUM.CONTENT,
      });
    } catch (error) {
      console.log(error);
    }
  }

  /*
   * get all criteria rate
   * @return {site[]}
   */

  async getCriteriaRate(): Promise<Criteria[]> {
    try {
      return await this.criteriaModel.find({
        typeCriteria: CRITERIA_TYPE_ENUM.RATE,
      });
    } catch (error) {
      console.log(error);
    }
  }

  /*
   * upsert statistic
   * @return {site[]}
   */

  async upsertStatistic(upsertData) {
    try {
      console.log(upsertData);
      await this.statisticModel.updateOne(
        { articleId: upsertData['articleId'], typeCriteria: upsertData['typeCriteria'] },
        {
          $set: upsertData,
        },
        { upsert: true },
      );
      console.log('upsert statistic done');
    } catch (error) {
      console.log(error);
    }
  }
}
