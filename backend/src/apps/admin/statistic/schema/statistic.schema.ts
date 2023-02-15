import { Prop, Schema, SchemaFactory } from '@nestjs/mongoose';
import { Document } from 'mongoose';
import { Site } from '../../site/schema/site.schema';
import * as mongoose from 'mongoose';
import { Article } from '../../article/schema/article.schema';
import { Url } from '../../sitemap/schema/url.schema';
import { CRITERIA_TYPE_ENUM } from 'src/common/constants/enum';

@Schema()
export class Statistic {
  @Prop({ required: true, type: mongoose.Schema.Types.ObjectId, ref: 'Site' })
  siteId: Site;

  @Prop({ required: true, type: mongoose.Schema.Types.ObjectId, ref: 'Article' })
  articleId: Article;

  @Prop({ required: true, type: mongoose.Schema.Types.ObjectId, ref: 'Url' })
  urlId: Url;

  @Prop({ required: true, enum: CRITERIA_TYPE_ENUM })
  typeCriteria: string;

  @Prop({ required: true })
  bad: [];

  @Prop({ required: true })
  good: [];

  @Prop({ required: true })
  point: number;

  @Prop({ required: false, default: Date.now })
  createdAt: Date;
}

export type StatisticDocument = Statistic & Document;

export const StatisticSchema = SchemaFactory.createForClass(Statistic);
