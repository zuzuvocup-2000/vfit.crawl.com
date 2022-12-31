import {
  Controller,
  Body,
  Get,
  Post,
  Param,
  UseGuards,
} from '@nestjs/common';
import { UserService } from './user.service';
import {
  ApiBadRequestResponse,
  ApiResponse,
  ApiUnauthorizedResponse,
  refs,
} from '@nestjs/swagger';
import { BadRequestResponse } from '../../../common/response/bad-request.response';
import { CreateUserResponse } from './dto/create-user.response';
import { UnauthorizedResponse } from '../../../common/response/unauthorized.response';
import { CreateUserRequest } from './dto/create-user.request';
import { AuthGuard } from '@nestjs/passport';

@Controller('users')
export class UserController {
  constructor(
    private readonly userService: UserService,
  ) {}

  @UseGuards(AuthGuard('jwt'))
  @Get(':email')
  getUserByEmail(@Param() param) {
    return this.userService.getUserByEmail(param.email);
  }

  @Get()
  async index() {
    return await this.userService.findAll();
  }

  @Post('/signup')
  @ApiBadRequestResponse({
    schema: {
      oneOf: refs(BadRequestResponse),
    },
  })
  @ApiUnauthorizedResponse({ type: UnauthorizedResponse })
  @ApiResponse({ status: 200, type: CreateUserResponse })
  async signup(@Body() createUserRequest: CreateUserRequest) {
    return new CreateUserResponse(
      await this.userService.create(createUserRequest),
    );
  }
}
