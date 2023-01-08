import { Expose, Transform } from 'class-transformer';
import { ApiProperty } from '@nestjs/swagger';
import { SuccessResponse } from 'src/common/response/success.response';
import { IsOptional } from 'class-validator';
import { CollectionResponse } from '@forlagshuset/nestjs-mongoose-paginate';
import { CatalogueConfigDocument } from '../schema/catalogue-config.schema';

export class SuccessCatalogueConfigResponse extends SuccessResponse<CatalogueConfigDocument> {
  @ApiProperty({
    default: [],
  })
  @Transform(({ value }) => {
    return value;
  })
  @IsOptional()
  @Expose({ name: 'data' })
  data: CollectionResponse<CatalogueConfigDocument>;
}
