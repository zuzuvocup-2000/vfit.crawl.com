import {
  Controller,
  Get,
  Query,
  Post,
  Body,
  Delete,
  Param,
  Put,
  HttpStatus,
} from '@nestjs/common';
import { ArticleConfigService } from './article-config.service';
import {
  ApiBadRequestResponse,
  ApiResponse,
  ApiUnauthorizedResponse,
} from '@nestjs/swagger';
import { BadRequestResponse } from '../../../common/response/bad-request.response';
import { UnauthorizedResponse } from '../../../common/response/unauthorized.response';
import { SuccessResponse } from 'src/common/response/success.response';
import { CreateArticleConfigRequest } from './dto/create-article-config.request';
import { ERROR_MESSAGE } from 'src/common/constants/messages/error';
import { GetFilterDto } from './dto/get-filter.dto';
import { SuccessArticleConfigResponse } from './dto/success-article-config.response';
import { UpdateArticleConfigRequest } from './dto/update-article-config.request';

@Controller('article-config')
export class ArticleConfigController {
  constructor(private readonly articleConfigService: ArticleConfigService) {}

  /**
   * Api get list article config
   * @param filter
   * @param page
   * @param limit
   * @return array Site
   * */
  @Get()
  @ApiResponse({ status: HttpStatus.OK, type: SuccessArticleConfigResponse })
  @ApiBadRequestResponse({
    type: BadRequestResponse,
  })
  @ApiUnauthorizedResponse({ type: UnauthorizedResponse })
  async filterHandle(@Query() getFilterDto: GetFilterDto) {
    try {
      const articleConfigs = await this.articleConfigService.paginate(
        getFilterDto,
      );
      return new SuccessArticleConfigResponse(articleConfigs);
    } catch (error) {
      throw new Error(ERROR_MESSAGE.BAD_REQUEST);
    }
  }

  /**
   * Api get detail article config
   * @params id
   * @return articleConfig
   * */
  @Get(':id')
  @ApiResponse({ status: HttpStatus.OK, type: SuccessArticleConfigResponse })
  @ApiBadRequestResponse({
    type: BadRequestResponse,
  })
  @ApiUnauthorizedResponse({ type: UnauthorizedResponse })
  async get(@Param('id') id: string) {
    try {
      const articleConfig = await this.articleConfigService.getById(id);
      return new SuccessArticleConfigResponse(articleConfig);
    } catch (error) {
      throw new Error(ERROR_MESSAGE.BAD_REQUEST);
    }
  }

  /**
   * Api create article config
   * @request CreateArticleConfigRequest
   * @return ArticleConfig
   * */
  @Post()
  @ApiResponse({ status: HttpStatus.OK, type: SuccessArticleConfigResponse })
  @ApiBadRequestResponse({
    type: BadRequestResponse,
  })
  @ApiUnauthorizedResponse({ type: UnauthorizedResponse })
  async create(@Body() createArticleConfigRequest: CreateArticleConfigRequest) {
    const articleConfig = await this.articleConfigService.create(
      createArticleConfigRequest,
    );
    return new SuccessArticleConfigResponse(articleConfig);
  }

  /**
   * Api edit article config
   * @params id
   * @return ArticleConfig
   * */
  @Put(':id')
  @ApiResponse({ status: HttpStatus.OK, type: SuccessArticleConfigResponse })
  @ApiBadRequestResponse({
    type: BadRequestResponse,
  })
  @ApiUnauthorizedResponse({ type: UnauthorizedResponse })
  async update(
    @Param('id') id: string,
    @Body() updateArticleConfigRequest: UpdateArticleConfigRequest,
  ) {
    const updateArticleConfig = await this.articleConfigService.update(
      id,
      updateArticleConfigRequest,
    );
    if (!updateArticleConfig) throw new Error(ERROR_MESSAGE.NOT_FOUND);
    return new SuccessArticleConfigResponse(null);
  }

  /**
   * Api delete article config
   * @params id
   * */
  @Delete(':id')
  @ApiResponse({ status: HttpStatus.OK, type: SuccessResponse })
  @ApiBadRequestResponse({
    type: BadRequestResponse,
  })
  @ApiUnauthorizedResponse({ type: UnauthorizedResponse })
  async delete(@Param('id') id: string) {
    const deleteArticleConfig = await this.articleConfigService.deleteById(id);
    if (!deleteArticleConfig) throw new Error(ERROR_MESSAGE.NOT_FOUND);
    return new SuccessArticleConfigResponse(null);
  }
}
