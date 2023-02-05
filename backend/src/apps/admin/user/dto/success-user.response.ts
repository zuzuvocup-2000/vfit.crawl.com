import { Expose, Transform } from 'class-transformer';
import { ApiProperty } from '@nestjs/swagger';
import { SuccessResponse } from 'src/common/response/success.response';
import { IsOptional } from 'class-validator';
import { CollectionResponse } from '@forlagshuset/nestjs-mongoose-paginate';
import { UserDocument } from '../schema/user.schema';

export class SuccessUserResponse extends SuccessResponse<UserDocument> {
  @ApiProperty({
    default: [],
  })
  @Transform(({ value }) => {
    return value;
  })
  @IsOptional()
  @Expose({ name: 'data' })
  data: CollectionResponse<UserDocument>;
}
