export const APP = {
  ADMIN: 'admin',
  CRAWL: 'crawl',
  GATEWAY: 'gateway',
};

export const STATUS_SITE = {
  INACTIVE: 0,
  ACTIVE: 1,
  CRAWLING: 2
};

export const STATUS_SITE_MAP = {
  ACTIVE: 1,
  INACTIVE: 0,
  PENDING: 2,
  CRAWL: 3
};

export const STATUS_CONFIG = {
  INACTIVE: 0,
  ACTIVE: 1,
  RUNNING: 2,
  PENDING: 3
};


export const CRAWL = {
  SITE_MAP: 'Sitemap: ',
  ROBOTS: 'robots.txt',
  URL_SITEMAP: 'sitemap.xml',
  SITE_MAP_INDEX: 'sitemap_index.xml',
  SITE_SITE_MAP_INDEX: 'sitemap/sitemap_index.xml',
  EXAMPLE: 'example',
};

export const DICTIONARY_SITEMAP = [
  'sitemap.xml',
  'sitemap_index.xml',
  'sitemap/sitemap.xml',
]

export const TYPE_SITE_MAP = {
  INDEX: 0,
  URL: 1,
  CATEGORY: 2,
};

export const PAGINATE_DEFAULT = {
  filter: {},
  page: 0,
  limit: 5,
};

export const ASC_FILTER = 1;

export const LIMIT_SITE_MAP = 50;

export const TYPE_CRAWL = {
  HTTP_REQUEST: 'HTTP',
  BROWSER: 'BROWSER',
};

export const URL_CRAWL = {
  HTTP_REQUEST: '/crawler/http-request',
  BROWSER: '/crawler/product',
};

export const URL_CRAWL_SITEMAP = {
  CRAWLER_SITEMAP: '/crawler/crawlerSitemapOfSite',
};

export const CHECK_PRODUCT = {
  META: 'product',
  INPUT_PRODUCT: 'jsonProductGTM',
  SELECTOR_SCHEMA: 'script[type="application/ld+json"]',
  SELECTOR_META: 'meta[property="og:type"]',
  SELECTOR_INPUTGTM: 'input#jsonProductGTM'
}

export const NUMBER_DATE_LOOP_CRAWL_PRODUCT = 3;
export const NUMBER_DATE_LOOP_CRAWL_SITEMAP = 7;

export const TEXT_SCHEMA_PRODUCT = {
  TYPE_PRODUCT: "product",
};

export const JWT_CONSTANTS = {
  secret: 'vanhfithau',
}