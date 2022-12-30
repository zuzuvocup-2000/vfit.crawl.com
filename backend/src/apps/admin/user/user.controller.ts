import { Controller, Body, Get, Post } from '@nestjs/common';
import { UserService } from './user.service';
import { CreateUserRequest } from './dto/create-user.request';
import {
  ApiBadRequestResponse,
  ApiResponse,
  ApiUnauthorizedResponse,
  refs,
} from '@nestjs/swagger';
import { BadRequestResponse } from '../../../common/response/bad-request.response';
import { CreateUserResponse } from './dto/create-user.response';
import { UnauthorizedResponse } from '../../../common/response/unauthorized.response';

@Controller('users')
export class UserController {
  constructor(private readonly userService: UserService) {}

  @Get()
  async index() {
    return await this.userService.findAll();
  }

  @Post()
  @ApiBadRequestResponse({
    schema: {
      oneOf: refs(BadRequestResponse),
    },
  })
  @ApiUnauthorizedResponse({ type: UnauthorizedResponse })
  @ApiResponse({ status: 200, type: CreateUserResponse })
  async create(@Body() createUserRequest: CreateUserRequest) {
    return new CreateUserResponse(
      await this.userService.create(createUserRequest),
    );
  }
}
