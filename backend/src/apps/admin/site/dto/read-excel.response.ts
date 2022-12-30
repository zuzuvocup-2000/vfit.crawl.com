import { ApiProperty } from '@nestjs/swagger';
import { CODES } from 'src/common/constants/code';
import { SUCCESS_MESSAGE } from 'src/common/constants/messages/success';

export class ReadExcelSiteResponse {
  /**
   * @example 2000
   */
  @ApiProperty({ default: CODES.SUCCESS })
  statusCode: number;

  /**
   * @example 'success'
   */
  @ApiProperty({ default: SUCCESS_MESSAGE.DEFAULT })
  message: string;

}
