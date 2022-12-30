import { Injectable } from '@nestjs/common';
import * as XLSX from 'xlsx';
import { CrawlerRepository } from './crawler.repository';

@Injectable()
export class WriteFileExcelService {
  constructor(
    private readonly crawlerRepository: CrawlerRepository,
  ) { }

  async totalSitemapOfSite() {
    /* fetch JSON data and parse */
    const listGroupUrlOfSite = await this.crawlerRepository.getGroupCoutUrlsOfSite();

    /* flatten objects */
    const rows = listGroupUrlOfSite.map(row => ({
      site_url: row.site_details[0].url,
      total_url: row.count
    }));

    /* generate worksheet and workbook */
    const worksheet = XLSX.utils.json_to_sheet(rows);
    const workbook = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(workbook, worksheet, "Dates");

    /* fix headers */
    XLSX.utils.sheet_add_aoa(worksheet, [["site_url", "total_url"]], { origin: "A1" });

    /* calculate column width */
    const max_width = rows.reduce((w, r) => Math.max(w, r.site_url.length), 10);
    worksheet["!cols"] = [{ wch: max_width }];

    /* create an XLSX file and try to save to Presidents.xlsx */
    XLSX.writeFile(workbook, "TotalUrlOfSite.xlsx", { compression: true });
    console.log("Write file excel successfully")
  }
}