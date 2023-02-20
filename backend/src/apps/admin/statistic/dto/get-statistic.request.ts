import { IsNotEmpty, IsNumber, IsString } from 'class-validator';
import { ApiProperty } from '@nestjs/swagger';
import { PAGINATE_DEFAULT } from 'src/common/constants/app';

export class GetPaginateDtoStatistic {
  @IsString()
  @ApiProperty({
    default: '',
  })
  point: string;

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
