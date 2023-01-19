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

@Controller('criteria')
export class CriteriaController {
  constructor(private readonly criteriaService: CriteriaService) {}

  /**
   * Api get list criteria
   * @param filter
   * @param page
   * @param limit
   * @return array Site
   * */
  @Get()
  @ApiResponse({ status: HttpStatus.OK, type: SuccessCriteriaResponse })
  @ApiBadRequestResponse({
    type: BadRequestResponse,
  })
  @ApiUnauthorizedResponse({ type: UnauthorizedResponse })
  async filterHandle(@Query() getFilterDto: GetFilterDto) {
    try {
      const criterias = await this.criteriaService.paginate(
        getFilterDto,
      );
      return new SuccessCriteriaResponse(criterias);
    } catch (error) {
      throw new Error(ERROR_MESSAGE.BAD_REQUEST);
    }
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
    const criteria = await this.criteriaService.create(
      createCriteriaRequest,
    );
    return new SuccessCriteriaResponse(criteria);
  }

  /**
   * Api edit criteria
   * @params id
   * @return criteria
   * */
  @Put(':id')
  @ApiResponse({ status: HttpStatus.OK, type: SuccessCriteriaResponse })
  @ApiBadRequestResponse({
    type: BadRequestResponse,
  })
  @ApiUnauthorizedResponse({ type: UnauthorizedResponse })
  async update(
    @Param('id') id: string,
    @Body() updateCriteriaRequest: UpdateCriteriaRequest,
  ) {
    const updateCriteria = await this.criteriaService.update(
      id,
      updateCriteriaRequest,
    );
    if (!updateCriteria) throw new Error(ERROR_MESSAGE.NOT_FOUND);
    return new SuccessCriteriaResponse(null);
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
