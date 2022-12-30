import { ApiProperty } from '@nestjs/swagger';
import { CODES } from '../constants/code';
import { ERROR_MESSAGE } from '../constants/messages/error';

export class UnauthorizedResponse {
  /**
   * @example 2000
   */
  @ApiProperty({ default: CODES.UNAUTHENTICATED })
  statusCode: number;

  /**
   * @example 'success'
   */
  @ApiProperty({ default: ERROR_MESSAGE.INTERNAL_SERVER_ERROR })
  message: string;
}
