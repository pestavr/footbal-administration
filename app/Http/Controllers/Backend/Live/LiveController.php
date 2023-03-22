<?php

namespace App\Http\Controllers\Backend\Live;

use Redirect;
use DB;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Controllers\Controller;
use App\Models\Backend\players;
use App\Models\Backend\matches;
use App\Models\Backend\team;
use App\Models\Backend\live;
use Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;

class LiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return view('backend.live.live.index');
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function per_date(){
        return view('backend.live.live.date');
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function match($id){
        return view('backend.live.live.match', compact('id'));
    }

    /* Σελίδα που βλέπουν οι παρατηρητές*/
    public function matchObserver($id){
        return view('backend.live.live.matchObserver', compact('id'));
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
                ->where('matches.live','=',1)
                ->where('matches.group1','=', $category)
                ->whereBetween('matches.match_day',array($md_from, $md_to))
                ->orderby('matches.match_day', 'asc')
                ->get();

        return Datatables::of($matches)
        ->addColumn('actions',function($matches){ 
                $postponed=($matches->postponed==1)?true:false;
                $readonly=(strlen($matches->score1)>0 || $matches->groupLocked==1)?true:false;
                $start=(live::isStarted($matches->id))?true:false;
                $end=(live::isEnded($matches->id))?true:false;
                return view('backend.live.partials.actions',['id'=>$matches->id, 'category'=>$matches->cat, 'postponed'=>$postponed, 'readonly'=>$readonly, 'start'=>$start, 'end'=>$end]);
        })
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
        ->rawColumns(['actions'])
        ->make(true);
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
        
        $date_from= Carbon::parse($date_from)->format('Y/m/d 00:00');
        $date_to= Carbon::parse($date_to)->format('Y/m/d 23:59');
        $matches= matches::selectRaw('matches.aa_game as id, matches.*, team1.onoma_web as ghp, team2.onoma_web as fil, fields.eps_name as arena, fields.aa_gipedou as arena_id, group1.title as category, group1.category as cat, group1.locked as groupLocked, matches.score_team_1 as score1, champs.flexible as flexible, matches.score_team_2 as score2, matches.publ as prog_publ, matches.published as ref_publ, matches.publ_doc as doc_publ, matches.publ_ref_obs as ref_obs_publ, "-" as dash')
                ->join('teams as team1', 'team1.team_id','=', 'matches.team1')
                ->join('teams as team2', 'team2.team_id','=', 'matches.team2')
                ->join('group1', 'group1.aa_group' ,'=','matches.group1')
                ->join('champs', 'group1.category' ,'=','champs.champ_id')
                ->join('fields', 'fields.aa_gipedou','=','matches.court')
                ->where('matches.live','=',1)
                ->where('matches.date_time','<>','0000-00-00 00:00:00')
                ->whereBetween('matches.date_time',array($date_from, $date_to))
                ->orderby('matches.group1', 'asc')
                ->orderby('matches.date_time', 'asc')
                ->get();
       return Datatables::of($matches)
        ->addColumn('actions',function($matches){ 
                $postponed=($matches->postponed==1)?true:false;
                $readonly=(strlen($matches->score1)>0 || $matches->groupLocked==1)?true:false;
                $start=(live::isStarted($matches->id))?true:false;
                $end=(live::isEnded($matches->id))?true:false;
                return view('backend.live.partials.actions',['id'=>$matches->id, 'category'=>$matches->cat, 'postponed'=>$postponed, 'readonly'=>$readonly, 'start'=>$start, 'end'=>$end]);
        })
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
        ->rawColumns(['actions'])
        ->make(true);
    }



    /* Display Score Update Modal*/
    public function score($id){
        $matches=matches::selectRaw('matches.aa_game as id, matches.*, team1.onoma_web as ghp, team2.onoma_web as fil')
                        ->join('teams as team1', 'team1.team_id','=', 'matches.team1')
                        ->join('teams as team2', 'team2.team_id','=', 'matches.team2')
                        ->where('aa_game','=',$id)
                        ->get();

        return view('backend.program.program.scoreModal', compact('matches'));
    }

    public function start($id)
    {
         $live= new live;               
         $live->match_id= $id;
         $live->kind= 1;
         $live->save();

         return redirect()->back()->withFlashSuccess('Επιτυχής Έναρξη της αναμέτρησης στις '.Carbon::parse(Carbon::now())->format('d/m/Y H:i'));     
    }

    public function startB($id)
    {
         $live= new live;               
         $live->match_id= $id;
         $live->kind= 8;
         $live->save();

         return redirect()->back()->withFlashSuccess('Επιτυχής Έναρξη του δεύτερου ημιχρόνου της αναμέτρησης στις '.Carbon::parse(Carbon::now())->format('d/m/Y H:i'));     
    }
    public function end($id)
    {
        $live= new live;               
         $live->match_id= $id;
         $live->kind= 5;
         $live->save();

         return redirect()->back()->withFlashSuccess('Επιτυχής Λήξη της αναμέτρησης στις '.Carbon::parse(Carbon::now())->format('d/m/Y H:i'));      
    }

    public function endA($id)
    {
        $live= new live;               
         $live->match_id= $id;
         $live->kind= 7;
         $live->save();

         return redirect()->back()->withFlashSuccess('Επιτυχής Λήξη της αναμέτρησης στις '.Carbon::parse(Carbon::now())->format('d/m/Y H:i'));      
    }

    public function insertEvent($id)
    {
        $this->validate(request(), [
                'event'=>'required',
                'team'=>'required'
            ]);
        if (live::isStarted($id) && !live::isEnded($id)){
            $live= new live;               
             $live->match_id= $id;
             $live->kind= request('event');
             $live->team= request('team');
             $live->min= request('min');
             $live->player= request('player');
             $live->save();
             return redirect()->back()->withFlashSuccess('Επιτυχής Καταχώρηση του γεγονότος στις '.Carbon::parse(Carbon::now())->format('d/m/Y H:i'));    
        }else{
            return redirect()->back()->withFlashDanger('Δεν μπορείτε να καταχωρήσετε γεγονότα στην αναμέρηση');
        }      
    }
    public function goal($id, $team)
    {

        if (live::isStarted($id) && !live::isEnded($id)){
            $live= new live;               
             $live->match_id= $id;
             $live->kind= 2;
             $live->team= $team;
             $live->min= live::computeMin($id);
             //$live->player= request('player');
             $live->save();
             return redirect()->back()->withFlashSuccess('Επιτυχής Καταχώρηση του γεγονότος στις '.Carbon::parse(Carbon::now())->format('d/m/Y H:i'));    
        }else{
            return redirect()->back()->withFlashDanger('Δεν μπορείτε να καταχωρήσετε γεγονότα στην αναμέρηση');
        }      
    }

    public function red($id, $team)
    {

        if (live::isStarted($id) && !live::isEnded($id)){
            $live= new live;               
             $live->match_id= $id;
             $live->kind= 3;
             $live->team= $team;
             $live->min= live::computeMin($id);
             //$live->player= request('player');
             $live->save();
             return redirect()->back()->withFlashSuccess('Επιτυχής Καταχώρηση του γεγονότος στις '.Carbon::parse(Carbon::now())->format('d/m/Y H:i'));    
        }else{
            return redirect()->back()->withFlashDanger('Δεν μπορείτε να καταχωρήσετε γεγονότα στην αναμέρηση');
        }      
    }

    public function yellow($id, $team)
    {

        if (live::isStarted($id) && !live::isEnded($id)){
            $live= new live;               
             $live->match_id= $id;
             $live->kind= 4;
             $live->team= $team;
             $live->min= live::computeMin($id);
             //$live->player= request('player');
             $live->save();
             return redirect()->back()->withFlashSuccess('Επιτυχής Καταχώρηση του γεγονότος στις '.Carbon::parse(Carbon::now())->format('d/m/Y H:i'));    
        }else{
            return redirect()->back()->withFlashDanger('Δεν μπορείτε να καταχωρήσετε γεγονότα στην αναμέρηση');
        }      
    }

    public function owngoal($id, $team)
    {

        if (live::isStarted($id) && !live::isEnded($id)){
            $live= new live;               
             $live->match_id= $id;
             $live->kind= 6;
             $live->team= $team;
             $live->min= live::computeMin($id);
             //$live->player= request('player');
             $live->save();
             return redirect()->back()->withFlashSuccess('Επιτυχής Καταχώρηση του γεγονότος στις '.Carbon::parse(Carbon::now())->format('d/m/Y H:i'));    
        }else{
            return redirect()->back()->withFlashDanger('Δεν μπορείτε να καταχωρήσετε γεγονότα στην αναμέρηση');
        }      
    }
    public function getLiveMatch()
    {
        $match=request('match_id');
        $live= live::selectRaw('live.*, teams.onoma_web as team_name')
                ->leftJoin('teams', 'teams.team_id','=', 'live.team')
                ->where('match_id','=',$match)
                ->orderby('created_at', 'asc')
                ->get();
       return Datatables::of($live)
        ->addColumn('actions',function($live){ 
                return view('backend.live.partials.matchActions',['id'=>$live->id]);
        })
        ->addColumn('event', function($live){
            $kind= [1=>'Έναρξη',2=>'Γκολ', 3=>'Κόκκινη Κάρτα', 4=>'Κίτρινη Κάρτα', 5=>'Τέλος Αναμέτρησης', 6=>'Αυτογκόλ', 7=>'Λήξη Α Ημιχρόνου', 8=>'Έναρξη Β Ημιχρόνου'];
                return $kind[$live->kind];
            })
        ->rawColumns(['actions'])
        ->make(true);     
    }


    public function delete($id)
    {
        $live= live::findOrFail($id)->delete();               
         
         return redirect()->back()->withFlashSuccess('Επιτυχής Διαγραφή');      
    }


   

}
