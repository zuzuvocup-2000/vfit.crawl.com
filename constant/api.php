<?php

const API_LOGIN = 'http://localhost:3001/admin/auth/login';
const API_GET_USER_BY_EMAIL = 'http://localhost:3001/admin/auth/count';
const SEND_OTP = 'http://localhost:3001/admin/auth/send-otp'; 
const API_RESET_PASSWORD = 'http://localhost:3001/admin/auth/reset-password'; 


const API_GET_CURRENT_USER_BY_EMAIL = 'http://localhost:3001/admin/users/'; 
// http://localhost:3001/admin/users/vanh.dev2000@gmail.com
const API_SIGNUP = 'http://localhost:3001/admin/users/signup'; 
const API_USER_GET_BY_ID = 'http://localhost:3001/admin/users/index'; 
const API_USER_LIST = 'http://localhost:3001/admin/users/list'; 
const API_USER_CREATE = 'http://localhost:3001/admin/users/create'; 
const API_CHANGE_PASSWORD = 'http://localhost:3001/admin/users/change-password'; 
const API_UPDATE_USER = 'http://localhost:3001/admin/users/update-user';


const API_WEBSITE_LIST = 'http://localhost:3001/admin/sites'; 
const API_WEBSITE_CREATE = 'http://localhost:3001/admin/sites'; 
const API_WEBSITE_UPDATE = 'http://localhost:3001/admin/sites'; 
const API_WEBSITE_GET_BY_URL = 'http://localhost:3001/admin/sites/site'; 
const API_WEBSITE_GET_BY_ID = 'http://localhost:3001/admin/sites';
const API_WEBSITE_GET_ALL_URLS = 'http://localhost:3001/admin/sites/list';
const API_UPDATE_STATUS_URL = 'http://localhost:3001/admin/sites/update-status';

const API_CONFIG_ARTICLE_LIST = 'http://localhost:3001/admin/article-config'; 
const API_CONFIG_ARTICLE_CREATE = 'http://localhost:3001/admin/article-config'; 
const API_CONFIG_ARTICLE_UPDATE = 'http://localhost:3001/admin/article-config'; 
// const API_CONFIG_ARTICLE_GET_BY_URL = 'http://localhost:3001/admin/article-config/site'; 
const API_CONFIG_ARTICLE_GET_BY_SITEID = 'http://localhost:3001/admin/article-config/list';  
const API_CONFIG_ARTICLE_GET_BY_ID = 'http://localhost:3001/admin/article-config';  

const API_CONFIG_CATALOGUE_LIST = 'http://localhost:3001/admin/catalogue-config'; 
const API_CONFIG_CATALOGUE_CREATE = 'http://localhost:3001/admin/catalogue-config'; 
const API_CONFIG_CATALOGUE_UPDATE = 'http://localhost:3001/admin/catalogue-config'; 
// const API_CONFIG_CATALOGUE_GET_BY_URL = 'http://localhost:3001/admin/catalogue-config/site'; 
const API_CONFIG_CATALOGUE_GET_BY_SITEID = 'http://localhost:3001/admin/catalogue-config/list';  
const API_CONFIG_CATALOGUE_GET_BY_ID = 'http://localhost:3001/admin/catalogue-config'; 

const API_CRAWL_SITEMAP = 'http://localhost:3002/crawler'; 
const API_CRAWL_JAVASCRIPT = 'http://localhost:3002/crawler/crawl-url-javascript'; 
const API_CRAWL_NORMAL = 'http://localhost:3002/crawler/crawl-url-normal'; 

const API_CRITERIA_UPSERT = 'http://localhost:3001/admin/criteria'; 
const API_CRITERIA_LIST = 'http://localhost:3001/admin/criteria'; 
const API_CRITERIA_GET_BY_ID = 'http://localhost:3001/admin/criteria'; 
