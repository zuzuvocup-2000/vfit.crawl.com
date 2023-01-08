import { Prop, Schema, SchemaFactory } from '@nestjs/mongoose';
import { Document } from 'mongoose';
import * as mongoose from 'mongoose';
import { ARTICLE_CONFIG_TYPE_ENUM } from 'src/common/constants/enum';

@Schema()
export class ArticleConfig {

  @Prop({ required: true, type: mongoose.Schema.Types.ObjectId })
  siteId: string;

  @Prop({ required: true })
  selector: string;

  @Prop({ required: true, enum: ARTICLE_CONFIG_TYPE_ENUM })
  dataType: string;

  @Prop({ required: true })
  group: number;

  @Prop({ required: false, default: Date.now })
  createdAt: Date;

  @Prop({ required: false })
  updatedAt: Date;
}

export type ArticleConfigDocument = ArticleConfig & Document;

export const ArticleConfigSchema = SchemaFactory.createForClass(ArticleConfig);
