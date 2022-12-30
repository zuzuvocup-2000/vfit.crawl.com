import { Prop, Schema, SchemaFactory } from '@nestjs/mongoose';
import { Document } from 'mongoose';
import { Site } from '../../site/schema/site.schema';
import * as mongoose from 'mongoose';

@Schema()
export class Sitemap {
  @Prop({ required: true, type: mongoose.Schema.Types.ObjectId, ref: 'Site' })
  siteId: Site;

  @Prop({ required: true })
  url: string;

  @Prop({ required: true })
  type: number;

  @Prop({ required: true })
  urlType: string;

  @Prop({ required: false, type: mongoose.Schema.Types.ObjectId })
  updatedBy: string;

  @Prop({ required: false })
  status: number;

  @Prop({ required: true, default: Date.now })
  updatedAt: Date;

  @Prop({ required: true, default: Date.now })
  createdAt: Date;
}

export type SitemapDocument = Sitemap & Document;

export const SitemapSchema = SchemaFactory.createForClass(Sitemap);
