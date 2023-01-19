import { Expose, Transform } from 'class-transformer';
import { ApiProperty } from '@nestjs/swagger';
import { SuccessResponse } from 'src/common/response/success.response';
import { IsOptional } from 'class-validator';
import { CollectionResponse } from '@forlagshuset/nestjs-mongoose-paginate';
import { CriteriaDocument } from '../schema/criteria.schema';

export class SuccessCriteriaResponse extends SuccessResponse<CriteriaDocument> {
  @ApiProperty({
    default: [],
  })
  @Transform(({ value }) => {
    return value;
  })
  @IsOptional()
  @Expose({ name: 'data' })
  data: CollectionResponse<CriteriaDocument>;
}
