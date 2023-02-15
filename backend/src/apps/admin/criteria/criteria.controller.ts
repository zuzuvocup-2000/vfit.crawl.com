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
import { CriteriaService } from './criteria.service';
import {
  ApiBadRequestResponse,
  ApiResponse,
  ApiUnauthorizedResponse,
} from '@nestjs/swagger';
import { BadRequestResponse } from '../../../common/response/bad-request.response';
import { UnauthorizedResponse } from '../../../common/response/unauthorized.response';
import { SuccessResponse } from 'src/common/response/success.response';
import { CreateCriteriaRequest } from './dto/create-criteria.request';
import { ERROR_MESSAGE } from 'src/common/constants/messages/error';
import { GetFilterDto } from './dto/get-filter.dto';
import { SuccessCriteriaResponse } from './dto/success-criteria.response';
import { UpdateCriteriaRequest } from './dto/update-criteria.request';
import { GetPaginateDto } from 'src/common/params/get-paginate.dto';
import { CODES } from 'src/common/constants/code';
import { SUCCESS_MESSAGE } from 'src/common/constants/messages/success';

@Controller('criteria')
export class CriteriaController {
  constructor(private readonly criteriaService: CriteriaService) {}

  /**
   * Api get list criteria
   * @param filter
   * @param page
   * @param limit
   * @return array Users
   * */
  @Get()
  async filterHandle(@Query() getPaginateDto: GetPaginateDto) {
    const website = await this.criteriaService.paginate(getPaginateDto);
    return {
      status: CODES.SUCCESS,
      message: SUCCESS_MESSAGE.DEFAULT,
      ...website,
    };
  }

  /**
   * Api get detail criteria
   * @params id
   * @return criteria
   * */
  @Get(':id')
  @ApiResponse({ status: HttpStatus.OK, type: SuccessCriteriaResponse })
  @ApiBadRequestResponse({
    type: BadRequestResponse,
  })
  @ApiUnauthorizedResponse({ type: UnauthorizedResponse })
  async get(@Param('id') id: string) {
    try {
      const criteria = await this.criteriaService.getById(id);
      return new SuccessCriteriaResponse(criteria);
    } catch (error) {
      throw new Error(ERROR_MESSAGE.BAD_REQUEST);
    }
  }

  /**
   * Api create criteria
   * @request CreateCriteriaRequest
   * @return Criteria
   * */
  @Post()
  @ApiResponse({ status: HttpStatus.OK, type: SuccessCriteriaResponse })
  @ApiBadRequestResponse({
    type: BadRequestResponse,
  })
  @ApiUnauthorizedResponse({ type: UnauthorizedResponse })
  async create(@Body() createCriteriaRequest: CreateCriteriaRequest) {
    await this.criteriaService.upsert(
      createCriteriaRequest,
    );
    const criteria = await this.criteriaService.getByType(createCriteriaRequest);
    return new SuccessCriteriaResponse(criteria);
  }

  /**
   * Api delete criteria
   * @params id
   * */
  @Delete(':id')
  @ApiResponse({ status: HttpStatus.OK, type: SuccessResponse })
  @ApiBadRequestResponse({
    type: BadRequestResponse,
  })
  @ApiUnauthorizedResponse({ type: UnauthorizedResponse })
  async delete(@Param('id') id: string) {
    const deleteCriteria = await this.criteriaService.deleteById(id);
    if (!deleteCriteria) throw new Error(ERROR_MESSAGE.NOT_FOUND);
    return new SuccessCriteriaResponse(null);
  }
}
