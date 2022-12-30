import { ApiProperty } from '@nestjs/swagger';
import { CODES } from '../constants/code';
import { ERROR_MESSAGE } from '../constants/messages/error';

export class BadRequestResponse {
  /**
   * @example 2000
   */
  @ApiProperty({ default: CODES.BAD_REQUEST })
  statusCode: number = CODES.BAD_REQUEST;

  /**
   * @example 'success'
   */
  @ApiProperty({ default: ERROR_MESSAGE.BAD_REQUEST })
  message: string = ERROR_MESSAGE.BAD_REQUEST;
}
