import { IsNotEmpty, IsNumber, IsString } from 'class-validator';
import { ApiProperty } from '@nestjs/swagger';
import { PAGINATE_DEFAULT } from '../constants/app';

export class GetPaginateDto {
  @IsString()
  @ApiProperty({
    default: '',
  })
  keyword: string;

  @IsNotEmpty()
  @IsNumber()
  @ApiProperty({
    default: PAGINATE_DEFAULT.page,
  })
  page: number;

  @IsNotEmpty()
  @IsNumber()
  @ApiProperty({
    default: PAGINATE_DEFAULT.limit,
  })
  limit: number;
}
