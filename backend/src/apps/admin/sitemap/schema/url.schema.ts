import { Prop, Schema, SchemaFactory } from '@nestjs/mongoose';
import { Document } from 'mongoose';
import * as mongoose from 'mongoose';
import { STATUS_URL } from 'src/common/constants/app';

@Schema()
export class Url {
  @Prop({ required: true, type: mongoose.Schema.Types.ObjectId })
  siteId: string;

  @Prop({ required: true })
  url: string;

  @Prop({ required: false, default: STATUS_URL.ACTIVE })
  status: number;

  @Prop({ required: true, default: false })
  isCrawl: boolean;

  @Prop({ required: true, default: Date.now })
  createdAt: Date;
}

export type UrlDocument = Url & Document;

export const UrlSchema = SchemaFactory.createForClass(Url);
