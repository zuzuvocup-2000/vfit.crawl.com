import { IsEnum, IsNotEmpty, IsNumber, IsString } from 'class-validator';
import { ApiProperty } from '@nestjs/swagger';
import { TYPE_CRAWL, TYPE_SITE } from 'src/common/constants/enum';

export class CreateSiteRequest {
  @IsNotEmpty()
  @IsString()
  @ApiProperty()
  url: string;

  @ApiProperty({
    enum: TYPE_SITE,
  })
  @IsNotEmpty()
  @IsEnum(TYPE_SITE)
  type: TYPE_SITE;

  @ApiProperty({
    enum: TYPE_CRAWL,
  })
  @IsNotEmpty()
  @IsEnum(TYPE_CRAWL)
  typeCrawl: TYPE_CRAWL;

  @IsNotEmpty()
  @IsNumber()
  @ApiProperty()
  status: number;
}
