<?php 
namespace App\Controllers\Backend\Statistic;
use App\Controllers\BaseController;

class Statistic extends BaseController{

	protected $data;

	public function __construct(){
		$this->data = [];
		$this->statisticService = service('StatisticService');
	}

	public function index(){
		try {
			// $this->data['statisticList'] = $this->statisticService->getListStatistic();
			$this->data['title'] = 'Danh sách Báo cáo';
			$this->data['module'] = 'statistic';
			$this->data['template'] = 'backend/statistic/statistic/index';
			return view('backend/dashboard/layout/home', $this->data);
		} catch (\Exception $e) {
		    echo $e->getMessage();
		}
	}
}
