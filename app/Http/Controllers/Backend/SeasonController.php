<?php

namespace App\Http\Controllers\Backend;

use Redirect;
use App\Models\Backend\season;
use App\Models\Backend\groups;
use App\Models\Backend\matches;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class SeasonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (\Carbon\Carbon::parse(season::getLixi()->lixi)->gt(\Carbon\Carbon::parse(\Carbon\Carbon::now()))){
            return redirect()->back()->withFlashDanger('Δεν μπορείτε να δημιουργήσετε νέα Αγωνιστική Περίοδο πριν τελειώσει η προηγούμενη');
        }else{
            return view('backend.season.create');    
        }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\season  $season
     * @return \Illuminate\Http\Response
     */
    public function show(season $season)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\season  $season
     * @return \Illuminate\Http\Response
     */
    public function edit(season $season)
    {
        //
    }

    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\season  $season
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, season $season)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\season  $season
     * @return \Illuminate\Http\Response
     */
    public function destroy(season $season)
    {
        //
    }

    public function insert()
    {
        $runningSeason=season::getRunning()->season_id;
        $groups=groups::where('aa_period', '=', $runningSeason)
                        ->update(['locked'=>1]);
        $oldSeason=season::where('running','=',1)
                     ->update(['running'=>0]);
        $format = 'd/m/Y';
        $enarxi = Carbon::createFromFormat($format, request('enarxi'));
        $lixi = Carbon::createFromFormat($format, request('lixi'));
         $season = new season;
         $season->period=request('period');
         $season->enarxi=Carbon::parse($enarxi)->format('Y-m-d');
         $season->lixi=Carbon::parse($lixi)->format('Y-m-d');
         $season->running=1;
         $season->season_id=intval($runningSeason)+1;
         $season->save();

          session(
            [
                'season' => $season->season_id,
                'season_name'=> $season->period
            ]
        );
         return Redirect::route('admin.dashboard')->withFlashSuccess('Η Αγωνιστική Περίοδο δημιουργήθηκε Επιτυχώς');
    }

    public function set($id)
    {
         $seasons = season::selectRaw('*' )
                    ->where ('season_id','=', $id)
                    ->get();
       
        foreach ($seasons as $season) {
            session(
            [
                'season' => $season->season_id,
                'season_name'=> $season->period
            ]
        );
        }
         return Redirect::back();
    }
}
