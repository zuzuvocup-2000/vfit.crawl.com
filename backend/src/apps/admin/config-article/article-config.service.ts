/* eslint-disable no-await-in-loop */
import { Injectable } from '@nestjs/common';
import { InjectModel } from '@nestjs/mongoose';
import { Model } from 'mongoose';
import {
  ArticleConfig,
  ArticleConfigDocument,
} from './schema/article-config.schema';
import {
  DocumentCollector,
  CollectionResponse,
} from '@forlagshuset/nestjs-mongoose-paginate';
import { GetFilterDto } from 'src/common/params/get-filter.dto';
import { CreateArticleConfigRequest } from './dto/create-article-config.request';
import { UpdateArticleConfigRequest } from './dto/update-article-config.request';

@Injectable()
export class ArticleConfigService {

  constructor(
    @InjectModel(ArticleConfig.name)
    private articleConfigModel: Model<ArticleConfigDocument>,
  ) {}

  /**
   * Api get list articleConfig
   * @param filter
   * @param page
   * @param limit
   * @return array Site
   * */
  async paginate(
    getFilterDto: GetFilterDto,
  ): Promise<CollectionResponse<ArticleConfigDocument>> {
    const collector = new DocumentCollector<ArticleConfigDocument>(
      this.articleConfigModel,
    );
    return collector.find({
      filter: JSON.parse(getFilterDto.filter) || {},
      page: getFilterDto.page,
      limit: getFilterDto.limit,
    });
  }

  /**
   * Api create article config
   * @request CreateArticleConfigRequest
   * @return ArticleConfig
   * */
  async create(
    createArticleConfigRequest: CreateArticleConfigRequest,
  ): Promise<ArticleConfigDocument> {
    const createdArticleConfig = new this.articleConfigModel(
      createArticleConfigRequest,
    );
    return createdArticleConfig.save();
  }

  /**
   * Api detail article config
   * @params id
   * @return ArticleConfig
   * */
  async getById(id: string): Promise<ArticleConfigDocument> {
    const articleConfig = await this.articleConfigModel.findById(id).exec();
    return articleConfig;
  }

  /**
   * Api update article config
   * @params id
   * @return ArticleConfig
   * */
  async update(
    id: string,
    updateArticleConfigRequest: UpdateArticleConfigRequest,
  ) {
    return await this.articleConfigModel.updateOne(
      { _id: id },
      updateArticleConfigRequest,
    );
  }

  /**
   * Api delete article config
   * @params id
   * */
  async deleteById(id: string) {
    return await this.articleConfigModel.findByIdAndRemove(id);
  }
}
