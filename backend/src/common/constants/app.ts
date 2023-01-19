export const APP = {
  ADMIN: 'admin',
  CRAWL: 'crawl',
};

export const STATUS_URL = {
  INACTIVE: 0,
  ACTIVE: 1,
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
};

export const STATUS_CONFIG = {
  INACTIVE: 0,
  ACTIVE: 1,
  RUNNING: 2,
  PENDING: 3
};

export const STATUS_ARTICLE = {
  INACTIVE: 0,
  ACTIVE: 1,
  STATISTIC: 2,
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
];

export const TYPE_SITE_MAP = {
  INDEX: 0,
  URL: 1,
};

export const PAGINATE_DEFAULT = {
  filter: {},
  page: 0,
  limit: 5,
};

export const ASC_FILTER = 1;

export const LIMIT_SITE_MAP = 50;

export const URL_CRAWL = {
  HTTP_REQUEST: '/crawler/http-request',
  BROWSER: '/crawler/product',
};

export const URL_CRAWL_SITEMAP = {
  CRAWLER_SITEMAP: '/crawler/crawlerSitemapOfSite',
};

export const JWT_CONSTANTS = {
  secret: 'vanhfithau',
};
