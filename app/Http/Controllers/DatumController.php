<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DatumController extends Controller
{
    public function index(Request $request)
  {

    $date =$request->input('payload.date');  // avalable dates
    $firstDate = substr($date[0], 0, 33);
    $secondDate = substr($date[1], 0, 33);
   if (strtotime($firstDate) && strtotime($secondDate)){
    $historyDate = DB::select(
      DB::raw('select avg(currentWindSpeed) AS currentWindSpeed,
               DATE_FORMAT(created_at, "%Y %m %d %H %i") AS date 
               from api_winds where created_at between'
              .' "' . $firstDate . '" '.'and' .' "' . $secondDate . '" '.
              'group by DATE_FORMAT(created_at, "%Y %m %d %H %i");'));
    return $historyDate;
  }else{
    return abort(401);
  }
  }

  public function get()
  {

    $historyDate = DB::select(
      DB::raw('select 
               DATE_FORMAT(created_at, "%Y %m %d ") AS date 
               from api_winds 
               group by DATE_FORMAT(created_at, "%Y %m %d ");'));
  
 // accessibility for curent db
  return collect([$historyDate]);
  
  }
}
