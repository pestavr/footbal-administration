<?php

namespace App\Http\Controllers\Backend\Prints;

use Redirect;
use DB;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Controllers\Controller;
use App\Models\Backend\players;
use App\Models\Backend\matches;
use App\Models\Backend\team;
use App\Models\Backend\season;
use App\Models\Backend\penaltyOfficial;
use App\Models\Backend\penaltyPlayer;
use App\Models\Backend\penaltyTeam;
use Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return view('backend.prints.program.index');
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function per_date(){
        return view('backend.prints.program.date');
    }



 //Πρόγραμμα με φύλλα αγώνα ανά κατηγορία και αγωνιστική 
    public function programMD(){

        $category= request('category');
        $md_from= request('md_from');
        $md_to= request('md_to');
        if (is_null($md_to)){
            $md_to=$md_from;
        }elseif(is_null($md_from)){
            $md_from=$md_to;
        }
        session()->put('category', $category);
        session()->put('md_from', $md_from);
        session()->put('md_to', $md_to);
        $matches= matches::selectRaw('matches.aa_game as id, matches.*, team1.onoma_web as ghp, team2.onoma_web as fil, fields.eps_name as arena, fields.aa_gipedou as arena_id, group1.title as category,  group1.category as cat, group1.locked as groupLocked,  champs.flexible as flexible, matches.score_team_1 as score1, matches.score_team_2 as score2, matches.publ as prog_publ, matches.published as ref_publ, matches.publ_doc as doc_publ, matches.publ_ref_obs as ref_obs_publ, "-" as dash')
                ->join('teams as team1', 'team1.team_id','=', 'matches.team1')
                ->join('teams as team2', 'team2.team_id','=', 'matches.team2')
                ->join('group1', 'group1.aa_group' ,'=','matches.group1')
                ->join('champs', 'group1.category' ,'=','champs.champ_id')
                ->join('fields', 'fields.aa_gipedou','=','matches.court')
                ->where('matches.group1','=', $category)
                ->whereBetween('matches.match_day',array($md_from, $md_to))
                ->orderby('matches.match_day', 'asc')
                ->get();
        $response= Datatables::of($matches)
       
        ->addColumn('match', function($matches){
                return $matches->ghp.' - '.$matches->fil;
            })
        ->addColumn('date', function($matches){
            if ($matches->date_time==config('default.datetime')){
                $date='-';
                $dataDate=Carbon::now()->format('d/m/Y H:i');
            }else{
                $date=Carbon::parse($matches->date_time)->format('d/m/Y H:i');
                $dataDate=Carbon::parse($matches->date_time)->format('d/m/Y H:i');
            }
            return $date;
            })
        ->addColumn('score', function($matches){
                return $matches->score_team_1.' - '.$matches->score_team_2;
            })
        ->addColumn('code', function($matches){
                return '#'.$matches->aa_game.'#';
            });

        $response=$response->make(true);
        return $response;
    }


//Πρόγραμμα με φύλλα αγώνα ανά κατηγορία και αγωνιστική 
    public function programDate(){

        $date_from= request('date_from');
        $date_to= request('date_to');
        if (is_null($date_to)){
            $date_to=$date_from;
        }elseif(is_null($date_from)){
            $date_from=$date_to;
        }elseif(is_null($date_from) && is_null($date_to)){
            $date_from= Carbon::now();
            $date_to= Carbon::now();
        }else{
            $format = 'd/m/Y';
            $date_from = Carbon::createFromFormat($format, $date_from);
            $date_to = Carbon::createFromFormat($format, $date_to); 
        }

        session()->put('date_from', $date_from);
        session()->put('date_to', $date_to);

        if( Request::input('men')==1) {
                    $men=1;
                } else {
                    $men=0;
                }
        if( Request::input('kids')==1) {
                    $kids=1;
                } else {
                    $kids=0;
                }
        
        $date_from= Carbon::parse($date_from)->format('Y/m/d 00:00');
        $date_to= Carbon::parse($date_to)->format('Y/m/d 23:59');
        $matches= matches::selectRaw('matches.aa_game as id, matches.*, team1.onoma_web as ghp, team2.onoma_web as fil, fields.eps_name as arena, fields.aa_gipedou as arena_id, group1.title as category, group1.category as cat, group1.locked as groupLocked, matches.score_team_1 as score1, champs.flexible as flexible, matches.score_team_2 as score2, matches.publ as prog_publ, matches.published as ref_publ, matches.publ_doc as doc_publ, matches.publ_ref_obs as ref_obs_publ, "-" as dash')
                ->join('teams as team1', 'team1.team_id','=', 'matches.team1')
                ->join('teams as team2', 'team2.team_id','=', 'matches.team2')
                ->join('group1', 'group1.aa_group' ,'=','matches.group1')
                ->join('champs', 'group1.category' ,'=','champs.champ_id')
                ->join('fields', 'fields.aa_gipedou','=','matches.court')
                ->where('matches.date_time','<>','0000-00-00 00:00:00')
                ->when($men==1, function($query){
                        return $query->where('group1.category','<=', 10);
                })
                ->when($kids==1, function($query){
                        return $query->where('group1.category','>=', 50);
                })
                ->whereBetween('matches.date_time',array($date_from, $date_to))
                ->orderby('matches.group1', 'asc')
                ->orderby('matches.date_time', 'asc')
                ->get();
        
        $response= Datatables::of($matches)
       
        ->addColumn('match', function($matches){
                return $matches->ghp.' - '.$matches->fil;
            })
        ->addColumn('date', function($matches){
            if ($matches->date_time==config('default.datetime')){
                $date='-';
                $dataDate=Carbon::now()->format('d/m/Y H:i');
            }else{
                $date=Carbon::parse($matches->date_time)->format('d/m/Y H:i');
                $dataDate=Carbon::parse($matches->date_time)->format('d/m/Y H:i');
            }
            return $date;
            })
        ->addColumn('score', function($matches){
                return $matches->score_team_1.' - '.$matches->score_team_2;
            })
        ->addColumn('code', function($matches){
                return '#'.$matches->aa_game.'#';
            });
        $response=$response->make(true);
        return $response;
    }


    /**
     * Check Court indegrity.
     *
     * @param  \App\referees  $referees
     * @return \Illuminate\Http\Response
     */







   

}
