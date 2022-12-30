import { Module } from '@nestjs/common';
import { SitemapController } from './sitemap.controller';
import { MongooseModule } from '@nestjs/mongoose';
import { Sitemap, SitemapSchema } from './schema/sitemap.schema';
import { UrlSchema, Url } from './schema/url.schema';

@Module({
  imports: [
    MongooseModule.forFeature([
      { name: Sitemap.name, schema: SitemapSchema },
      { name: Url.name, schema: UrlSchema }
    ]),
  ],
  controllers: [SitemapController],
})
export class SitemapModule {}
