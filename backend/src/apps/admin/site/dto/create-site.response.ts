import { IsNotEmpty, IsNumber, IsString } from 'class-validator';
import { ApiProperty } from '@nestjs/swagger';
import { SuccessResponse } from '../../../../common/response/success.response';
import { SiteEntity } from 'src/common/entities/site.entity';

export class CreateSiteResponse extends SuccessResponse<SiteEntity> {
  @IsNotEmpty()
  @IsString()
  @ApiProperty()
  url: string;

  @IsNotEmpty()
  @IsNumber()
  @ApiProperty()
  status: string;

  @IsNotEmpty()
  @IsString()
  @ApiProperty()
  platform: string;

  @IsNotEmpty()
  @IsNumber()
  @ApiProperty()
  platformId: number;

  constructor(props) {
    super(props);
  }
}
