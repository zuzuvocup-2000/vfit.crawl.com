import { Prop, Schema, SchemaFactory } from '@nestjs/mongoose';
import { Document } from 'mongoose';
import * as mongoose from 'mongoose';

@Schema()
export class Url {
  @Prop({ required: true, type: mongoose.Schema.Types.ObjectId })
  siteId: string;

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
  crawlerAt: Date;
}

export type UrlDocument = Url & Document;

export const UrlSchema = SchemaFactory.createForClass(Url);
