import { Module } from '@nestjs/common';
import { ScheduleModule } from '@nestjs/schedule';
import { CommonModule } from '../../common/common.module';
import { MongooseModule } from '@nestjs/mongoose';
import { Sitemap, SitemapSchema } from '../admin/sitemap/schema/sitemap.schema';
import { Site, SiteSchema } from '../admin/site/schema/site.schema';
import { HttpModule } from '@nestjs/axios';
import { CronService } from './cron.service';
import { CrawlerService } from './crawler.service';
import { CrawlerRepository } from './crawler.repository';
import { CrawlerController } from './crawler.controller';
import { Url, UrlSchema } from '../admin/sitemap/schema/url.schema';
import { CrawlerSitemapService } from './crawlerSitemap.service';
import { WriteFileExcelService } from './writeFileExcel.service';

@Module({
  imports: [
    MongooseModule.forFeature([
      { name: Url.name, schema: UrlSchema },
      { name: Sitemap.name, schema: SitemapSchema },
      { name: Site.name, schema: SiteSchema },
    ]),
    CommonModule,
    HttpModule,
    ScheduleModule.forRoot(),
  ],
  controllers: [CrawlerController],
  providers: [
    CronService,
    CrawlerService,
    CrawlerSitemapService,
    CrawlerRepository,
    WriteFileExcelService,
  ],
})
export class CrawlerModule { }
