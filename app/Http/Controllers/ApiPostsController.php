<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\ApiWind;
use App\Models\Form;
use Carbon\Carbon;
use App\Mail\AlertMail;
use Illuminate\Support\Facades\Mail;

class ApiPostsController extends Controller
{
    public function index(Request $request)
    {
       
      $apiWind = new ApiWind();
      $request->validate( [
         'currentWindSpeed' => 'required',
          'currentState'    => 'required',
         
      ]);
       $commandResponse=$request->query('commandResponse');
        $apiWind->currentWindSpeed = number_format($request->query('currentWindSpeed'),2);
        $apiWind->currentState = $request->query('currentState');
        $apiWind->eventError = $request->query('eventError');
        $apiWind->commandResponse = $request->query('commandResponse');

        if ($commandResponse=="NOT_ACKNOWLEGED") {
          Form::orderBy('id', 'desc')->take(1)->delete();
        };
        $apiWind->save();
        $array1=explode(",", $request->query('eventError'));
        $array2=explode(":", $array1[13]);// notification
        $array3=$array2[1];// Value for mail alert
 
        if ($array3=="WIND_HIGH_ON"){
          Mail::to('nemanjazajk@gmail.com')
        ->cc(['Ivan.bukvic@gmail.com','aleksandar.vujcec@fullhouseogilvy.rs','ivan.vucinic@fullhouseogilvy.rs','shox162@gmail.com'])
        ->send(new AlertMail());
        }
        
        return $result = Form::where('created_at', '>',Carbon::now()->subSeconds(30)->format('Y-m-d H:i:s'))->get();
    }

    public function store(Request $request)
    {
       
      $apiWind = new ApiWind();
      $request->validate( [
         'currentWindSpeed' => 'required',
          'currentState'    => 'required',
      
      ]);
       $commandResponse=$request->query('commandResponse');
        $apiWind->currentWindSpeed = number_format($request->query('currentWindSpeed'),2);
        $apiWind->currentState = $request->query('currentState');
        $apiWind->eventError = $request->query('eventError');
        $apiWind->commandResponse = $request->query('commandResponse');

        if ($commandResponse=="NOT_ACKNOWLEGED") {
          Form::orderBy('id', 'desc')->take(1)->delete();
          
        };
       $apiWind->save();
       $array1=explode(",", $request->query('eventError'));
       $array2=explode(":", $array1[13]);
       $array3=$array2[1];// Value for mail alert

       if ($array3=="WIND_HIGH_ON"){
        Mail::to('nemanjazajk@gmail.com')
        ->cc(['Ivan.bukvic@gmail.com','aleksandar.vujcec@fullhouseogilvy.rs','ivan.vucinic@fullhouseogilvy.rs','shox162@gmail.com'])
        ->send(new AlertMail());
       }
       
        return $result = Form::where('created_at', '>',Carbon::now()->subSeconds(30)->format('Y-m-d H:i:s'))->get();
      }
}

