/* eslint-disable no-await-in-loop */
import { Injectable } from '@nestjs/common';
import { InjectModel } from '@nestjs/mongoose';
import { Model } from 'mongoose';
import {
  Article,
  ArticleDocument,
} from './schema/article.schema';

@Injectable()
export class ArticleService {

  constructor(
    @InjectModel(Article.name)
    private ArticleModel: Model<ArticleDocument>,
  ) {}
}
