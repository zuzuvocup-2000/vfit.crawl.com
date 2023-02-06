import {
  Controller,
  Body,
  Get,
  Post,
  Param,
  UseGuards,
  Query,
  HttpStatus,
  Delete,
} from '@nestjs/common';
import { UserService } from './user.service';
import {
  ApiBadRequestResponse,
  ApiResponse,
  refs,
} from '@nestjs/swagger';
import { BadRequestResponse } from '../../../common/response/bad-request.response';
import { CreateUserResponse } from './dto/create-user.response';
import { CreateUserRequest } from './dto/create-user.request';
import { AuthGuard } from '@nestjs/passport';
import { ChangePasswordUserRequest } from './dto/chang-password.request';
import { UpdateUserRequest } from './dto/update-user.request';
import { SuccessResponse } from 'src/common/response/success.response';
import { SUCCESS_MESSAGE } from 'src/common/constants/messages/success';
import { CODES } from 'src/common/constants/code';
import { GetPaginateDto } from 'src/common/params/get-paginate.dto';
import { SuccessUserResponse } from '../user/dto/success-user.response';
import { ERROR_MESSAGE } from 'src/common/constants/messages/error';
@Controller('users')
export class UserController {
  constructor(
    private readonly userService: UserService,
  ) {}

  /**
   * Api get list users
   * @param filter
   * @param page
   * @param limit
   * @return array Users
   * */
  @Get('/list')
  async filterHandle(@Query() getPaginateDto: GetPaginateDto) {
    const website = await this.userService.paginate(getPaginateDto);
    return {
      status: CODES.SUCCESS,
      message: SUCCESS_MESSAGE.DEFAULT,
      ...website,
    };
  }

  @UseGuards(AuthGuard('jwt'))
  @Get(':email')
  getUserByEmail(@Param() param) {
    return this.userService.getUserByEmail(param.email);
  }

  /**
   * Api get detail user
   * @params id
   * @return Site
   * */
  @Get('index/:id')
  @ApiResponse({ status: HttpStatus.OK, type: SuccessUserResponse })
  @UseGuards(AuthGuard('jwt'))
  @ApiBadRequestResponse({
    type: BadRequestResponse,
  })
  async get(@Param('id') id: string) {
    try {
      const site = await this.userService.getById(id);
      if (!site) throw new Error(ERROR_MESSAGE.NOT_FOUND);
      return new SuccessUserResponse(site);
    } catch (error) {
      throw new Error(ERROR_MESSAGE.BAD_REQUEST);
    }
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
  @UseGuards(AuthGuard('jwt'))
  @ApiResponse({ status: 200, type: CreateUserResponse })
  async signup(@Body() createUserRequest: CreateUserRequest) {
    return new CreateUserResponse(
      await this.userService.create(createUserRequest),
    );
  }

  @Post('/change-password')
  @ApiBadRequestResponse({
    schema: {
      oneOf: refs(BadRequestResponse),
    },
  })
  @UseGuards(AuthGuard('jwt'))
  @ApiResponse({ status: 200, type: CreateUserResponse })
  async changPassword(@Body() changePasswordUserRequest: ChangePasswordUserRequest) {
    return await this.userService.changePassword(changePasswordUserRequest);
  }

  @Post('/update-user')
  @ApiBadRequestResponse({
    schema: {
      oneOf: refs(BadRequestResponse),
    },
  })
  @UseGuards(AuthGuard('jwt'))
  @ApiResponse({ status: 200, type: CreateUserResponse })
  async updateUser(@Body() updateUserRequest: UpdateUserRequest) {
    return await this.userService.updateUser(updateUserRequest);
  }

  /**
   * Api delete product config
   * @params id
   * */
  @Delete(':id')
  @ApiResponse({ status: HttpStatus.OK, type: SuccessUserResponse })
  @ApiBadRequestResponse({
    type: BadRequestResponse,
  })
  @UseGuards(AuthGuard('jwt'))
  async delete(@Param('id') id: string) {
    const deleteUser = await this.userService.deleteById(id);
    if (!deleteUser) throw new Error(ERROR_MESSAGE.NOT_FOUND);
    return new SuccessUserResponse(null);
  }
}
