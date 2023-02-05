import { IsEmail, IsNotEmpty, IsString } from 'class-validator';
import { ApiProperty } from '@nestjs/swagger';
import { SuccessResponse } from '../../../../common/response/success.response';
import { UserEntity } from 'src/common/entities/user.entity';

export class UpdateUserRequest extends SuccessResponse<UserEntity> {
  @IsNotEmpty()
  @IsEmail()
  @ApiProperty()
  email: string;

  @IsNotEmpty()
  @IsEmail()
  @ApiProperty()
  newEmail: string;

  @IsNotEmpty()
  @IsString()
  @ApiProperty()
  name: string;

  constructor(props) {
    super(props);
  }
}
