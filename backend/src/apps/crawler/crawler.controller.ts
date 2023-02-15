import { Controller, Param, Post } from '@nestjs/common';
import { CrawlerService } from './crawl-data/crawler.service';
import { CrawlerSitemapService } from './crawl-url/crawlerSitemap.service';
import { WriteFileExcelService } from './writeFileExcel.service';
import { CrawlerAllUrlsService } from './crawl-url/crawlerAllUrl.service';
import { StatisticArticle } from './statistic/statsiticArticle.service';

@Controller('crawler')
export class CrawlerController {
  constructor(
    private readonly crawlerService: CrawlerService,
    private readonly statisticArticleService: StatisticArticle,
    private readonly crawlerSitemapService: CrawlerSitemapService,
    private readonly crawlerAllUrlsService: CrawlerAllUrlsService,
    private readonly writeFileExcelService: WriteFileExcelService,
  ) {}

  @Post()
  // @UseGuards(AuthGuard('jwt'))
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
  @Post('/crawl-site/:thread')
  async crawlerWebsite(@Param('thread') thread: number) {
    return await this.crawlerService.crawlDataFromUrls(thread);
  }

  /**
    * Crawl data articles & catalogues from urls
    * @Body {array} sitemap info.
    * @return {boolean}
  */
  @Post('/crawl-url-normal')
  async crawlUrlWebsiteNormal() {
    return await this.crawlerAllUrlsService.crawlUrl();
  }

  /**
    * Crawl data articles & catalogues from urls
    * @return {boolean}
  */
  @Post('/chunk')
  async chunkSite() {
    return await this.crawlerService.chunkSite();
  }

  /**
    * Statistic articles
    * @return {boolean}
  */
  @Post('/statistic-article/:thread')
  async statisticArticles(@Param('thread') thread: number) {
    const statistic = await this.statisticArticleService.statisticArticles(thread);
    return statistic;
  }

  /**
    * chunk all articles
    * @return {boolean}
  */
  @Post('/chunk-article')
  async chunkArticle() {
    return await this.statisticArticleService.chunkArticle();
  }
}
