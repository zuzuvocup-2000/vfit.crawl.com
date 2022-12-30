import {
  PRODUCT_CONFIG_TYPE_ENUM,
  PRODUCT_FEILD_ENUM,
} from '../constants/enum';

export class ProductConfigEntity {
  _id: string;
  siteId: string;
  feild: PRODUCT_FEILD_ENUM;
  pattern: string;
  configType: PRODUCT_CONFIG_TYPE_ENUM;
  dataType: PRODUCT_CONFIG_TYPE_ENUM;
}
