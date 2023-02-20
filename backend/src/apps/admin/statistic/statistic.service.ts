/* eslint-disable no-await-in-loop */
import { Injectable } from '@nestjs/common';
import { InjectModel } from '@nestjs/mongoose';
import { Model } from 'mongoose';
import { TYPE_CRITERIA } from 'src/common/constants/enum';
import { Article, ArticleDocument } from '../article/schema/article.schema';
import { GetPaginateDtoStatistic } from './dto/get-statistic.request';
import { Result, ResultDocument } from './schema/result.schema';
import { Statistic, StatisticDocument } from './schema/statistic.schema';

@Injectable()
export class StatisticService {
  constructor(
    @InjectModel(Result.name) private resultModel: Model<ResultDocument>,
    @InjectModel(Statistic.name) private statisticModel: Model<StatisticDocument>,
    @InjectModel(Article.name) private articleModel: Model<ArticleDocument>,
  ) {}

  /**
   * Api get list statistic
   * @param filter
   * @param page
   * @param limit
   * @return array Statistic
   * */
  async paginate(
    getPaginateDtoStatistic: GetPaginateDtoStatistic,
  ): Promise<unknown> {
    const page = getPaginateDtoStatistic.page || 1;
    const limit = getPaginateDtoStatistic.limit || 40;
    const skip = (page) * limit;

    let filter = {};

    switch (getPaginateDtoStatistic.point) {
      case 'good':
        filter = { point: { $gt: 7 } };
        break;
      case 'bad':
        filter = { point: { $lt: 4 } };
        break;
      case 'normal':
        filter = { point: { $gt: 4, $lt: 7 } };
        break;
      default:
        break;
    }
    const query = this.resultModel.find(filter).populate('articleId').sort({ articleId: 'asc' }).skip(skip).limit(limit);
    const results = await query.exec();
    const total = await this.resultModel.countDocuments(query.getFilter());

    return {
      total,
      page,
      limit,
      data: results,
    };
  }

  /**
   * Api get Article
   * @param id
   * @return array Statistic
   * */
  async getArticle(
    id: string,
  ): Promise<Article> {
    return await this.articleModel.findOne({ _id: id });
  }

  async calculateStatistic(): Promise<unknown> {
    const list = await this.statisticModel.aggregate([
      { $group: { _id: '$articleId', records: { $push: '$$ROOT' } } }
    ]);

    list.forEach(async (listItem) => {
      const record = listItem.records;
      const result = {
        siteId: record[0].siteId,
        urlId: record[0].urlId,
        articleId: record[0].articleId,
        bad: {
          'rate': (record[0].typeCriteria == TYPE_CRITERIA.CONTENT ? record[1].bad : record[0].bad),
          'content': (record[0].typeCriteria == TYPE_CRITERIA.CONTENT ? record[0].bad : record[1].bad),
        },
        good: {
          'rate': (record[0].typeCriteria == TYPE_CRITERIA.CONTENT ? record[1].good : record[0].good),
          'content': (record[0].typeCriteria == TYPE_CRITERIA.CONTENT ? record[0].good : record[1].good),
        },
        point: ((record[0].point + record[1].point) / 2),
      };

      await this.resultModel.updateOne(
        { articleId: result['articleId'] },
        {
          $set: result,
        },
        { upsert: true },
      );
    });
    return list;
  }
}
