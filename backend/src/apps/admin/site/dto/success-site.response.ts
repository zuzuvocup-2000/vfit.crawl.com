import { Expose, Transform } from 'class-transformer';
import { ApiProperty } from '@nestjs/swagger';
import { SuccessResponse } from 'src/common/response/success.response';
import { IsOptional } from 'class-validator';
import { CollectionResponse } from '@forlagshuset/nestjs-mongoose-paginate';
import { SiteDocument } from '../schema/site.schema';

export class SuccessSiteResponse extends SuccessResponse<SiteDocument> {
  @ApiProperty({
    default: [],
  })
  @Transform(({ value }) => {
    return value;
  })
  @IsOptional()
  @Expose({ name: 'data' })
  data: CollectionResponse<SiteDocument>;
}
