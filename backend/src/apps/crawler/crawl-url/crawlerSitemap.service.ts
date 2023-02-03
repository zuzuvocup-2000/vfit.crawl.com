/* eslint-disable no-await-in-loop */
import { HttpService } from '@nestjs/axios';
import { HttpStatus, Injectable } from '@nestjs/common';
import {
  CRAWL,
  STATUS_SITE_MAP,
} from 'src/common/constants/app';
import { toJson } from 'xml2json';
import { Site } from '../../admin/site/schema/site.schema';
import { CrawlerRepository } from '../crawler.repository';
import * as https from 'https';
import { TYPE_SITE } from 'src/common/constants/enum';

@Injectable()
export class CrawlerSitemapService {
  constructor(
    private readonly httpService: HttpService,
    private readonly crawlerRepository: CrawlerRepository,
  ) {}

  /*
   * Crawler Sitemap Pending.
   * @return {boolean}
   */
  async crawlerSitemapPending(): Promise<boolean> {
    try {
      // Get sitemap pending
      const sitemaps = await this.crawlerRepository.getSitePendingCrawl();
      sitemaps.forEach(async (sitemap) => {
        await this.checkTypeSitemap(sitemap.url, sitemap['site'], sitemap.status);
      });
      return true;
    } catch (error) {
      console.log(error);
    }
  }

  /*
   * Crawler Sitemap.
   * @return {boolean}
   */
  async crawlerSitemap(): Promise<boolean> {
    try {
      // Get site crawl
      const sites = await this.crawlerRepository.getSiteCrawlUrl(TYPE_SITE.SITEMAP);
      for (const site of sites) {
        let sitemaps = [];
        let statusSite = false;
        // Get info Robots.txt
        const robotData = await this.getResponseAxios(
          `${site.url}/${CRAWL.ROBOTS}`,
        );
        // Get Sitemap
        if (robotData && robotData['status'] === HttpStatus.OK) {
          sitemaps = robotData['data'].match(/Sitemap: http.*?.*/gm);
          if (sitemaps && sitemaps.length > 0) sitemaps = sitemaps.filter(i => i.includes(site.url.replace('https://', '')));
        }

        // Import status sitemap to DB
        if (sitemaps && sitemaps.length > 0) {
          const sitemapFilter = sitemaps.filter(i => !i.includes(CRAWL.EXAMPLE));
          // update site with sitemap
          for (let i = 0; i < sitemapFilter.length; i++) {
            const url = sitemapFilter[i].replace(CRAWL.SITE_MAP, '').replace('.gz', '');
            await this.checkTypeSitemap(url, site, STATUS_SITE_MAP.ACTIVE);
          }
          statusSite = true;
        }
        await this.crawlerRepository.updateSiteWithSitemap(site.url, statusSite);
      }
      return true;
    } catch (error) {
      console.log(error);
    }
  }

  /*
   * Check Type Sitemap.
   * @param {string} url sitemap.
   * @param {object} site info.
   * @return {void}
   */
  async checkTypeSitemap(url: string, site: Site, statusSitemap: number): Promise<void> {
    try {
      const sitemap = await this.httpService.axiosRef.get(`${url}`, {
        httpsAgent: new https.Agent({
          rejectUnauthorized: false,
          keepAlive: false,
        }),
      });

      if (sitemap && sitemap['status'] === HttpStatus.OK) {
        // convert xml to object
        const obj = toJson(sitemap['data'], { object: true });
        if (obj['urlset']) {
          const sitemapUrlset = obj['urlset'].url.length > 0 ? obj['urlset'].url : [obj['urlset'].url];
          await this.sitemapBulkWriteUrl(sitemapUrlset, site);
          if ( statusSitemap === STATUS_SITE_MAP.PENDING ) { await this.updateStatusSitemap(url, STATUS_SITE_MAP.ACTIVE); }
        }

        if (obj['sitemapindex']) {
          const sitemapindex = obj['sitemapindex'].sitemap.length > 0 ? obj['sitemapindex'].sitemap : [obj['sitemapindex'].sitemap];
          await this.hanldeSitemapIndex(sitemapindex, site);
        }
      }
    } catch (error) {
      await this.updateStatusSitemap(url, STATUS_SITE_MAP.PENDING);
      console.log(error);
    }
  }

  /*
   * Hanlde Sitemap Index.
   * @param {sitemaps} list sitemap.
   * @param {object} site info.
   * @return {void}
   */
  async hanldeSitemapIndex(sitemaps, site: Site): Promise<void> {
    try {
      await this.sitemapBulkWriteIndex(
        await this.checkSitemapIsNotEmpty(sitemaps),
        site,
      );
      sitemaps.forEach(async (sitemap) => {
        const url = sitemap.loc && sitemap.loc.length > 0 ? sitemap.loc.replace('.gz', '') : sitemap;
        if ( typeof url === 'string' && this.checkUrlSitemap(url, site.url) == true ) {
          await this.checkTypeSitemap(url, site, STATUS_SITE_MAP.ACTIVE);
        }
      });
    } catch (error) {
      console.log(error);
    }
  }

  /*
   * Check sitemap only current site
   * @param {string} urlSitemap.
   * @param {string} urlSite.
   * @return {boolean}
   */
  checkUrlSitemap(urlSitemap: string, urlSite: string) {
    try {
      urlSite = urlSite.replace('https://', '');
      return urlSitemap.includes(urlSite);
    } catch (error) {
      console.log(error);
    }
  }

  /*
   * Create or Update Sitemap Type Index.
   * @param {sitemaps} list sitemap.
   * @param {object} site info.
   * @return {void}
   */
  async sitemapBulkWriteIndex(sitemaps, site: Site): Promise<void> {
    try {
      await this.crawlerRepository.sitemapBulkWrite( sitemaps, site );
      console.log('upsert sitemap done');
    } catch (error) {
      console.log(error);
    }
  }

  /*
   * Create Sitemap Type Url.
   * @param {sitemaps} list sitemap.
   * @param {object} site info.
   * @return {void}
   */
  async sitemapBulkWriteUrl(sitemaps, site: Site): Promise<void> {
    try {
      await this.crawlerRepository.urlsBulkWriteBySitemap( sitemaps, site );
      console.log('upsert sitemap done');
    } catch (error) {
      console.log(error);
    }
  }

  /*
   * Update Status Sitemap.
   * @param {url} list sitemap.
   * @return {void}
   */
  async updateStatusSitemap(url: string, status: number): Promise<void> {
    try {
      await this.crawlerRepository.updateStatusSitemap(url, status);
      console.log('update status sitemap error');
    } catch (error) {
      console.log(error);
    }
  }

  /*
   * Update Site With Sitemap.
   * @param {site} site info.
   * @param {boolean} statusSitemap.
   * @return {void}
   */
  async updateSiteWithSitemap( site: Site, statusSitemap: boolean ): Promise<void> {
    try {
      await this.crawlerRepository.updateSiteWithSitemap( site['id'], statusSitemap );
      console.log('update status sitemap error');
    } catch (error) {
      console.log(error);
    }
  }

  /*
   * Get response data when send axios
   * @param {string} url.
   * @return {unknown} response
   */
  async getResponseAxios(url: string): Promise<unknown> {
    try {
      const response = await this.httpService.axiosRef.get(url, {
        httpsAgent: new https.Agent({
          rejectUnauthorized: false,
          keepAlive: false,
        }),
      });
      return response;
    } catch (error) {
      console.log(error);
    }
  }

  /*
   * Check item sitemap if empty remove item
   * @param {sitemapList} list.
   * @return {unknown} sitemapList
   */
  checkSitemapIsNotEmpty(sitemapList) {
    try {
      if (sitemapList.length > 0) {
        for (let index = 0; index < sitemapList.length; index++) {
          if ( (typeof sitemapList[index] === 'object' && sitemapList[index].loc && sitemapList[index].loc.length == 0) ||
            (typeof sitemapList[index] === 'object' && !sitemapList[index].loc) ||
            (typeof sitemapList[index] === 'object' && typeof sitemapList[index].loc === 'object')
          ) {
            sitemapList.splice(index, 1);
          }
        }
      }
      return sitemapList;
    } catch (error) {
      console.log(error);
    }
  }
}
