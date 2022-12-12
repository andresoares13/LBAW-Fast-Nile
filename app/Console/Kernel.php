<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Auction;
use Illuminate\Support\Facades\DB;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $auctions = Auction::where('states','Active')->where('ending',false)->get();
            foreach($auctions as $auction){

                $time = new \DateTime($auction->timeclose);
                $diff = $time->diff(new \DateTime("now"));
                $minutes = $diff->days * 24 * 60;
                $minutes += $diff->h * 60;
                $minutes += $diff->i;
                

                if ($minutes < 15){
                    DB::table('auction')->where('id',$auction->id)->update(['ending' => true]);
                }
                
            }
            
        })->everyFiveMinutes();



        $schedule->call(function () {
            $auctions = Auction::where('states','Active')->where('ending',true)->get();
            foreach($auctions as $auction){

                $time = new \DateTime($auction->timeclose);
                $diff = $time->diff(new \DateTime("now"));
                $minutes = $diff->days * 24 * 60;
                $minutes += $diff->h * 60;
                $minutes += $diff->i;
                $seconds = $diff->days * 24 * 60 * 60;
                $seconds +=$diff->h * 60 *60;
                $seconds += $minutes * 60;
                $seconds += $diff->s;
                
                
                if ($minutes <= 0 && $seconds <= 0){
                    DB::table('auction')->where('id',$auction->id)->update(['states' => 'Closed']);
                }
                
            }
            
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
