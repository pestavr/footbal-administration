<?php

namespace app\Listeners\Backend;

use Illuminate\Auth\Events\Login;
use DB;
class SetSeason
{
    /**
     * @param  Login $event
     * @return void
     */
    public function handle(Login $event)
    {
        $seasons = DB::select('select * from season where running = ?', [1]);
        foreach ($seasons as $season) {
            session(
            [
                'season' => $season->season_id,
                'season_name'=> $season->period
            ]
        );
        }
        
    }
}
