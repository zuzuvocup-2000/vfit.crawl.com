import { Controller, Post, UseGuards } from '@nestjs/common';
import { CrawlerService } from './crawl-data/crawler.service';
import { CrawlerSitemapService } from './crawl-url/crawlerSitemap.service';
import { WriteFileExcelService } from './writeFileExcel.service';
import { AuthGuard } from '@nestjs/passport';
import { CrawlerAllUrlsService } from './crawl-url/crawlerAllUrl.service';

@Controller('crawler')
export class CrawlerController {
  constructor(
    private readonly crawlerService: CrawlerService,
    private readonly crawlerSitemapService: CrawlerSitemapService,
    private readonly crawlerAllUrlsService: CrawlerAllUrlsService,
    private readonly writeFileExcelService: WriteFileExcelService,
  ) {}

  @Post()
  @UseGuards(AuthGuard('jwt'))
  async index() {
    return await this.crawlerSitemapService.crawlerSitemap();
  }

  /**
   * Check sitemap status pending
   * @return array Site.update & Site.insert
   * */
  @UseGuards(AuthGuard('jwt'))
  @Post('check-sitemap-pending')
  async checkSitemapPending() {
    return await this.crawlerSitemapService.crawlerSitemapPending();
  }

  /**
    * Crawl data articles & catalogues from urls
    * @Body {array} sitemap info.
    * @return {boolean}
  */
  @UseGuards(AuthGuard('jwt'))
  @Post('/crawl-site')
  async crawlerWebsite() {
    return await this.crawlerService.crawlDataFromUrls();
  }

  /**
    * Crawl data articles & catalogues from urls
    * @Body {array} sitemap info.
    * @return {boolean}
  */
  @UseGuards(AuthGuard('jwt'))
  @Post('/crawl-url-normal')
  async crawlUrlWebsiteNormal() {
    return await this.crawlerAllUrlsService.crawlUrl();
  }
}
