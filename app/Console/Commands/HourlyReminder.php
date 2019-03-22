<?php

namespace App\Console\Commands;

use App\User;
use App\Mail;
use App\Task;
use App\Goal;
use DB;
use Illuminate\Console\Command;

class HourlyReminder extends Command
{
   /**
    * The name and signature of the console command.
    *
    * @var string
    */
   protected $signature = 'hourly:reminder';

   /**
    * The console command description.
    *
    * @var string
    */
   protected $description = 'Task Daily Reminder';

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
    * @return mixed
    */

    public function handle()
   {
        $goals = DB::table('goals')
        ->where('finish' ,'=', date('Y-m-d'))
        ->get();

        foreach ($goals as $goal) 
        {
            
    
           Goal::where('id', $goal->id)
                        ->update(['status' => 'Pending',          
            ]);
    
        }
    
        $this->info("Reminder sent Successfully");

//     $user = User::all();
//     foreach ($user as $a) {
//          Mail::raw("This is automatically generated Monthly Reminder", function($message) use ($a) {
//              $message->from('jeremiahiro@gmail.com');
//              $message->to($a->email)->subject(' Monthly Reminder');
//          });
//      }
//      $this->info('Monthly Reminder has been send successfully');
   }
}