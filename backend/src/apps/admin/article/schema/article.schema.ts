import { Prop, Schema, SchemaFactory } from '@nestjs/mongoose';
import { Document } from 'mongoose';
import * as mongoose from 'mongoose';

@Schema()
export class Article {
  @Prop({ required: true, type: mongoose.Schema.Types.ObjectId })
  siteId: string;

  @Prop({ required: false, type: mongoose.Schema.Types.ObjectId })
  catalogueId: string;

  @Prop({ required: true, type: mongoose.Schema.Types.ObjectId })
  urlId: string;

  @Prop({ required: true })
  url: string;

  @Prop({ required: true })
  title: string;

  @Prop({ required: false })
  content: string;

  @Prop({ required: false })
  review: string;

  @Prop({ required: false })
  urlImages: [];

  @Prop({ required: true })
  status: number;

  @Prop({ required: false, default: Date.now })
  createdAt: Date;
}

export type ArticleDocument = Article & Document;

export const ArticleSchema = SchemaFactory.createForClass(Article);
