/* eslint-disable no-await-in-loop */
import { Injectable } from '@nestjs/common';
import { InjectModel } from '@nestjs/mongoose';
import { Model } from 'mongoose';
import {
  DocumentCollector,
  CollectionResponse,
} from '@forlagshuset/nestjs-mongoose-paginate';
import { GetPaginateDto } from 'src/common/params/get-paginate.dto';
import { Statistic, StatisticDocument } from './schema/statistic.schema';

@Injectable()
export class StatisticService {
  constructor(
    @InjectModel(Statistic.name)
    private statisticModel: Model<StatisticDocument>,
  ) {}

  /**
   * Api get list statistic
   * @param filter
   * @param page
   * @param limit
   * @return array Statistic
   * */
  async paginate(
    getPaginateDto: GetPaginateDto,
  ): Promise<CollectionResponse<StatisticDocument>> {
    const collector = new DocumentCollector<StatisticDocument>(this.statisticModel);
    return collector.find({
      filter: {
        $or: [
          { typeStatistic: { $regex: new RegExp(getPaginateDto.keyword, 'i') } },
          { typeCriteria: { $regex: new RegExp(getPaginateDto.keyword, 'i') } }
        ]
      },
      page: getPaginateDto.page,
      limit: getPaginateDto.limit,
    });
  }
}
