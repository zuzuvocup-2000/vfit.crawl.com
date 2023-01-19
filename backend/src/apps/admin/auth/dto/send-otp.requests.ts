import { IsDate, IsNotEmpty, IsString } from 'class-validator';
import { ApiProperty } from '@nestjs/swagger';

export class sendOtpRequest {
  @IsNotEmpty()
  @IsString()
  @ApiProperty({ required: true })
  email: string;

  @IsNotEmpty()
  @IsString()
  @ApiProperty({ required: true })
  otp: string;

  @IsNotEmpty()
  @IsDate()
  @ApiProperty({ required: true })
  otpLive: Date;
}
