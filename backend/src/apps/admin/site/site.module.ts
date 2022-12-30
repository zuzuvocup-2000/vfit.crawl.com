import { Module } from '@nestjs/common';
import { SiteService } from './site.service';
import { MongooseModule } from '@nestjs/mongoose';
import { Site, SiteSchema } from './schema/site.schema';
import { SiteController } from './site.controller';
import { HttpModule } from '@nestjs/axios';

@Module({
  imports: [
    MongooseModule.forFeature([{ name: Site.name, schema: SiteSchema }]),
    HttpModule,
  ],
  controllers: [SiteController],
  providers: [SiteService],
  exports: [SiteService],
})
export class SiteModule {}
