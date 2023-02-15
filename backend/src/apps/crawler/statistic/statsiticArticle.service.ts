/* eslint-disable @typescript-eslint/no-var-requires */
/* eslint-disable no-await-in-loop */
import { HttpService } from '@nestjs/axios';
import { Injectable } from '@nestjs/common';
import { CHECK_URL_DISABLED } from 'src/common/constants/app';
import { CRITERIA_TYPE_ENUM, TYPE_SITE } from 'src/common/constants/enum';
import { CrawlerRepository } from '../crawler.repository';
import { StatisticRepository } from '../statistic.repository';

@Injectable()
export class StatisticArticle {
  constructor(private readonly statisticRepository: StatisticRepository) {}

  /**
   * chunk site to thread number
   * @return {unknown} response
   */
  async chunkArticle(): Promise<unknown> {
    const articles = await this.statisticRepository.getAllArticles();
    const numKeys = 10;
    const numPartialKeys = articles.length % numKeys;
    const articleList = Array.from({ length: numKeys }, (_, i) =>
      articles.slice(
        i * Math.floor(articles.length / numKeys) + Math.min(i, numPartialKeys),
        (i + 1) * Math.floor(articles.length / numKeys) +
          Math.min(i + 1, numPartialKeys),
      ),
    );

    if (articleList.length > 0) {
      for (let i = 0; i < articleList.length; i++) {
        for await (const articleItem of articleList[i]) {
          await this.statisticRepository.updateThreadNumberArticle(
            articleItem,
            i + 1,
          );
        }
      }
    }
    return true;
  }

  /*
   * Statistic articles
   * @return {boolean}
   */
  async statisticArticles(thread: number): Promise<unknown> {
    try {
      const articles = await this.statisticRepository.getAllArticlesByThread(
        thread,
      );
      if (articles?.length > 0) {
        const criteriaContent = await this.statisticRepository.getCriteriaContent();
        const criteriaRate = await this.statisticRepository.getCriteriaRate();
        articles.forEach(async (articleItem) => {
          await this.statisticContent(
            criteriaContent,
            articleItem,
          );
          await this.statisticRate(
            criteriaRate,
            articleItem,
          );
        });
      }
      return true;
    } catch (error) {
      console.log(error);
    }
  }

  async statisticContent(criteria, articleItem) {
    const goodCriteria = criteria.find(item => item.typeStatistic === 'GOOD');
    const badCriteria = criteria.find(item => item.typeStatistic === 'BAD');
    const [good, bad] = await Promise.all([
      this.countOccurrencesOfKeywords(articleItem.content, goodCriteria.value),
      this.countOccurrencesOfKeywords(articleItem.content, badCriteria.value),
    ]);
    const result = { good, bad };
    const point = this.calculatePoint(result);

    await this.statisticRepository.upsertStatistic({
      siteId: articleItem.siteId,
      articleId: articleItem['_id'],
      urlId: articleItem.urlId,
      typeCriteria: CRITERIA_TYPE_ENUM.CONTENT,
      bad: Object.entries(bad).map(([key, value]) => ({ [key]: value })),
      good: Object.entries(good).map(([key, value]) => ({ [key]: value })),
      point,
    });
    return result;
  }

  async statisticRate(criteria, articleItem) {
    const goodCriteria = criteria.find(item => item.typeStatistic === 'GOOD');
    const badCriteria = criteria.find(item => item.typeStatistic === 'BAD');
    const [good, bad] = await Promise.all([
      this.countRateForStatistic(articleItem.rate, goodCriteria.value),
      this.countRateForStatistic(articleItem.rate, badCriteria.value),
    ]);
    const result = { good, bad };
    const point = this.calculatePoint(result);
    await this.statisticRepository.upsertStatistic({
      siteId: articleItem.siteId,
      articleId: articleItem['_id'],
      urlId: articleItem.urlId,
      typeCriteria: CRITERIA_TYPE_ENUM.RATE,
      bad: Object.entries(bad).map(([key, value]) => ({ [key]: value })),
      good: Object.entries(good).map(([key, value]) => ({ [key]: value })),
      point,
    });
    return result;
  }

  async countOccurrencesOfKeywords(str: string, arrayKeyword: string[]) {
    const keywordCounts = {};
    for (let i = 0; i < arrayKeyword.length; i++) {
      const keyword = arrayKeyword[i];
      const regex = new RegExp(keyword, 'gi');
      const matches = str.match(regex);
      if (matches) {
        keywordCounts[keyword] = matches.length;
      } else {
        delete keywordCounts[keyword];
      }
    }
    return keywordCounts;
  }

  async countRateForStatistic(list: [], arrayKeyword: string[]) {
    const keywordCounts = {};
    for (let index = 0; index < list.length; index++) {
      const str:string = list[index]['comment'];
      for (let i = 0; i < arrayKeyword.length; i++) {
        const keyword = arrayKeyword[i];
        const regex = new RegExp(keyword, 'gi');
        const matches = str.match(regex);
        if (matches) {
          keywordCounts[keyword] = matches.length;
        }
      }
    }
    return keywordCounts;
  }

  calculatePoint(obj) {
    let totalGood = 0;
    let totalBad = 0;
    for (const key in obj.good) {
      totalGood += obj.good[key];
    }
    for (const key in obj.bad) {
      totalBad += obj.bad[key];
    }
    const point = 5 + totalGood * 0.5 - totalBad * 0.5;
    return Math.max(0, Math.min(point, 10));
  }

  calculateAverage(obj) {
    let totalGood = 0;
    let totalBad = 0;
    let total = 0;
    for (const key in obj.good) {
      totalGood += obj.good[key];
      total += obj.good[key];
    }
    for (const key in obj.bad) {
      totalBad += obj.bad[key];
      total += obj.bad[key];
    }
    return {
      good: totalGood / total,
      bad: totalBad / total,
    };
  }
}
