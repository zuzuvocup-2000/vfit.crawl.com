import { IsNotEmpty, IsNumber, IsString } from 'class-validator';
import { ApiProperty } from '@nestjs/swagger';

export class UpdateSiteRequest {
  @IsNotEmpty()
  @IsString()
  @ApiProperty()
  url: string;

  @IsNotEmpty()
  @IsNumber()
  @ApiProperty()
  status: number;

  @IsNotEmpty()
  @IsString()
  @ApiProperty()
  platform: string;

  @IsNotEmpty()
  @IsNumber()
  @ApiProperty()
  platformId: number;
}
