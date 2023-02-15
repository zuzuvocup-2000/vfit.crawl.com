/* eslint-disable no-await-in-loop */
import { Injectable } from '@nestjs/common';
import { InjectModel } from '@nestjs/mongoose';
import { Model } from 'mongoose';
import {
  CatalogueConfig,
  CatalogueConfigDocument,
} from './schema/catalogue-config.schema';
import {
  DocumentCollector,
  CollectionResponse,
} from '@forlagshuset/nestjs-mongoose-paginate';
import { GetFilterDto } from 'src/common/params/get-filter.dto';
import { CreateCatalogueConfigRequest } from './dto/create-catalogue-config.request';
import { UpdateCatalogueConfigRequest } from './dto/update-catalogue-config.request';
import { GetPaginateDto } from 'src/common/params/get-paginate.dto';

@Injectable()
export class CatalogueConfigService {

  constructor(
    @InjectModel(CatalogueConfig.name)
    private catalogueConfigModel: Model<CatalogueConfigDocument>,
  ) {}

  /**
   * Api get list users
   * @param filter
   * @param page
   * @param limit
   * @return array User
   * */
  async paginateBySiteId(
    id, getPaginateDto: GetPaginateDto
  ): Promise<CollectionResponse<CatalogueConfigDocument>> {
    const collector = new DocumentCollector<CatalogueConfigDocument>(this.catalogueConfigModel);
    return collector.find({
      filter: {
        $or: [
          { selector: { $regex: new RegExp(getPaginateDto.keyword, 'i') } },
        ],
        siteId: id
      },
      page: getPaginateDto.page,
      limit: getPaginateDto.limit,
    });
  }

  /**
   * Api get list catalogueConfig
   * @param filter
   * @param page
   * @param limit
   * @return array Site
   * */
  async paginate(
    getFilterDto: GetFilterDto,
  ): Promise<CollectionResponse<CatalogueConfigDocument>> {
    const collector = new DocumentCollector<CatalogueConfigDocument>(
      this.catalogueConfigModel,
    );
    return collector.find({
      filter: JSON.parse(getFilterDto.filter) || {},
      page: getFilterDto.page,
      limit: getFilterDto.limit,
    });
  }

  /**
   * Api create catalogue config
   * @request CreateCatalogueConfigRequest
   * @return catalogueConfig
   * */
  async create(
    createCatalogueConfigRequest: CreateCatalogueConfigRequest,
  ): Promise<CatalogueConfigDocument> {
    const createdCatalogueConfig = new this.catalogueConfigModel(
      createCatalogueConfigRequest,
    );
    return createdCatalogueConfig.save();
  }

  /**
   * Api detail catalogue config
   * @params id
   * @return CatalogueConfig
   * */
  async getById(id: string): Promise<CatalogueConfigDocument> {
    const catalogueConfig = await this.catalogueConfigModel.findById(id).exec();
    return catalogueConfig;
  }

  /**
   * Api update catalogue config
   * @params id
   * @return catalogueConfig
   * */
  async update(
    id: string,
    updateCatalogueConfigRequest: UpdateCatalogueConfigRequest,
  ) {
    return await this.catalogueConfigModel.updateOne(
      { _id: id },
      updateCatalogueConfigRequest,
    );
  }

  /**
   * Api delete catalogue config
   * @params id
   * */
  async deleteById(id: string) {
    return await this.catalogueConfigModel.findByIdAndRemove(id);
  }
}
