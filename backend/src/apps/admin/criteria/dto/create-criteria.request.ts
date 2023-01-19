import { IsNotEmpty, IsEnum, IsArray } from 'class-validator';
import { ApiProperty } from '@nestjs/swagger';
import {
  CRITERIA_TYPE_ENUM,
  STATUS_STATISTIC
} from 'src/common/constants/enum';

export class CreateCriteriaRequest {

  @ApiProperty({
    enum: CRITERIA_TYPE_ENUM,
  })
  @IsNotEmpty()
  @IsEnum(CRITERIA_TYPE_ENUM)
  typeCriteria: CRITERIA_TYPE_ENUM;

  @ApiProperty()
  @IsNotEmpty()
  @IsArray()
  value: [];

  @ApiProperty({
    enum: STATUS_STATISTIC,
  })
  @IsNotEmpty()
  @IsEnum(STATUS_STATISTIC)
  typeStatistic: STATUS_STATISTIC;
}
