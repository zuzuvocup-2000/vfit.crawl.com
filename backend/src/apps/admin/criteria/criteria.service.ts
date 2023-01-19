/* eslint-disable no-await-in-loop */
import { Injectable } from '@nestjs/common';
import { InjectModel } from '@nestjs/mongoose';
import { Model } from 'mongoose';
import {
  Criteria,
  CriteriaDocument,
} from './schema/criteria.schema';
import {
  DocumentCollector,
  CollectionResponse,
} from '@forlagshuset/nestjs-mongoose-paginate';
import { GetFilterDto } from 'src/common/params/get-filter.dto';
import { CreateCriteriaRequest } from './dto/create-criteria.request';
import { UpdateCriteriaRequest } from './dto/update-criteria.request';

@Injectable()
export class CriteriaService {

  constructor(
    @InjectModel(Criteria.name)
    private criteriaModel: Model<CriteriaDocument>,
  ) {}

  /**
   * Api get list criteria
   * @param filter
   * @param page
   * @param limit
   * @return array Site
   * */
  async paginate(
    getFilterDto: GetFilterDto,
  ): Promise<CollectionResponse<CriteriaDocument>> {
    const collector = new DocumentCollector<CriteriaDocument>(
      this.criteriaModel,
    );
    return collector.find({
      filter: JSON.parse(getFilterDto.filter) || {},
      page: getFilterDto.page,
      limit: getFilterDto.limit,
    });
  }

  /**
   * Api create criteria
   * @request CreateCriteriaRequest
   * @return criteria
   * */
  async create(
    createCriteriaRequest: CreateCriteriaRequest,
  ): Promise<CriteriaDocument> {
    const createdCriteria = new this.criteriaModel(
      createCriteriaRequest,
    );
    return createdCriteria.save();
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
   * Api update criteria
   * @params id
   * @return criteria
   * */
  async update(
    id: string,
    updateCriteriaRequest: UpdateCriteriaRequest,
  ) {
    return await this.criteriaModel.updateOne(
      { _id: id },
      updateCriteriaRequest,
    );
  }

  /**
   * Api delete criteria
   * @params id
   * */
  async deleteById(id: string) {
    return await this.criteriaModel.findByIdAndRemove(id);
  }
}
