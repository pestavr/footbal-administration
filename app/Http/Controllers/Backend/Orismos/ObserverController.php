<?php

namespace App\Http\Controllers\Backend\Orismos;

use Redirect;
use DB;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Controllers\Controller;
use App\Models\Backend\matches;
use App\Models\Backend\team;
use Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;

class ObserverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return view('backend.orismos.observer.index');
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function per_date(){
        return view('backend.orismos.observer.date');
    }

    public function openCourtCheck(){
        return view('backend.orismos.observer.courtCheck');
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
    public function store(Request $request)
    {
        //
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
        $matches= matches::selectRaw('matches.aa_game as id, matches.*, team1.onoma_web as ghp, team2.onoma_web as fil, fields.eps_name as arena, fields.aa_gipedou as arena_id, group1.title as catego, group1.category as cat, group1.locked as groupLocked, matches.score_team_1 as score1, matches.score_team_2 as score2, matches.publ_wa as wa_publ, paratirites.waLastName as wa_lastname, paratirites.waFirstName as wa_firstname, paratirites.wa_id as wa_id')
                ->join('teams as team1', 'team1.team_id','=', 'matches.team1')
                ->join('teams as team2', 'team2.team_id','=', 'matches.team2')
                ->join('group1', 'group1.aa_group' ,'=','matches.group1')
                ->join('fields', 'fields.aa_gipedou','=','matches.court')
                ->join('paratirites', 'matches.paratiritis','=', 'paratirites.wa_id')
                ->where('matches.group1','=', $category)
                ->whereBetween('matches.match_day',array($md_from, $md_to))
                ->orderby('matches.date_time', 'desc')
                ->get();
        return Datatables::of($matches)
        
        ->addColumn('match', function($matches){
                return '<center>'.$matches->ghp.' - '.$matches->fil.'</center>';
            })
        ->addColumn('date-court', function($matches){
            if ($matches->date_time=='0000-00-00 00:00:00'){
                $date='';
                $dataDate=Carbon::now()->format('d/m/Y H:i');
            }else{
                $date=Carbon::parse($matches->date_time)->format('d/m/Y H:i');
                $dataDate=Carbon::parse($matches->date_time)->format('d/m/Y H:i');
            }
            return '<center>'.$date.'<br/>'.$matches->arena.'</center>';
            })
        ->addColumn('category', function($matches){
             
            return '<center>'.$matches->catego.'<br/>'.$matches->match_day.'η'.'</center>';
            })
        ->addColumn('observer', function($matches){
            $readonly=(strlen($matches->score1)>0 || $matches->groupLocked==1)?true:false;
            return view('backend.orismos.partials.observer',['lastname'=>$matches->wa_lastname, 'firstname'=>$matches->wa_firstname, 'id'=>$matches->wa_id, 'match'=>$matches->id, 'readonly'=> $readonly]);
            })
        ->addColumn('wa_publ', function($matches){
          $readonly=($matches->groupLocked==1)?true:false;
            return view('backend.orismos.partials.wa_publ',['wa_publ'=>$matches->wa_publ, 'match'=>$matches->id, 'readonly'=>$readonly ]);
            })

        ->rawColumns(['category', 'match',  'wa_publ','check', 'observer', 'date-court'])
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
        $matches= matches::selectRaw('matches.aa_game as id, matches.*, team1.onoma_web as ghp, team2.onoma_web as fil, fields.eps_name as arena, fields.aa_gipedou as arena_id, group1.title as catego, group1.category as cat, group1.locked as groupLocked, matches.score_team_1 as score1, matches.score_team_2 as score2, matches.publ_wa as wa_publ,  
            paratirites.waLastName as wa_lastname, paratirites.waFirstName as wa_firstname, paratirites.wa_id as wa_id')
                ->join('teams as team1', 'team1.team_id','=', 'matches.team1')
                ->join('teams as team2', 'team2.team_id','=', 'matches.team2')
                ->join('group1', 'group1.aa_group' ,'=','matches.group1')
                ->join('fields', 'fields.aa_gipedou','=','matches.court')
                ->join('paratirites', 'matches.paratiritis','=', 'paratirites.wa_id')
                ->whereBetween('matches.date_time',array($date_from, $date_to))
                ->orderby('matches.date_time', 'desc')
                ->get();
        return Datatables::of($matches)
        
        ->addColumn('match', function($matches){
                return '<center>'.$matches->ghp.' - '.$matches->fil.'</center>';
            })
        ->addColumn('date-court', function($matches){
            if ($matches->date_time=='0000-00-00 00:00:00'){
                $date='';
                $dataDate=Carbon::now()->format('d/m/Y H:i');
            }else{
                $date=Carbon::parse($matches->date_time)->format('d/m/Y H:i');
                $dataDate=Carbon::parse($matches->date_time)->format('d/m/Y H:i');
            }
            return '<center>'.$date.'<br/>'.$matches->arena.'</center>';
            })
        ->addColumn('category', function($matches){
             
            return '<center>'.$matches->catego.'<br/>'.$matches->match_day.'η'.'</center>';
            })
        ->addColumn('observer', function($matches){
            $readonly=(strlen($matches->score1)>0 || $matches->groupLocked==1)?true:false;
            return view('backend.orismos.partials.observer',['lastname'=>$matches->wa_lastname, 'firstname'=>$matches->wa_firstname, 'id'=>$matches->wa_id, 'match'=>$matches->id, 'readonly'=> $readonly]);
            })
        ->addColumn('wa_publ', function($matches){
          $readonly=($matches->groupLocked==1)?true:false;
            return view('backend.orismos.partials.wa_publ',['wa_publ'=>$matches->wa_publ, 'match'=>$matches->id, 'readonly'=>$readonly ]);
            })

        ->rawColumns(['category', 'match',  'wa_publ','check', 'observer', 'date-court'])
        ->make(true);
             
      

    }





    /**
     * Check if referee is at another match at the same date and time
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\referees  $referees
     * @return \Illuminate\Http\Response
     */
    public function checkOtherMatch()
    {
        $ref= Input::get('id');
        $match_id= Input::get('match_id');
        $response= true;
        $isMatch=matches::findOrFail($match_id);
        $matches=matches::selectRaw('matches.*, team1.onoma_web as t1, team2.onoma_web as t2')
                        ->join('teams as team1', 'team1.team_id','=', 'matches.team1')
                        ->join('teams as team2', 'team2.team_id','=', 'matches.team2')
                        ->where('paratiritis','=', $ref)
                          ->where('matches.date_time','>=',Carbon::parse($isMatch->date_time)->subHours(config('settings.ref_time'))->format('Y/m/d H:i'))
                          ->where('matches.date_time','<=',Carbon::parse($isMatch->date_time)->addHours(config('settings.ref_time'))->format('Y/m/d H:i'))
                          ->where('aa_game','<>',$match_id)
                          ->get();
    
        if (count($matches)){
            foreach ($matches as $m){
                $response=false;
                $msg='Έχει ορισθεί στην αναμέτρηση '.$m->t1.'- '.$m->t2.' στις '.Carbon::parse($m->date_time)->format('Y/m/d H:i');
            }
            
        }else{
            $response=true;
            $msg='';
            
        }
        /*History Log record*/
        //event(new refereesUpdate($referees));

        return view('backend.orismos.partials.check', compact('response', 'msg'));

    }
    /**
     * Assigns referee with match
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\referees  $referees
     * @return \Illuminate\Http\Response
     */
        public function save()
    {
        $ref= Input::get('id');
        $match_id= Input::get('match_id');
        $col= Input::get('kind');
        $response= true;
        $isMatch=matches::findOrFail($match_id);
        $isMatch->paratiritis=$ref;
        $save=$isMatch->save();
        
        if (!$save){
                $response=false;
                $msg='Server Error';
            
        }else{
            $response=true;
            $msg='';
            
        }
        /*History Log record*/
        //event(new refereesUpdate($referees));

        return view('backend.orismos.partials.check', compact('response', 'msg'));

    }
    /**
     * Save published status 
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\referees  $referees
     * @return \Illuminate\Http\Response
     */
        public function savePubl()
    {
        
        $match_id= Input::get('match_id');
        $status= Input::get('status');
        $response= 1;
        $isMatch=matches::findOrFail($match_id);
        $isMatch->publ_wa=$status;
        $save=$isMatch->save();
        
        if (!$save){
                $response=0;
                $msg='Server Error';
            
        }else{
            $response=1;
            $msg='';
            
        }
        /*History Log record*/
        //event(new refereesUpdate($referees));

        return $response;

    }
    
     /**
     * return how many matches has the referee plays with each team
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\referees  $referees
     * @return \Illuminate\Http\Response
     */
        public function team1()
    {
        $ref= Input::get('id');
        $match_id= Input::get('match_id');
        $response= true;
        $msg='';
        $isMatch=matches::findOrFail($match_id);
         $nmatches=matches::selectRaw('count(matches.aa_game) as n_of_matches')
                        ->join('teams as team1', 'team1.team_id','=', 'matches.team1')
                        ->join('teams as team2', 'team2.team_id','=', 'matches.team2')
                         ->join('group1', 'group1.aa_group' ,'=','matches.group1')
                          ->where(function($query) use ($ref){
                                    $query->where('referee','=', $ref)
                                          ->orWhere('helper1','=', $ref)
                                          ->orWhere('helper2','=', $ref);
                                    })
                          ->where(function($query) use ($isMatch){
                                    $query->where('team1','=', $isMatch->team1)
                                          ->orWhere('team2','=',$isMatch->team1);
                                    })
                          ->where('aa_game','<>',$match_id)
                          ->where('group1.aa_period','=',session('season'))
                          ->get();
       
        $matches= matches::selectRaw('matches.*, team1.onoma_web as t1, team2.onoma_web as t2')
                        ->join('teams as team1', 'team1.team_id','=', 'matches.team1')
                        ->join('teams as team2', 'team2.team_id','=', 'matches.team2')
                         ->join('group1', 'group1.aa_group' ,'=','matches.group1')
                          ->where(function($query) use ($ref){
                                    $query->where('referee','=', $ref)
                                          ->orWhere('helper1','=', $ref)
                                          ->orWhere('helper2','=', $ref);
                                    })
                          ->where(function($query) use ($isMatch){
                                    $query->where('team1','=', $isMatch->team1)
                                          ->orWhere('team2','=',$isMatch->team1);
                                    })
                          ->where('aa_game','<>',$match_id)
                          ->where('group1.aa_period','=',session('season'))
                          ->get();
        if (count($matches)){
            foreach ($nmatches as $nm){
                $response=$nm->n_of_matches;
                
            }
            foreach($matches as $m){
                 $msg.='Στις '.Carbon::parse($m->date_time)->format('Y/m/d H:i').':'.$m->t1.' '.$m->score_team_1.'-'.$m->score_team_2.' '.$m->t2;
            }
        }else{
            $response=0;
            $msg='';
            
        }
 
        /*History Log record*/
        //event(new refereesUpdate($referees));

        return view('backend.orismos.partials.matches', compact('response', 'msg'));

    }

    public function team2()
    {
        $ref= Input::get('id');
        $match_id= Input::get('match_id');
        $response= true;
        $msg='';
        $isMatch=matches::findOrFail($match_id);
         $nmatches=matches::selectRaw('count(matches.aa_game) as n_of_matches')
                        ->join('teams as team1', 'team1.team_id','=', 'matches.team1')
                        ->join('teams as team2', 'team2.team_id','=', 'matches.team2')
                         ->join('group1', 'group1.aa_group' ,'=','matches.group1')
                          ->where(function($query) use ($ref){
                                    $query->where('referee','=', $ref)
                                          ->orWhere('helper1','=', $ref)
                                          ->orWhere('helper2','=', $ref);
                                    })
                          ->where(function($query) use ($isMatch){
                                    $query->where('team1','=', $isMatch->team2)
                                          ->orWhere('team2','=',$isMatch->team2);
                                    })
                          ->where('aa_game','<>',$match_id)
                          ->where('group1.aa_period','=',session('season'))
                          ->get();
       
        $matches= matches::selectRaw('matches.*, team1.onoma_web as t1, team2.onoma_web as t2')
                        ->join('teams as team1', 'team1.team_id','=', 'matches.team1')
                        ->join('teams as team2', 'team2.team_id','=', 'matches.team2')
                         ->join('group1', 'group1.aa_group' ,'=','matches.group1')
                          ->where(function($query) use ($ref){
                                    $query->where('referee','=', $ref)
                                          ->orWhere('helper1','=', $ref)
                                          ->orWhere('helper2','=', $ref);
                                    })
                          ->where(function($query) use ($isMatch){
                                    $query->where('team1','=', $isMatch->team2)
                                          ->orWhere('team2','=',$isMatch->team2);
                                    })
                          ->where('aa_game','<>',$match_id)
                          ->where('group1.aa_period','=',session('season'))
                          ->get();
        if (count($matches)){
            foreach ($nmatches as $nm){
                $response=$nm->n_of_matches;
                
            }
            foreach($matches as $m){
                 $msg.='Στις '.Carbon::parse($m->date_time)->format('Y/m/d H:i').':'.$m->t1.' '.$m->score_team_1.'-'.$m->score_team_2.' '.$m->t2;
            }
        }else{
            $response=0;
            $msg='';
            
        }
        /*History Log record*/
        //event(new refereesUpdate($referees));

        return view('backend.orismos.partials.matches', compact('response', 'msg'));

    }
    /**
     * Reprogram the specified resource from storage.
     *
     * @param  \App\referees  $referees
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $program= program::findOrFail($id)->delete();


       return Redirect::route('admin.move.program.index');
    }


}
