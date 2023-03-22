<?php

namespace App\Listeners\Backend\File/Herbarium;

use App\Events\Backend\File\RefereesInsert;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
class Insert
{
     /**
     * @var string
     */
    private $history_slug = 'Referee';
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  HerbariumInsert  $event
     * @return void
     */
    public function handle(HerbariumInsert $event)
    {
        $user = Auth::user();
        
            history()->withType($this->history_slug)
                    ->withEntity($user->id)
                    ->withText('εισήγαγε νέο Διαιτητή <strong> '.$event->herb->Herbarium.' </strong>')
                    ->withIcon('plus')
                    ->withClass('bg-green')
                    ->withAssets([
                            'user_link'=>['admin.herbarium.edit', $event->herb->Herbarium, $event->herb->HerbariumID],
                        ])
                    ->log();
    }
}
