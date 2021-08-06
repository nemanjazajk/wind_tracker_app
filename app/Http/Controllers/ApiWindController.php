<?php

namespace App\Http\Controllers;
use App\Models\ApiWind;
use Carbon\Carbon;
use App\Http\Resources\ApiWindResource;
use App\Http\Resources\ChartValueCollection;

class ApiWindController extends Controller
{
  public function index()
  {
    $Val=ApiWind::latest()->first();
    $leatestVal = ApiWind::where('created_at', '>',Carbon::now()->subSeconds(30)->format('Y-m-d H:i:s'))->get();
    $arrayDanger = count($leatestVal, COUNT_RECURSIVE); // check if value for connection is not older then 30 sec
    if ($arrayDanger==0){
       $countValue = "";
    }else {
        $countValue = "false";
    }
      return (new ApiWindResource($Val))->additional(['connection' => [
        'val' => $countValue,
    ]]);
    }

    // Raut for current wind chart for the last 60 minutes
    public function get()
    {
      $chartValues=ApiWind::orderBy('id', 'desc')->select('created_at','currentWindSpeed')->take(720)->get();
      return new ChartValueCollection($chartValues);
      }
        
}
