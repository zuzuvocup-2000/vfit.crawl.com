import { Controller, Get, Param, Post, Query, UseGuards } from '@nestjs/common';
import { AuthGuard } from '@nestjs/passport';
import { ApiBadRequestResponse } from '@nestjs/swagger';
import { CODES } from 'src/common/constants/code';
import { SUCCESS_MESSAGE } from 'src/common/constants/messages/success';
import { BadRequestResponse } from 'src/common/response/bad-request.response';
import { GetPaginateDtoStatistic } from './dto/get-statistic.request';
import { StatisticService } from './statistic.service';

@Controller('statistic')
export class StatisticController {
  constructor(private readonly statisticService: StatisticService) {}

  /**
   * Api get list criteria
   * @param filter
   * @param page
   * @param limit
   * @return array Users
   * */
  @Get()
  async filterHandle(@Query() getPaginateDtoStatistic: GetPaginateDtoStatistic) {
    console.log(getPaginateDtoStatistic);
    const website = await this.statisticService.paginate(getPaginateDtoStatistic);
    return {
      status: CODES.SUCCESS,
      message: SUCCESS_MESSAGE.DEFAULT,
      data: website['data'],
      paginate: {
        total: website['total'],
        page: website['page'],
        limit: website['limit'],
      }
    };
  }

  /**
   * Calculate statistic
   * @return boolean
   * */
  @Post('calculate-statistic')
  @UseGuards(AuthGuard('jwt'))
  async calculate() :Promise<unknown> {
    return await this.statisticService.calculateStatistic();
  }

  /**
   * Api get article
   * @params id
   * @return Article
   * */
  @Get('article/:id')
  @UseGuards(AuthGuard('jwt'))
  @ApiBadRequestResponse({
    type: BadRequestResponse,
  })
  async get(@Param('id') id: string) {
    return {
      status: CODES.SUCCESS,
      message: SUCCESS_MESSAGE.DEFAULT,
      data: await this.statisticService.getArticle(id),
    };
  }
}
