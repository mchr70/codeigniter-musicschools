<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	public function __construct(){
		parent::__construct();

		$this->load->model('MschoolModel');

		// Load texts by language
        $this->lang->load('user', $this->config->item('language'));
	}
	public function index()
	{
		$data = array(
			'pageTitle' => $this->lang->line('texts_home')
		);

		$data['schools'] = $this->MschoolModel->getAllSchools();

		$this->load->view('templates/header', $data);
		$this->load->view('home', $data);
		$this->load->view('templates/footer', $data);
	}

	/*
	Description: Distance calculation from the latitude/longitude of 2 points
	Author: Michaël Niessen (2014)
	Website: http://AssemblySys.com
	
	If you find this script useful, you can show your
	appreciation by getting Michaël a cup of coffee ;)
	PayPal: https://www.paypal.me/MichaelNiessen
	
	As long as this notice (including author name and details) is included and
	UNALTERED, this code can be freely used and distributed.
	*/
	
	public function distanceCalculation($point1_lat, $point1_long, $point2_lat, $point2_long, $unit = 'km', $decimals = 2) {
		// Calculate the distance in degrees
		$degrees = rad2deg(acos((sin(deg2rad($point1_lat))*sin(deg2rad($point2_lat))) + (cos(deg2rad($point1_lat))*cos(deg2rad($point2_lat))*cos(deg2rad($point1_long-$point2_long)))));
	
		// Convert the distance in degrees to the chosen unit (kilometres, miles or nautical miles)
		switch($unit) {
			case 'km':
				$distance = $degrees * 111.13384; // 1 degree = 111.13384 km, based on the average diameter of the Earth (12,735 km)
				break;
			case 'mi':
				$distance = $degrees * 69.05482; // 1 degree = 69.05482 miles, based on the average diameter of the Earth (7,913.1 miles)
				break;
			case 'nmi':
				$distance =  $degrees * 59.97662; // 1 degree = 59.97662 nautic miles, based on the average diameter of the Earth (6,876.3 nautical miles)
		}
		return round($distance, $decimals);
	}

}