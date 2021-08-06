<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ApiWind;
use app\Helpers\TimeToSeconds;
use App\Models\Form;

class FormController extends Controller
{
    public function store(Request $request)
    {
        if (Gate::allows("subs-only",Auth::user())){
         }elseif(Gate::allows("subs-only3",Auth::user())){
         }else{
             return abort(401);
         }

        $request->validate([
            'obj.operaterUP'            => 'nullable|in:OPERATER_UP',
            'obj.operaterDown'          => 'nullable|in:OPERATER_DOWN',
            'obj.ledOn'                 => 'nullable|in:LED_ON',
            'obj.ledOff'                => 'nullable|in:LED_OFF',
            'data.avregingTime'         => 'nullable|numeric',
            'data.risingWindTimeDelay'  => 'nullable|date_format:"H:i:s"',
            'data.fallingWindTimeDelay' => 'nullable|date_format:"H:i:s"',
            'data.ledDelay'             => 'nullable|date_format:"H:i:s"',
            'data.risingInterval'       => 'nullable|date_format:"H:i:s"',
            'data.loweringInterval'     => 'nullable|date_format:"H:i:s"',
            'data.risingWindTreshold'   => 'nullable|numeric',
            'data.fallingWindTreshold'  => 'nullable|numeric',
        ]);
        $form = new Form();
        $form->operater_up              = $request->input('obj.operaterUp');
        $form->operater_down            = $request->input('obj.operaterDown');
        $form->leed                     = $request->input('obj.ledOn');
        $form->leed_off                 = $request->input('obj.ledOff');
        $form->avreging_time            = $request->input('data.avregingTime');
        $form->rising_wind_time_delay   = TimeToSeconds::stringToSeconds(($request->input('data.risingWindTimeDelay')));
        $form->falling_wind_time_delay  = TimeToSeconds::stringToSeconds(($request->input('data.fallingWindTimeDelay')));
        $form->led_delay                = TimeToSeconds::stringToSeconds(($request->input('data.ledDelay')));
        $form->rising_interval          = TimeToSeconds::stringToSeconds(($request->input('data.risingInterval')));
        $form->lowering_interval        = TimeToSeconds::stringToSeconds(($request->input('data.loweringInterval')));
        $form->rising_wind_treshold     = $request->input('data.risingWindTreshold');
        $form->falling_wind_treshold    = $request->input('data.fallingWindTreshold');
        $form->save();
        return 'USPEŠNO STE PROMENILI PODATKE';
    }
   
    public function get()
    {
        $currentStats  = apiWind::orderBy('id', 'desc')->select('eventError')->take(1)->get();
        $currentStats  = collect($currentStats)[0]['eventError'];
        $currentStats  = explode(",", $currentStats);
        return array_slice($currentStats, 5, 8);
    }
}


