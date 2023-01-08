import { IsNotEmpty, IsString, IsEnum } from 'class-validator';
import { ApiProperty } from '@nestjs/swagger';
import {
  CATALOGUE_CONFIG_TYPE_ENUM,
} from 'src/common/constants/enum';

export class UpdateCatalogueConfigRequest {

  @ApiProperty()
  @IsNotEmpty()
  @IsString()
  selector: string;

  @ApiProperty({
    enum: CATALOGUE_CONFIG_TYPE_ENUM,
  })
  @IsNotEmpty()
  @IsEnum(CATALOGUE_CONFIG_TYPE_ENUM)
  dataType: CATALOGUE_CONFIG_TYPE_ENUM;
}
