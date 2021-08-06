<?php

namespace App\Console\Commands;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReportMail;
use Illuminate\Console\Command;

class HourlyWind extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wind:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends mail';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        
        Mail::to('nemanjazajk@gmail.com')
        ->cc(['Ivan.bukvic@gmail.com','aleksandar.vujcec@fullhouseogilvy.rs','ivan.vucinic@fullhouseogilvy.rs','shox162@gmail.com'])
        ->send(new ReportMail());

    
    }
    
}
