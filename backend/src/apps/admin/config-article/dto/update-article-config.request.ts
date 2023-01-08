import { IsNotEmpty, IsString, IsEnum } from 'class-validator';
import { ApiProperty } from '@nestjs/swagger';
import {
  ARTICLE_CONFIG_TYPE_ENUM,
} from 'src/common/constants/enum';

export class UpdateArticleConfigRequest {

  @ApiProperty()
  @IsNotEmpty()
  @IsString()
  selector: string;

  @ApiProperty({
    enum: ARTICLE_CONFIG_TYPE_ENUM,
  })
  @IsNotEmpty()
  @IsEnum(ARTICLE_CONFIG_TYPE_ENUM)
  dataType: ARTICLE_CONFIG_TYPE_ENUM;
}
