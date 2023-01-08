import { Prop, Schema, SchemaFactory } from '@nestjs/mongoose';
import mongoose, { Document } from 'mongoose';
import { TYPE_CRAWL } from 'src/common/constants/enum';

@Schema()
export class Site {
  @Prop({ required: false, type: mongoose.Schema.Types.ObjectId, ref: 'Site' })
  _id: string;

  @Prop({ required: true })
  url: string;

  @Prop({ required: true })
  status: number;

  @Prop({ required: false })
  sitemap: boolean;

  @Prop({ required: false, enum: TYPE_CRAWL })
  typeCrawl: string;

  @Prop({ required: false })
  isCrawl: boolean;

  @Prop({ required: false, default: Date.now })
  crawlUrlAt: Date;

  @Prop({ required: false, default: Date.now })
  createdAt: Date;

  @Prop({ required: false, default: Date.now })
  updatedAt: Date;

  @Prop({ required: false })
  crawlDataAt: Date;
}
export type SiteDocument = Site & Document;

export const SiteSchema = SchemaFactory.createForClass(Site);

