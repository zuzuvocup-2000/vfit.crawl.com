import { Controller, Post } from '@nestjs/common';
import { CrawlerService } from './crawler.service';
import { CrawlerSitemapService } from './crawlerSitemap.service';
import { WriteFileExcelService } from './writeFileExcel.service';

@Controller('crawler')
export class CrawlerController {
  constructor(
    private readonly crawlerService: CrawlerService,
    private readonly crawlerSitemapService: CrawlerSitemapService,
    private readonly writeFileExcelService: WriteFileExcelService,
  ) {}

  @Post()
  async index() {
    return await this.crawlerSitemapService.crawlerSitemap();
  }

  /**
   * Check sitemap status pending
   * @return array Site.update & Site.insert
   * */
  @Post('check-sitemap-pending')
  async checkSitemapPending() {
    return await this.crawlerSitemapService.crawlerSitemapPending();
  }

  /**
    * Crawler Catalogue With DOM.
    * @Body {array} sitemap info.
    * @return {boolean}
  */
  @Post('/crawl-catalogue')
  async crawlerCatalogue() {
    return await this.crawlerService.crawlDataFromUrls();
  }
}
