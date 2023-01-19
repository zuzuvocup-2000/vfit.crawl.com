import { Module } from '@nestjs/common';
import { MongooseModule } from '@nestjs/mongoose';
import { HttpModule } from '@nestjs/axios';
import { Criteria, CriteriaSchema } from './schema/criteria.schema';
import { CriteriaService } from './criteria.service';
import { CriteriaController } from './criteria.controller';

@Module({
  imports: [
    MongooseModule.forFeature([{ name: Criteria.name, schema: CriteriaSchema }]),
    HttpModule,
  ],
  controllers: [CriteriaController],
  providers: [CriteriaService],
  exports: [CriteriaService],
})
export class CriteriaModule {}
