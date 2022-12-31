import { IsNotEmpty, IsString } from 'class-validator';
import { ApiProperty } from '@nestjs/swagger';

export class CreateUserRequest {
  @IsNotEmpty()
  @IsString()
  @ApiProperty({ required: true })
  name: string;

  @IsNotEmpty()
  @IsString()
  @ApiProperty({ required: true })
  email: string;

  @IsNotEmpty()
  @IsString()
  @ApiProperty({ required: true })
  password: string;
}
