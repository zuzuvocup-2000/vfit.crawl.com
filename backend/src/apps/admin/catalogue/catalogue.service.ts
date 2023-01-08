/* eslint-disable no-await-in-loop */
import { Injectable } from '@nestjs/common';
import { InjectModel } from '@nestjs/mongoose';
import { Model } from 'mongoose';
import {
  Catalogue,
  CatalogueDocument,
} from './schema/catalogue.schema';

@Injectable()
export class CatalogueService {

  constructor(
    @InjectModel(Catalogue.name)
    private catalogueModel: Model<CatalogueDocument>,
  ) {}
}
