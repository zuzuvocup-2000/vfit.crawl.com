import { Prop, Schema, SchemaFactory } from '@nestjs/mongoose';
import { Document } from 'mongoose';
import { CRITERIA_TYPE_ENUM, STATUS_STATISTIC } from 'src/common/constants/enum';

@Schema()
export class Criteria {

  @Prop({ required: true, enum: CRITERIA_TYPE_ENUM })
  typeCriteria: string;

  @Prop({ required: true })
  value: [];

  @Prop({ required: true, enum: STATUS_STATISTIC })
  typeStatistic: string;

  @Prop({ required: false, default: Date.now })
  createdAt: Date;

  @Prop({ required: false })
  updatedAt: Date;
}

export type CriteriaDocument = Criteria & Document;

export const CriteriaSchema = SchemaFactory.createForClass(Criteria);
