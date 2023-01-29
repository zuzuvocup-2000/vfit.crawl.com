import { Controller, Post } from '@nestjs/common';
import { CrawlerService } from './crawler.service';
import { CrawlerSitemapService } from './crawlerSitemap.service';
import { CrawlerJavascriptService } from './crawlerJavascript.service';
import { CrawlerNormalService } from './crawlerNormal.service';
import { WriteFileExcelService } from './writeFileExcel.service';

@Controller('crawler')
export class CrawlerController {
  constructor(
    private readonly crawlerService: CrawlerService,
    private readonly crawlerSitemapService: CrawlerSitemapService,
    private readonly crawlerJavascriptService: CrawlerJavascriptService,
    private readonly crawlerNormalService: CrawlerNormalService,
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
    * Crawl data articles & catalogues from urls
    * @Body {array} sitemap info.
    * @return {boolean}
  */
  @Post('/crawl-site')
  async crawlerWebsite() {
    return await this.crawlerService.crawlDataFromUrls();
  }

  /**
    * Crawl data articles & catalogues from urls
    * @Body {array} sitemap info.
    * @return {boolean}
  */
  @Post('/crawl-url-javascript')
  async crawlUrlWebsiteJavascript() {
    return await this.crawlerJavascriptService.crawlUrl();
  }

  /**
    * Crawl data articles & catalogues from urls
    * @Body {array} sitemap info.
    * @return {boolean}
  */
  @Post('/crawl-url-normal')
  async crawlUrlWebsiteNormal() {
    return await this.crawlerNormalService.crawlUrl();
  }
}
