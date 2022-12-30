import { Prop, Schema, SchemaFactory } from '@nestjs/mongoose';
import mongoose, { Document } from 'mongoose';
import { TYPE_CRAWL } from 'src/common/constants/app';

@Schema()
export class Site {
  @Prop({ required: false, type: mongoose.Schema.Types.ObjectId, ref: 'Site' })
  _id: string

  @Prop({ required: true })
  url: string;

  @Prop({ required: true })
  status: number;

  @Prop({ required: false })
  sitemap: boolean;

  @Prop({ required: false })
  platform: string;

  @Prop({ required: false })
  updateBy: string;

  @Prop({ required: true })
  platformId: number;

  @Prop({ required: false, enum: TYPE_CRAWL })
  typeCrawl: string;

  @Prop({ required: true, default: Date.now })
  updatedAt: Date;

  @Prop({ required: true, default: Date.now })
  createdAt: Date;

  @Prop({ required: true, default: Date.now })
  crawlUrlAt: Date;

  @Prop({ required: true, default: Date.now })
  crawlSitemapAt: Date;
}
export type SiteDocument = Site & Document;

export const SiteSchema = SchemaFactory.createForClass(Site);

