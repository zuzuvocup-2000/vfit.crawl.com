import { Module } from '@nestjs/common';
import { AdminController } from './admin.controller';
import { CommonModule } from '../../common/common.module';
import { UserModule } from './user/user.module';
import { SitemapModule } from './sitemap/sitemap.module';
import { SiteController } from './site/site.controller';
import { SiteModule } from './site/site.module';
import { AuthModule } from './auth/auth.module';
import { ArticleConfigController } from './config-article/article-config.controller';
import { ArticleController } from './article/article.controller';
import { CriteriaController } from './criteria/criteria.controller';
import { StatisticController } from './statistic/statistic.controller';
import { ArticleModule } from './article/article.module';
import { ArticleConfigModule } from './config-article/article-config.module';
import { CatalogueConfigModule } from './config-catalogue/catalogue-config.module';
import { CriteriaModule } from './criteria/criteria.module';
import { StatisticModule } from './statistic/statistic.module';
import { CatalogueConfigController } from './config-catalogue/catalogue-config.controller';
import { CatalogueModule } from './catalogue/catalogue.module';
import { CatalogueController } from './catalogue/catalogue.controller';

@Module({
  imports: [
    CommonModule,
    UserModule,
    SitemapModule,
    SiteModule,
    AuthModule,
    ArticleModule,
    ArticleConfigModule,
    CatalogueConfigModule,
    CatalogueModule,
    CriteriaModule,
    StatisticModule,
  ],
  controllers: [
    AdminController,
    SiteController,
    ArticleConfigController,
    CatalogueConfigController,
    CatalogueController,
    ArticleController,
    CriteriaController,
    StatisticController,
  ],
})
export class AdminModule {}
