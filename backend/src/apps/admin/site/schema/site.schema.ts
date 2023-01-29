import { Prop, Schema, SchemaFactory } from '@nestjs/mongoose';
import { Document } from 'mongoose';
import { TYPE_CRAWL, TYPE_SITE } from 'src/common/constants/enum';

@Schema()
export class Site {

  @Prop({ required: true })
  url: string;

  @Prop({ required: true })
  status: number;

  @Prop({ required: false })
  sitemap: boolean;

  @Prop({ required: true, enum: TYPE_SITE })
  type: string;

  @Prop({ required: true, enum: TYPE_CRAWL })
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

