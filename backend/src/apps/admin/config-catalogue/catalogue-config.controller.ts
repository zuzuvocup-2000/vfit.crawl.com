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
import { CatalogueConfigService } from './catalogue-config.service';
import {
  ApiBadRequestResponse,
  ApiResponse,
  ApiUnauthorizedResponse,
} from '@nestjs/swagger';
import { BadRequestResponse } from '../../../common/response/bad-request.response';
import { UnauthorizedResponse } from '../../../common/response/unauthorized.response';
import { SuccessResponse } from 'src/common/response/success.response';
import { CreateCatalogueConfigRequest } from './dto/create-catalogue-config.request';
import { ERROR_MESSAGE } from 'src/common/constants/messages/error';
import { GetFilterDto } from './dto/get-filter.dto';
import { SuccessCatalogueConfigResponse } from './dto/success-catalogue-config.response';
import { UpdateCatalogueConfigRequest } from './dto/update-catalogue-config.request';
import { GetPaginateDto } from 'src/common/params/get-paginate.dto';
import { CODES } from 'src/common/constants/code';
import { SUCCESS_MESSAGE } from 'src/common/constants/messages/success';

@Controller('catalogue-config')
export class CatalogueConfigController {
  constructor(private readonly catalogueConfigService: CatalogueConfigService) {}

  /**
   * Api get /:id catalogue config
   * @param filter
   * @param page
   * @param limit
   * @return array Site
   * */
  @Get()
  @ApiResponse({ status: HttpStatus.OK, type: SuccessCatalogueConfigResponse })
  @ApiBadRequestResponse({
    type: BadRequestResponse,
  })
  @ApiUnauthorizedResponse({ type: UnauthorizedResponse })
  async filterHandle(@Query() getFilterDto: GetFilterDto) {
    try {
      const catalogueConfigs = await this.catalogueConfigService.paginate(
        getFilterDto,
      );
      return new SuccessCatalogueConfigResponse(catalogueConfigs);
    } catch (error) {
      throw new Error(ERROR_MESSAGE.BAD_REQUEST);
    }
  }

  /**
   * Api get list catalogue config by id site
   * @param filter
   * @param page
   * @param limit
   * @return array Site
   * */
  @Get('list/:id')
  @ApiResponse({ status: HttpStatus.OK, type: SuccessCatalogueConfigResponse })
  @ApiBadRequestResponse({
    type: BadRequestResponse,
  })
  @ApiUnauthorizedResponse({ type: UnauthorizedResponse })
  async filterListBySiteId(@Query() GetPaginateDto: GetPaginateDto, @Param('id') id: string) {
    try {
      const catalogueConfigs = await this.catalogueConfigService.paginateBySiteId(
        id, GetPaginateDto
      );
      return {
        status: CODES.SUCCESS,
        message: SUCCESS_MESSAGE.DEFAULT,
        ...catalogueConfigs,
      };
    } catch (error) {
      throw new Error(ERROR_MESSAGE.BAD_REQUEST);
    }
  }

  /**
   * Api get detail catalogue config
   * @params id
   * @return catalogueConfig
   * */
  @Get(':id')
  @ApiResponse({ status: HttpStatus.OK, type: SuccessCatalogueConfigResponse })
  @ApiBadRequestResponse({
    type: BadRequestResponse,
  })
  @ApiUnauthorizedResponse({ type: UnauthorizedResponse })
  async get(@Param('id') id: string) {
    try {
      const catalogueConfig = await this.catalogueConfigService.getById(id);
      return new SuccessCatalogueConfigResponse(catalogueConfig);
    } catch (error) {
      throw new Error(ERROR_MESSAGE.BAD_REQUEST);
    }
  }

  /**
   * Api create catalogue config
   * @request CreateCatalogueConfigRequest
   * @return CatalogueConfig
   * */
  @Post()
  @ApiResponse({ status: HttpStatus.OK, type: SuccessCatalogueConfigResponse })
  @ApiBadRequestResponse({
    type: BadRequestResponse,
  })
  @ApiUnauthorizedResponse({ type: UnauthorizedResponse })
  async create(@Body() createCatalogueConfigRequest: CreateCatalogueConfigRequest) {
    const catalogueConfig = await this.catalogueConfigService.create(
      createCatalogueConfigRequest,
    );
    return new SuccessCatalogueConfigResponse(catalogueConfig);
  }

  /**
   * Api edit catalogue config
   * @params id
   * @return CatalogueConfig
   * */
  @Put(':id')
  @ApiResponse({ status: HttpStatus.OK, type: SuccessCatalogueConfigResponse })
  @ApiBadRequestResponse({
    type: BadRequestResponse,
  })
  @ApiUnauthorizedResponse({ type: UnauthorizedResponse })
  async update(
    @Param('id') id: string,
    @Body() updateCatalogueConfigRequest: UpdateCatalogueConfigRequest,
  ) {
    const updateCatalogueConfig = await this.catalogueConfigService.update(
      id,
      updateCatalogueConfigRequest,
    );
    if (!updateCatalogueConfig) throw new Error(ERROR_MESSAGE.NOT_FOUND);
    return new SuccessCatalogueConfigResponse(null);
  }

  /**
   * Api delete catalogue config
   * @params id
   * */
  @Delete(':id')
  @ApiResponse({ status: HttpStatus.OK, type: SuccessResponse })
  @ApiBadRequestResponse({
    type: BadRequestResponse,
  })
  @ApiUnauthorizedResponse({ type: UnauthorizedResponse })
  async delete(@Param('id') id: string) {
    const deleteCatalogueConfig = await this.catalogueConfigService.deleteById(id);
    if (!deleteCatalogueConfig) throw new Error(ERROR_MESSAGE.NOT_FOUND);
    return new SuccessCatalogueConfigResponse(null);
  }
}
