import { Module } from '@nestjs/common';
import { MongooseModule } from '@nestjs/mongoose';
import { HttpModule } from '@nestjs/axios';
import { ArticleConfig, ArticleConfigSchema } from './schema/article-config.schema';
import { ArticleConfigService } from './article-config.service';
import { ArticleConfigController } from './article-config.controller';

@Module({
  imports: [
    MongooseModule.forFeature([{ name: ArticleConfig.name, schema: ArticleConfigSchema }]),
    HttpModule,
  ],
  controllers: [ArticleConfigController],
  providers: [ArticleConfigService],
  exports: [ArticleConfigService],
})
export class ArticleConfigModule {}
