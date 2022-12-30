import { CollectionResponse } from '@forlagshuset/nestjs-mongoose-paginate';
import { ApiProperty } from '@nestjs/swagger';
import { CODES } from '../constants/code';
import { SUCCESS_MESSAGE } from '../constants/messages/success';

export class SuccessResponse<T> {
  /**
   * @example 2000
   */
  @ApiProperty({ default: CODES.SUCCESS })
  statusCode: number = CODES.SUCCESS;

  /**
   * @example 'success'
   */
  @ApiProperty({ default: SUCCESS_MESSAGE.DEFAULT })
  message: string = SUCCESS_MESSAGE.DEFAULT;

  @ApiProperty({ default: [] })
  data: T | T[] | CollectionResponse<T>;

  constructor(data: T | T[] | CollectionResponse<T>) {
    this.data = data;
  }
}
