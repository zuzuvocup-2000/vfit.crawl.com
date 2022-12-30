/* eslint-disable no-await-in-loop */
import { Injectable, HttpStatus } from '@nestjs/common';
import { InjectModel } from '@nestjs/mongoose';
import { Model } from 'mongoose';
import { Site, SiteDocument } from './schema/site.schema';
import { CreateSiteRequest } from './dto/create-site.request';
import {
  DocumentCollector,
  CollectionResponse,
} from '@forlagshuset/nestjs-mongoose-paginate';
import * as xlsx from 'xlsx';
import * as https from 'https';
import { WorkSheet } from 'xlsx';
import { HttpService } from '@nestjs/axios';
import { STATUS_SITE } from 'src/common/constants/app';
import { GetFilterDto } from '../../../common/params/get-filter.dto';
import { UpdateSiteRequest } from './dto/update-site.request';

@Injectable()
export class SiteService {
  constructor(
    @InjectModel(Site.name) private siteModel: Model<SiteDocument>,
    private readonly httpService: HttpService,
  ) {}

  async findAll(): Promise<Site[]> {
    return this.siteModel.find().exec();
  }

  /**
   * Api get list website
   * @param filter
   * @param page
   * @param limit
   * @return array Site
   * */
  async paginate(
    getFilterDto: GetFilterDto,
  ): Promise<CollectionResponse<SiteDocument>> {
    const collector = new DocumentCollector<SiteDocument>(this.siteModel);
    return collector.find({
      filter: JSON.parse(getFilterDto.filter) || {},
      page: getFilterDto.page,
      limit: getFilterDto.limit,
    });
  }

  /**
   * Excel file processing
   * @param file
   * @return boolean
   * */

  async readExcelFromFile(file): Promise<boolean> {
    try {
      // Read excel and add data to array
      const workbook = xlsx.read(file.buffer);
      const sitesList = [];

      const sheet: WorkSheet = workbook.Sheets[workbook.SheetNames[0]];
      const range = xlsx.utils.decode_range(sheet['!ref']);

      for (let R = range.s.r; R <= range.e.r; ++R) {
        if (R === 0 || !sheet[xlsx.utils.encode_cell({ c: 0, r: R })]) {
          continue;
        }
        const dataItem = {
          platformId: sheet[xlsx.utils.encode_cell({ c: 0, r: R })].v,
          url: sheet[xlsx.utils.encode_cell({ c: 1, r: R })].v,
          platform: sheet[xlsx.utils.encode_cell({ c: 2, r: R })].v,
          status: STATUS_SITE.INACTIVE,
        };
        sitesList.push(dataItem);
      }
      if (sitesList.length > 0) {
        await this.importSitesToDB(sitesList);
      }
      return true;
    } catch (error) {
      console.log(error);
    }
  }

  /**
   * After reading excel file, processing site
   * @param sitesList
   * @return boolean
   * */
  async importSitesToDB(sitesList): Promise<boolean> {
    try {
      // Check status excel: alive or dead and convert url site
      for (let index = 0; index < sitesList.length; index++) {
        const checkStatus = await this.checkUrlStatus(
          sitesList[index].url,
          'https',
        );
        const checkHTTP =
          checkStatus === true
            ? false
            : await this.checkUrlStatus(sitesList[index].url, 'http');
        // To do check http & https
        const urlSite = 'https://' + sitesList[index].url;
        // let urlSite = sitesList[index].url;
        // if (urlSite.includes('http') === false) {urlSite = checkStatus === true ? 'https://' + urlSite: 'http://' + urlSite;}

        sitesList[index] = {
          platformId: sitesList[index].platformId,
          platform: sitesList[index].platform,
          status:
            checkStatus === true
              ? STATUS_SITE.ACTIVE
              : checkHTTP === true
                ? STATUS_SITE.ACTIVE
                : STATUS_SITE.INACTIVE,
          url: urlSite,
        };
      }

      const dataSites = {
        insert: sitesList,
        update: [],
      };

      // Get all Website and check 2 array insert and update
      let allSites = await this.getAllSites();
      allSites = [...new Set(allSites)];
      if (allSites.length > 0) {
        for (let index = 0; index < allSites.length; index++) {
          for (let i = 0; i < sitesList.length; i++) {
            if (sitesList[i].url.includes(allSites[index].url) === true) {
              sitesList[i]['_id'] = allSites[index]['_id'];
              dataSites.update.push(sitesList[i]);
              dataSites.insert.splice(i, 1);
            }
          }
        }
      }
      // Update and insert to DB
      if (dataSites.insert.length > 0)
        await this.insertSitesToDB(dataSites.insert);
      if (dataSites.update.length > 0)
        await this.updateSitesToDB(dataSites.update);
      return true;
    } catch (error) {
      console.log(error);
    }
  }

  /**
   * Check status url true or false
   * @param url (string)
   * @param protocol (string)
   * @return boolean
   * */
  async checkUrlStatus(url: string, protocol: string): Promise<boolean> {
    try {
      const agent = new https.Agent({
        rejectUnauthorized: false,
      });
      url = url.includes('http') === false ? protocol + '://' + url + '/' : url;
      const response = await this.httpService.axiosRef.get(url, {
        httpsAgent: agent,
      });
      return response.status <= HttpStatus.BAD_REQUEST ? true : false;
    } catch (error) {
      console.log(error);
    }
  }

  /**
   * Insert a lot of data to DB if DB isnt have
   * @param sitesInsert (array) Site
   * @return boolean
   * */
  async insertSitesToDB(sitesInsert: Site[]): Promise<boolean> {
    try {
      await this.siteModel.insertMany(sitesInsert);
      return true;
    } catch (error) {
      console.log(error);
    }
  }

  /**
   * Update status alot of data to DB if DB have it
   * @param sitesUpdate (array) Site
   * @return boolean
   * */
  async updateSitesToDB(sitesUpdate: Site[]): Promise<boolean> {
    try {
      const idActiveSite = sitesUpdate.filter(
        i => i.status === STATUS_SITE.ACTIVE,
      );
      const idDeactiveSite = sitesUpdate.filter(
        i => i.status === STATUS_SITE.INACTIVE,
      );
      await Promise.all([
        this.siteModel.updateMany(
          { _id: { $in: idActiveSite } },
          { $set: { status: STATUS_SITE.ACTIVE } },
          { multi: true },
        ),
        this.siteModel.updateMany(
          { _id: { $in: idDeactiveSite } },
          { $set: { status: STATUS_SITE.INACTIVE } },
          { multi: true },
        ),
      ]);
      return true;
    } catch (error) {
      console.log(error);
    }
  }

  /**
   * Get all sites from table sites
   * @return array Site
   * */
  async getAllSites(): Promise<Site[]> {
    try {
      return await this.siteModel.find().exec();
    } catch (error) {
      console.log(error);
    }
  }

  /**
   * Api create site
   * @request CreateSiteRequest
   * @return Site
   * */
  async create(createSiteRequest: CreateSiteRequest): Promise<SiteDocument> {
    const createSite = new this.siteModel(createSiteRequest);
    return createSite.save();
  }

  /**
   * Api detail site
   * @params id
   * @return Site
   * */
  async getById(id: string): Promise<SiteDocument> {
    const productConfig = await this.siteModel.findById(id).exec();
    return productConfig;
  }

  /**
   * Api update site
   * @params id
   * @return Site
   * */
  async update(id: string, updateSiteRequest: UpdateSiteRequest) {
    return await this.siteModel.updateOne({ _id: id }, updateSiteRequest);
  }

  /**
   * Api delete site
   * @params id
   * */
  async deleteById(id: string) {
    return await this.siteModel.findByIdAndRemove(id);
  }
}
