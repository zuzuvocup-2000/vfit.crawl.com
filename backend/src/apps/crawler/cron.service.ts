import { Injectable } from '@nestjs/common';
import { Cron } from '@nestjs/schedule';
import { CrawlerService } from './crawler.service';

@Injectable()
export class CronService {
  // constructor(private crawlerService: CrawlerService) {}
  // @Cron(process.env.CRON_SITE_MAP || '0 0 1 1 *')
  // async cronSitemap() {
  //   await this.crawlerService.crawlerSitemap();
  // }
}
