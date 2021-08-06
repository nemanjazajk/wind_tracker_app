<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\ApiWind;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * 
     * @return void
     */
    public $apiWind;

    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      $state= ApiWind::where('created_at', '>',Carbon::now()->subDay())->select('currentState','created_at')->get();
      $previous = 0;
      $items = array();
      $count = 0;
      foreach ($state as $p){
        if ($p['currentState']!==$previous){
        $items[$count++] = $p; 
        $previous=$p['currentState'];
  }
  }  
      $StatrDate   = Carbon::now()->subDay();
      $EndDate = Carbon::now();
      
      $Date = DB::select(
        DB::raw('select avg(currentWindSpeed) AS currentWindSpeed,
                DATE_FORMAT(created_at, "%Y %m %d %H ") AS date 
                from api_winds where created_at between'
                .' "' . $StatrDate . '" '.'and' .' "' . $EndDate . '" '.
                'group by DATE_FORMAT(created_at, "%Y %m %d %H ");'));

      return $this->markdown('emails.report')->with([
        'states'=>$items,
        'speed'=>array_column($Date,'currentWindSpeed'),
        'date' =>array_column($Date,'date')
      ]);
       
    }
}
