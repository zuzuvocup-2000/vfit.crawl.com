// import { NestFactory } from '@nestjs/core';
// import { AppModule } from './app.module';
//
// async function bootstrap() {
//   const app = await NestFactory.create(AppModule);
//   await app.listen(3000);
// }
// bootstrap().then(r => console.log('done'));

import bootstrap from './bootstrap';

bootstrap().then(() => console.log('done'));
