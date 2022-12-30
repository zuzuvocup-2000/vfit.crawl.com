import { Module } from '@nestjs/common';
import { AdminController } from './admin.controller';
import { CommonModule } from '../../common/common.module';
import { UserModule } from './user/user.module';
import { SitemapModule } from './sitemap/sitemap.module';
import { SiteController } from './site/site.controller';
import { SiteModule } from './site/site.module';

@Module({
  imports: [
    CommonModule,
    UserModule,
    SitemapModule,
    SiteModule,
  ],
  controllers: [AdminController, SiteController],
})
export class AdminModule {}
