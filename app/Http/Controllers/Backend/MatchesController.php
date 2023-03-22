<?php

namespace App\Http\Controllers\Backend;

use PDF;
use DB;
use Redirect;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Controllers\Controller;
use App\Models\Backend\matches;
use App\Models\Backend\players;
use App\Models\Backend\referees;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;

class MatchesController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        //
    }
    





    
    /**
     * Display the specified resource.
     *
     * @param  \App\matches  $matches
     * @return \Illuminate\Http\Response
     */
    //Πρόγραμμα με φύλλα αγώνα ανά Διαιτητή
    public function referee($id)
    {

        $matches= matches::selectRaw('matches.aa_game as id, matches.*, team1.onoma_web as ghp, team2.onoma_web as fil, fields.eps_name as arena, group1.title as category, group1.category as cat, IF(matches.referee='.$id.', "Δ","Β") as ref')
                ->join('teams as team1', 'team1.team_id','=', 'matches.team1')
                ->join('teams as team2', 'team2.team_id','=', 'matches.team2')
                ->join('group1', 'group1.aa_group' ,'=','matches.group1')
                ->join('season', 'season.season_id','=', 'group1.aa_period')
                ->join('fields', 'fields.aa_gipedou','=','matches.court')
                ->where('season.season_id','=',session('season'))
                ->where(function($query) use ($id){
                    $query->where('matches.referee','=', $id)
                          ->orWhere('matches.helper1','=', $id)
                          ->orWhere('matches.helper2','=', $id);
                })
                ->orderby('matches.date_time', 'desc')->get();
        return Datatables::of($matches)
        ->addColumn('actions',function($matches){
                //return $herbs->getEditButtonAttribute($herbs->id);
                return view('backend.includes.partials.actions',['id'=>$matches->id, 'category'=>$matches->cat, 'page'=>'matches']);
        })
        ->addColumn('match', function($matches){
                return $matches->ghp.' - '.$matches->fil;
            })
        ->addColumn('date', function($matches){
                return Carbon::parse($matches->date_time)->format('d/m/Y H:i');
            })
        ->rawColumns(['actions'])
        ->make(true);
    }

//Τα δεδομένα για το Φύλλο Αγώνα 
    public function fyllo($id){
            $matches= matches::selectRaw('matches.aa_game as id, matches.match_day, matches.date_time, matches.group1, matches.score_team_1 as score1, matches.score_team_2 as score2, group1.omilos, group1.title  AS omilos, teams1.onoma_web AS team1, teams2.onoma_web AS team2,  referees_ref.Lastname AS ref_last_name, referees_ref.Firstname AS ref_firstname, matches.referee as ref_id, matches.team1 as t1, matches.team2 as t2, referees_h1.Lastname AS h1_last_name, referees_h1.Firstname AS h1_firstname, matches.helper1 as h1_id, season.period as season_name,     referees_h2.Lastname AS h2_last_name, referees_h2.Firstname AS h2_firstname, matches.helper2 as h2_id,matches.paratiritis as par_id, matches.doctor as doc_id, doctors.docLastName as doc_last, doctors.docFirstName as doc_first, paratirites.waLastName as par_last, paratirites.waFirstName as par_first, fields.sort_name AS field, matches.published as pub, matches.notified as notif, champs.*, fields.*, season.period as season')
                ->join('teams as teams1', 'teams1.team_id','=', 'matches.team1')
                ->join('teams as teams2', 'teams2.team_id','=', 'matches.team2')
                ->join('group1', 'group1.aa_group' ,'=','matches.group1')
                ->join('champs', 'champs.champ_id','=','group1.category')
                ->join('season', 'season.season_id','=', 'group1.aa_period')
                ->join('fields', 'fields.aa_gipedou','=','matches.court')
                ->join('referees as referees_ref', 'referees_ref.refaa', '=', 'matches.referee')
                ->join('referees as referees_h1', 'referees_h1.refaa', '=', 'matches.helper1')
                ->join('referees as referees_h2', 'referees_h2.refaa', '=', 'matches.helper2')
                ->join('doctors', 'doctors.doc_id','=','matches.doctor')
                ->join('paratirites', 'paratirites.wa_id','=','matches.paratiritis')                
                ->where('matches.aa_game','=', $id)
               //->where('matches.published','=', '1')
                ->orderby('matches.date_time', 'desc')->get();
            foreach($matches as $match){
                    $team1=players::selectRaw('Surname, Name, YEAR(Birthdate) as BirthYear')
                            ->where('teams_team_id','=',$match->t1)->get();
                    $team2=players::selectRaw('Surname, Name, YEAR(Birthdate) as BirthYear')
                            ->where('teams_team_id','=',$match->t2)->get();
                }

        return view('backend.matches.fyllo', compact('matches','team1','team2'));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\matches  $matches
     * @return \Illuminate\Http\Response
     */
    public function edit(matches $matches)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\matches  $matches
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, matches $matches)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\matches  $matches
     * @return \Illuminate\Http\Response
     */
    public function destroy(matches $matches)
    {
        //
    }
}
