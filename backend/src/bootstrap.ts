import { AdminModule } from './apps/admin/admin.module';
import { CrawlerModule } from './apps/crawler/crawler.module';
import { NestFactory } from '@nestjs/core';
import { INestApplication } from '@nestjs/common';
import { DocumentBuilder, SwaggerModule } from '@nestjs/swagger';
import { appConfig } from './config/app.config';
// import { GatewayModule } from './apps/gateway/gateway.module';
import { APP } from './common/constants/app';

const appCon = appConfig();
const addSwaggerDocs = (app: INestApplication) => {
  const swaggerConfig = new DocumentBuilder()
    .setTitle(appCon?.swagger?.title || 'API documentation')
    .setDescription(appCon?.swagger?.description || 'The API documentation')
    .setVersion(appCon?.swagger?.version || '0.0.0-dev')
    .addTag(appCon?.swagger?.tag || 'API')
    .addBearerAuth({
      type: 'http',
      description: 'Enter JWT access token',
    })
    .build();
  const document = SwaggerModule.createDocument(app, swaggerConfig);
  SwaggerModule.setup('docs', app, document);
};

export default async () => {
  if (process.env.APPS.includes(APP.ADMIN)) {
    const adminApp = await NestFactory.create(AdminModule);
    adminApp.setGlobalPrefix('v1');
    adminApp.enableCors();
    addSwaggerDocs(adminApp);
    await adminApp.listen(process.env.PORT_ADMIN);
    console.log(`Admin is running on: ${await adminApp.getUrl()}`);
  }
  if (process.env.APPS.includes(APP.CRAWL)) {
    const crawlApp = await NestFactory.create(CrawlerModule);
    crawlApp.enableCors();
    await crawlApp.listen(process.env.PORT_CRAWL);
    console.log(`Crawler is running on: ${await crawlApp.getUrl()}`);
  }

  // if (process.env.APPS.includes(APP.GATEWAY)) {
  //   const gatewayApp = await NestFactory.create(GatewayModule);
  //   gatewayApp.setGlobalPrefix('v1');
  //   gatewayApp.enableCors();
  //   addSwaggerDocs(gatewayApp);
  //   await gatewayApp.listen(process.env.PORT_GETWAY);
  //   console.log(`Gateway is running on: ${await gatewayApp.getUrl()}`);
  // }
};
