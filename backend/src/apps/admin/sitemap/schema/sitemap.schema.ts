import { Prop, Schema, SchemaFactory } from '@nestjs/mongoose';
import { Document } from 'mongoose';
import { Site } from '../../site/schema/site.schema';
import * as mongoose from 'mongoose';
import { STATUS_SITE_MAP } from 'src/common/constants/app';

@Schema()
export class Sitemap {
  @Prop({ required: true, type: mongoose.Schema.Types.ObjectId, ref: 'Site' })
  siteId: Site;

  @Prop({ required: true })
  url: string;

  @Prop({ required: true, default: STATUS_SITE_MAP.ACTIVE })
  status: number;

  @Prop({ required: false, default: Date.now })
  createdAt: Date;

  @Prop({ required: false })
  updatedAt: Date;
}

export type SitemapDocument = Sitemap & Document;

export const SitemapSchema = SchemaFactory.createForClass(Sitemap);
