import {
  Controller,
  Body,
  Get,
  Post,
  Query,
  UploadedFile,
  UseInterceptors,
  HttpStatus,
  Param,
  Put,
  Delete,
} from '@nestjs/common';
import { SiteService } from './site.service';
import { CreateSiteRequest } from './dto/create-site.request';
import {
  ApiBadRequestResponse,
  ApiBody,
  ApiConsumes,
  ApiResponse,
  ApiTags,
  ApiUnauthorizedResponse,
} from '@nestjs/swagger';
import { BadRequestResponse } from '../../../common/response/bad-request.response';
import { UnauthorizedResponse } from '../../../common/response/unauthorized.response';
import { SuccessResponse } from 'src/common/response/success.response';
import { SUCCESS_MESSAGE } from 'src/common/constants/messages/success';
import { CODES } from 'src/common/constants/code';
import { FileInterceptor } from '@nestjs/platform-express';
import { ReadExcelSiteResponse } from './dto/read-excel.response';
import { FormDataRequest, SwaggerFileRequest } from './dto/read-excel.request';
import { GetFilterDto } from '../../../common/params/get-filter.dto';
import { ERROR_MESSAGE } from 'src/common/constants/messages/error';
import { SuccessSiteResponse } from './dto/success-site.response';
import { UpdateSiteRequest } from './dto/update-site.request';

@Controller('sites')
@ApiTags('Site')
export class SiteController {
  constructor(private readonly siteService: SiteService) {}

  /**
   * Api get list website
   * @param filter
   * @param page
   * @param limit
   * @return array Site
   * */
  @Get()
  @ApiResponse({ status: 200, type: SuccessResponse })
  @ApiBadRequestResponse({
    type: BadRequestResponse,
  })
  @ApiUnauthorizedResponse({ type: UnauthorizedResponse })
  async filterHandle(@Query() getFilterDto: GetFilterDto) {
    const website = await this.siteService.paginate(getFilterDto);
    return {
      status: CODES.SUCCESS,
      message: SUCCESS_MESSAGE.DEFAULT,
      ...website,
    };
  }

  /**
   * Api get detail site
   * @params id
   * @return Site
   * */
  @Get(':id')
  @ApiResponse({ status: HttpStatus.OK, type: SuccessSiteResponse })
  @ApiBadRequestResponse({
    type: BadRequestResponse,
  })
  @ApiUnauthorizedResponse({ type: UnauthorizedResponse })
  async get(@Param('id') id: string) {
    try {
      const site = await this.siteService.getById(id);
      if (!site) throw new Error(ERROR_MESSAGE.NOT_FOUND);
      return new SuccessSiteResponse(site);
    } catch (error) {
      throw new Error(ERROR_MESSAGE.BAD_REQUEST);
    }
  }

  /**
   * Api get list website
   * @param CreateSiteRequest
   * @return Site
   * */
  @Post()
  @ApiResponse({ status: HttpStatus.OK, type: SuccessSiteResponse })
  @ApiBadRequestResponse({
    type: BadRequestResponse,
  })
  @ApiUnauthorizedResponse({ type: UnauthorizedResponse })
  async create(@Body() createSiteRequest: CreateSiteRequest) {
    const site = await this.siteService.create(createSiteRequest);
    return new SuccessSiteResponse(site);
  }

  /**
   * Api edit site
   * @params id
   * @return Site
   * */
  @Put(':id')
  @ApiResponse({ status: HttpStatus.OK, type: SuccessSiteResponse })
  @ApiBadRequestResponse({
    type: BadRequestResponse,
  })
  @ApiUnauthorizedResponse({ type: UnauthorizedResponse })
  async update(
    @Param('id') id: string,
    @Body() updateSiteRequest: UpdateSiteRequest,
  ) {
    const updateSite = await this.siteService.update(id, updateSiteRequest);
    if (!updateSite) throw new Error(ERROR_MESSAGE.NOT_FOUND);
    const site = await this.siteService.getById(id);
    return new SuccessSiteResponse(site);
  }

  /**
   * Api delete product config
   * @params id
   * */
  @Delete(':id')
  @ApiResponse({ status: HttpStatus.OK, type: SuccessSiteResponse })
  @ApiBadRequestResponse({
    type: BadRequestResponse,
  })
  @ApiUnauthorizedResponse({ type: UnauthorizedResponse })
  async delete(@Param('id') id: string) {
    const deleteSite = await this.siteService.deleteById(id);
    if (!deleteSite) throw new Error(ERROR_MESSAGE.NOT_FOUND);
    return new SuccessSiteResponse(null);
  }

  /**
   * Api read file and handle to import DB
   * @param file
   * @return array message
   * */
  @Post('import-excel')
  @ApiResponse({ status: 200, type: ReadExcelSiteResponse })
  @ApiBadRequestResponse({ type: BadRequestResponse })
  @ApiUnauthorizedResponse({ type: UnauthorizedResponse })
  @ApiBody(SwaggerFileRequest)
  @ApiConsumes(FormDataRequest)
  @UseInterceptors(FileInterceptor('file'))
  async uploadFile(@UploadedFile() file: Express.Multer.File) {
    const data = await this.siteService.readExcelFromFile(file);
    return {
      status: CODES.SUCCESS,
      message: SUCCESS_MESSAGE.DEFAULT,
      data: data,
    };
  }
}
