import { IsNotEmpty, IsNumber, IsOptional } from 'class-validator';
import { ApiProperty, ApiPropertyOptional } from '@nestjs/swagger';
import { PAGINATE_DEFAULT } from 'src/common/constants/app';

export class GetFilterDto {
  @IsOptional()
  @ApiPropertyOptional({
    default: '{"siteId":{"$eq":"63590adbd861a3816f09f330"}}',
    required: false,
  })
  filter: string;

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
