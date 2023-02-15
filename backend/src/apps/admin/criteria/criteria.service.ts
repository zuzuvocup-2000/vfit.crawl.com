/* eslint-disable no-await-in-loop */
import { Injectable } from '@nestjs/common';
import { InjectModel } from '@nestjs/mongoose';
import { Model } from 'mongoose';
import { Criteria, CriteriaDocument } from './schema/criteria.schema';
import {
  DocumentCollector,
  CollectionResponse,
} from '@forlagshuset/nestjs-mongoose-paginate';
import { GetFilterDto } from 'src/common/params/get-filter.dto';
import { CreateCriteriaRequest } from './dto/create-criteria.request';
import { UpdateCriteriaRequest } from './dto/update-criteria.request';
import { GetPaginateDto } from 'src/common/params/get-paginate.dto';

@Injectable()
export class CriteriaService {
  constructor(
    @InjectModel(Criteria.name)
    private criteriaModel: Model<CriteriaDocument>,
  ) {}

  /**
   * Api get list criterias
   * @param filter
   * @param page
   * @param limit
   * @return array Criteria
   * */
  async paginate(
    getPaginateDto: GetPaginateDto,
  ): Promise<CollectionResponse<CriteriaDocument>> {
    const collector = new DocumentCollector<CriteriaDocument>(this.criteriaModel);
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

  /**
   * Api create criteria
   * @request CreateCriteriaRequest
   * @return criteria
   * */
  async upsert(createCriteriaRequest: CreateCriteriaRequest): Promise<unknown> {
    return await this.criteriaModel.updateOne(
      {
        typeStatistic: createCriteriaRequest['typeStatistic'],
        typeCriteria: createCriteriaRequest['typeCriteria'],
      },
      {
        $set: {
          typeStatistic: createCriteriaRequest['typeStatistic'],
          typeCriteria: createCriteriaRequest['typeCriteria'],
          value: createCriteriaRequest['value'],
        },
      },
      { upsert: true },
    );
  }

  /**
   * Api detail criteria
   * @params id
   * @return criteria
   * */
  async getById(id: string): Promise<CriteriaDocument> {
    const criteria = await this.criteriaModel.findById(id).exec();
    return criteria;
  }

  /**
   * Api detail criteria
   * @params id
   * @return criteria
   * */
  async getByType(
    createCriteriaRequest: CreateCriteriaRequest,
  ): Promise<CriteriaDocument> {
    const criteria = await this.criteriaModel
      .findOne({
        typeStatistic: createCriteriaRequest['typeStatistic'],
        typeCriteria: createCriteriaRequest['typeCriteria'],
      })
      .exec();
    return criteria;
  }

  /**
   * Api delete criteria
   * @params id
   * */
  async deleteById(id: string) {
    return await this.criteriaModel.findByIdAndRemove(id);
  }
}
