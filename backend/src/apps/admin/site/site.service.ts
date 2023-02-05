/* eslint-disable require-atomic-updates */
/* eslint-disable @typescript-eslint/no-explicit-any */
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
import { UpdateSiteRequest } from './dto/update-site.request';
import { GetPaginateDto } from 'src/common/params/get-paginate.dto';

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
    getPaginateDto: GetPaginateDto,
  ): Promise<CollectionResponse<SiteDocument>> {
    const collector = new DocumentCollector<SiteDocument>(this.siteModel);
    return collector.find({
      filter: {
        $or: [
          { url: { $regex: new RegExp(getPaginateDto.keyword, "i") } },
        ]
      },
      page: getPaginateDto.page,
      limit: getPaginateDto.limit,
    });
  }

  /**
   * Excel file processing
   * @param file
   * @return boolean
   * */

  async readExcelFromFile(file): Promise<any[]> {
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
          url: sheet[xlsx.utils.encode_cell({ c: 0, r: R })].v,
          typeCrawl: sheet[xlsx.utils.encode_cell({ c: 1, r: R })].v,
          status: STATUS_SITE.INACTIVE,
        };
        sitesList.push(dataItem);
      }
      if (sitesList) await this.importSitesToDB(sitesList);
      return sitesList;
    } catch (error) {
      console.log(error);
    }
  }

  /**
   * After reading excel file, processing site
   * @param sitesList
   * @return boolean
   * */
  async importSitesToDB(sitesList): Promise<any> {
    try {
      for (let index = 0; index < sitesList.length; index++) {
        sitesList[index].status = await this.checkUrlStatus(sitesList[index].url);
      }
      const updateSite = await sitesList.map(site => ({
        updateOne: {
          filter: { url: site.url },
          update: {
            $set: {
              siteId: site._id,
              url: site.url,
              typeCrawl: site.typeCrawl,
              status: site.status,
            },
          },
          upsert: true,
        },
      }));
      await this.siteModel.bulkWrite(updateSite);
      return updateSite;
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
  async checkUrlStatus(url: string): Promise<number> {
    try {
      const agent = new https.Agent({
        rejectUnauthorized: false,
      });
      const response = await this.httpService.axiosRef.get(url, {
        httpsAgent: agent,
      });
      return response.status <= HttpStatus.BAD_REQUEST ? STATUS_SITE.ACTIVE : STATUS_SITE.INACTIVE;
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
    const site = await this.siteModel.findById(id).exec();
    return site;
  }

  /**
   * Api detail site
   * @params url
   * @return Site
   * */
  async getByUrl(url: string): Promise<SiteDocument> {
    const site = await this.siteModel.findOne({ url }).exec();
    return site;
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
