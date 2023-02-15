import { Module } from '@nestjs/common';
import { ScheduleModule } from '@nestjs/schedule';
import { CommonModule } from '../../common/common.module';
import { MongooseModule } from '@nestjs/mongoose';
import { Sitemap, SitemapSchema } from '../admin/sitemap/schema/sitemap.schema';
import { Site, SiteSchema } from '../admin/site/schema/site.schema';
import { HttpModule } from '@nestjs/axios';
import { CrawlerService } from './crawl-data/crawler.service';
import { CrawlerRepository } from './crawler.repository';
import { CrawlerController } from './crawler.controller';
import { Url, UrlSchema } from '../admin/sitemap/schema/url.schema';
import { CrawlerSitemapService } from './crawl-url/crawlerSitemap.service';
import { WriteFileExcelService } from './writeFileExcel.service';
import { CatalogueConfig, CatalogueConfigSchema } from '../admin/config-catalogue/schema/catalogue-config.schema';
import { ArticleConfig, ArticleConfigSchema } from '../admin/config-article/schema/article-config.schema';
import { Catalogue, CatalogueSchema } from '../admin/catalogue/schema/catalogue.schema';
import { Article, ArticleSchema } from '../admin/article/schema/article.schema';
import { CrawlerAllUrlsService } from './crawl-url/crawlerAllUrl.service';
import { StatisticArticle } from './statistic/statsiticArticle.service';
import { StatisticRepository } from './statistic.repository';
import { Criteria, CriteriaSchema } from '../admin/criteria/schema/criteria.schema';
import { Statistic, StatisticSchema } from '../admin/statistic/schema/statistic.schema';

@Module({
  imports: [
    MongooseModule.forFeature([
      { name: Url.name, schema: UrlSchema },
      { name: Sitemap.name, schema: SitemapSchema },
      { name: Site.name, schema: SiteSchema },
      { name: CatalogueConfig.name, schema: CatalogueConfigSchema },
      { name: ArticleConfig.name, schema: ArticleConfigSchema },
      { name: Statistic.name, schema: StatisticSchema },
      { name: Catalogue.name, schema: CatalogueSchema },
      { name: Article.name, schema: ArticleSchema },
      { name: Criteria.name, schema: CriteriaSchema },
    ]),
    CommonModule,
    HttpModule,
    ScheduleModule.forRoot(),
  ],
  controllers: [CrawlerController],
  providers: [
    CrawlerService,
    CrawlerSitemapService,
    StatisticArticle,
    CrawlerAllUrlsService,
    CrawlerRepository,
    StatisticRepository,
    WriteFileExcelService,
  ],
})
export class CrawlerModule { }
