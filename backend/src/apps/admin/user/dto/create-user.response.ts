import { IsNotEmpty, IsString } from 'class-validator';
import { ApiProperty } from '@nestjs/swagger';
import { SuccessResponse } from '../../../../common/response/success.response';
import { UserEntity } from 'src/common/entities/user.entity';

export class CreateUserResponse extends SuccessResponse<UserEntity> {
  @IsNotEmpty()
  @IsString()
  @ApiProperty()
  name: string;

  @IsNotEmpty()
  @IsString()
  @ApiProperty()
  email: string;

  @IsNotEmpty()
  @IsString()
  @ApiProperty()
  password: string;

  constructor(props) {
    super(props);
  }
}
