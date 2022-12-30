// import { Module } from '@nestjs/common';
// import { AppController } from './app.controller';
// import { AppService } from './app.service';
// import { MongooseModule } from '@nestjs/mongoose';
// import { UserModule } from './user/user.module';
// import { ConfigModule, ConfigService } from '@nestjs/config';
// import { ScheduleModule } from '@nestjs/schedule';
//
// @Module({
//   imports: [
//     ConfigModule.forRoot({ envFilePath: '.env' }),
//     MongooseModule.forRootAsync({
//       imports: [ConfigModule],
//       useFactory: async (configService: ConfigService) => {
//         return {
//           uri: `${configService.get<string>('MONGODB_URI')}:27017`
//         };
//       },
//       inject: [ConfigService],
//     }),
//     ScheduleModule.forRoot(),
//     UserModule,
//   ],
//   controllers: [AppController],
//   providers: [AppService],
// })
// export class AppModule {
// }
