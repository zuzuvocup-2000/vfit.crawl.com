import { Module } from '@nestjs/common';
import { SiteService } from './site.service';
import { MongooseModule } from '@nestjs/mongoose';
import { Site, SiteSchema } from './schema/site.schema';
import { SiteController } from './site.controller';
import { HttpModule } from '@nestjs/axios';
import { Url, UrlSchema } from '../sitemap/schema/url.schema';

@Module({
  imports: [
    MongooseModule.forFeature([{ name: Site.name, schema: SiteSchema }]),
    MongooseModule.forFeature([{ name: Url.name, schema: UrlSchema }]),
    HttpModule,
  ],
  controllers: [SiteController],
  providers: [SiteService],
  exports: [SiteService],
})
export class SiteModule {}
