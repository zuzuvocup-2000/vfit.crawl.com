import { Module } from '@nestjs/common';
import { MongooseModule } from '@nestjs/mongoose';
import { HttpModule } from '@nestjs/axios';
import { CatalogueConfig, CatalogueConfigSchema } from './schema/catalogue-config.schema';
import { CatalogueConfigService } from './catalogue-config.service';
import { CatalogueConfigController } from './catalogue-config.controller';

@Module({
  imports: [
    MongooseModule.forFeature([{ name: CatalogueConfig.name, schema: CatalogueConfigSchema }]),
    HttpModule,
  ],
  controllers: [CatalogueConfigController],
  providers: [CatalogueConfigService],
  exports: [CatalogueConfigService],
})
export class CatalogueConfigModule {}
