<?php

namespace App\Http\Controllers;

use Ixudra\Curl\Facades\Curl;
use Illuminate\Http\Request;
use Carbon\Carbon;
require dirname(__DIR__) . '/../../vendor/autoload.php';

class CovidCtrl extends Controller
{
	
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

	public function getDataCovid(){
		$response = Curl::to('https://data.covid19.go.id/public/api/update.json')
        ->get();
		return $response;
	}

}