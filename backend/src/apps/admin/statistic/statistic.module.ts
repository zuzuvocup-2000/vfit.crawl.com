import { Module } from '@nestjs/common';
import { MongooseModule } from '@nestjs/mongoose';
import { Article, ArticleSchema } from '../article/schema/article.schema';
import { Result, ResultSchema } from './schema/result.schema';
import { Statistic, StatisticSchema } from './schema/statistic.schema';
import { StatisticController } from './statistic.controller';
import { StatisticService } from './statistic.service';

@Module({
  imports: [
    MongooseModule.forFeature([
      { name: Statistic.name, schema: StatisticSchema },
      { name: Article.name, schema: ArticleSchema },
      { name: Result.name, schema: ResultSchema },
    ]),
  ],
  controllers: [StatisticController],
  providers: [StatisticService],
  exports: [StatisticService],
})
export class StatisticModule {}
