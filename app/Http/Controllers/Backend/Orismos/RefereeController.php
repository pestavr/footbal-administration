<?php

namespace App\Http\Controllers\Backend\Orismos;

use Redirect;
use DB;
use Mail;
use App\Models\Backend\referees;
use App\Models\Backend\eps;
use App\Models\Backend\team;
use App\Models\Access\User\User;
use App\Mail\NotifyReferees;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Controllers\Controller;
use App\Models\Backend\matches;
use App\Models\Backend\refTimeKol;
use App\Models\Backend\teamBlock;
use App\Models\Backend\RefereeNotification;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;

class RefereeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return view('backend.orismos.referee.index');
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function per_date(){
        return view('backend.orismos.referee.date');
    }

    public function openCourtCheck(){
        return view('backend.orismos.referee.courtCheck');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function epoReport(){
        return view('backend.orismos.referee.epoReport');
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
        $matches= matches::selectRaw('matches.aa_game as id, matches.*, team1.onoma_web as ghp, team2.onoma_web as fil, fields.eps_name as arena, fields.aa_gipedou as arena_id, group1.title as catego, group1.category as cat, group1.locked as groupLocked,  matches.score_team_1 as score1, matches.score_team_2 as score2, matches.publ as prog_publ, matches.published as ref_publ, matches.notified as ref_nof, 
            ref.Lastname as ref_lastname, ref.Firstname as ref_firstname, ref.refaa as ref_id,
            h1.Lastname as h1_lastname, h1.Firstname as h1_firstname, h1.refaa as h1_id,
            h2.Lastname as h2_lastname, h2.Firstname as h2_firstname, h2.refaa as h2_id')
                ->join('teams as team1', 'team1.team_id','=', 'matches.team1')
                ->join('teams as team2', 'team2.team_id','=', 'matches.team2')
                ->join('group1', 'group1.aa_group' ,'=','matches.group1')
                ->join('fields', 'fields.aa_gipedou','=','matches.court')
                ->join('referees as ref', 'matches.referee','=', 'ref.refaa')
                ->join('referees as h1', 'matches.helper1','=', 'h1.refaa')
                ->join('referees as h2', 'matches.helper2','=', 'h2.refaa')
                ->where('matches.group1','=', $category)
                ->whereBetween('matches.match_day',array($md_from, $md_to))
                ->orderby('matches.date_time', 'desc')
                ->get();
        return Datatables::of($matches)
        ->addColumn('actions',function($matches){
                //return view('backend.includes.partials.program-actions',['id'=>$matches->id, 'category'=>$matches->cat, 'page'=>'matches']);
        })
        ->addColumn('match', function($matches){
                return '<center>'.$matches->ghp.' - '.$matches->fil.'</center>';
            })
        ->addColumn('date-court', function($matches){
            if ($matches->date_time==config('default.datetime')){
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
        ->addColumn('referee', function($matches){
            $readonly=(strlen($matches->score1)>0 || $matches->groupLocked==1)?true:false;
            if ($matches->ref_id == config('default.referee')){
              $ref_days='';
              $refBlock='';
              $teamBlock='';
              $sameTime='';
              $accepted = null;
            } else {
                $ref_days = $this->checkDay($matches->ref_id, $matches->id);
                $refBlock = $this->checkRefBlocks($matches->ref_id, $matches->id);
                $teamBlock = $this->checkTeamBlocks($matches->ref_id, $matches->id);
                $sameTime = $this->checkOtherMatches($matches->ref_id, $matches->id);
                $accepted = RefereeNotification::whereMatchId($matches->id)->whereRefereeId($matches->ref_id)->first();
            }
            return view('backend.orismos.partials.referee',[
                'lastname' => $matches->ref_lastname, 
                'firstname' => $matches->ref_firstname, 
                'id' => $matches->ref_id, 
                'match' => $matches->id, 
                'readonly' => $readonly, 
                'ref_days' => $ref_days, 
                'refBlock' => $refBlock, 
                'teamBlock' => $teamBlock, 
                'sameTime' => $sameTime,
                'accepted' => ($accepted) ? $accepted : null
            ]);
            })
        ->addColumn('helper1', function($matches){
            $readonly=(strlen($matches->score1)>0 || $matches->groupLocked==1)?true:false;
            if ($matches->h1_id==config('default.referee')){
              $ref_days='';
              $refBlock='';
              $teamBlock='';
              $sameTime='';
              $accepted = null;
            }
            else
            {
                $ref_days = $this->checkDay($matches->h1_id, $matches->id);
                $refBlock = $this->checkRefBlocks($matches->h1_id, $matches->id);
                $teamBlock = $this->checkTeamBlocks($matches->h1_id, $matches->id);
                $sameTime = $this->checkOtherMatches($matches->h1_id, $matches->id);
                $accepted = RefereeNotification::whereMatchId($matches->id)->whereRefereeId($matches->h1_id)->first();
            }
            

            return view('backend.orismos.partials.helper1',[
                'lastname'=>$matches->h1_lastname, 
                'firstname'=>$matches->h1_firstname, 
                'id'=>$matches->h1_id, 
                'match'=>$matches->id, 
                'readonly'=> $readonly, 
                'ref_days'=>$ref_days, 
                'refBlock'=>$refBlock, 
                'teamBlock'=>$teamBlock, 
                'sameTime'=>$sameTime,
                'accepted' => ($accepted) ? $accepted : null
            ]);
            })
        ->addColumn('helper2', function($matches){
            $readonly=(strlen($matches->score1)>0 || $matches->groupLocked==1)?true:false;
            if ($matches->h2_id==config('default.referee')){
              $ref_days='';
              $refBlock='';
              $teamBlock='';
              $sameTime='';
              $accepted = null;
            }
            else
            {
                $ref_days=$this->checkDay($matches->h2_id, $matches->id);
                $refBlock=$this->checkRefBlocks($matches->h2_id, $matches->id);
                $teamBlock=$this->checkTeamBlocks($matches->h2_id, $matches->id);
                $sameTime=$this->checkOtherMatches($matches->h2_id, $matches->id);
                $accepted = RefereeNotification::whereMatchId($matches->id)->whereRefereeId($matches->h2_id)->first();
            }
            return view('backend.orismos.partials.helper2',[
                'lastname'=>$matches->h2_lastname, 
                'firstname'=>$matches->h2_firstname, 
                'id'=>$matches->h2_id, 
                'match'=>$matches->id, 
                'readonly'=> $readonly, 
                'ref_days'=>$ref_days, 
                'refBlock'=>$refBlock, 
                'teamBlock'=>$teamBlock, 
                'sameTime'=>$sameTime,
                'accepted' => ($accepted) ? $accepted : null
            ]);
            })
        ->addColumn('ref_publ', function($matches){
             $readonly=($matches->groupLocked==1)?true:false;
            return view('backend.orismos.partials.ref_publ',['ref_publ'=>$matches->ref_publ, 'match'=>$matches->id, 'readonly'=>$readonly ]);
            })
        ->addColumn('ref_nof', function($matches){
             $readonly = ($matches->groupLocked == 1) ? true : false;
            return view('backend.orismos.partials.ref_nof',[
                'ref_nof' => $matches->ref_nof, 
                'match' => $matches->id, 
                'readonly' =>$readonly 
            ]);
            })
        ->addColumn('check', function($matches){
                return '<input type="checkbox" class="form-check-input match" name="selected_matches[]" value="'.$matches->id.'" checked="checked">';   
            }) 
        ->rawColumns(['category','actions', 'match',  'ref_publ', 'prog_publ','check', 'referee', 'helper1', 'helper2', 'date-court', 'ref_nof'])
        ->make(true);
    }


//Πρόγραμμα με φύλλα αγώνα ανά κατηγορία και αγωνιστική 
    public function programDate(Request $request){
        $date_from=str_replace($request->date_from, '/', '-');
        $date_to=str_replace($request->date_to, '/', '-');
        if (!is_null($request->date_from) && !is_null($request->date_to)){
            $date_from = Carbon::createFromFormat('d/m/Y', request('date_from'));
            $date_to = Carbon::createFromFormat('d/m/Y', request('date_to'));
        }else{
            $date_from=Carbon::parse(Carbon::now())->format('Y-m-d');
            $date_to=Carbon::parse(Carbon::now())->format('Y-m-d');
        }
        $date_from= Carbon::parse($date_from)->format('Y-m-d');
        $date_to= Carbon::parse($date_to)->format('Y-m-d');


        $date_from= Carbon::parse($date_from)->format('Y/m/d 00:00');
        $date_to= Carbon::parse($date_to)->format('Y/m/d 23:59');
        $matches= matches::selectRaw('matches.aa_game as id, matches.*, team1.onoma_web as ghp, team2.onoma_web as fil, fields.eps_name as arena, fields.aa_gipedou as arena_id, group1.title as catego, group1.category as cat, group1.locked as groupLocked, matches.score_team_1 as score1, matches.score_team_2 as score2, matches.publ as prog_publ, matches.published as ref_publ, matches.notified as ref_nof, 
            ref.Lastname as ref_lastname, ref.Firstname as ref_firstname, ref.refaa as ref_id,
            h1.Lastname as h1_lastname, h1.Firstname as h1_firstname, h1.refaa as h1_id,
            h2.Lastname as h2_lastname, h2.Firstname as h2_firstname, h2.refaa as h2_id')
                ->join('teams as team1', 'team1.team_id','=', 'matches.team1')
                ->join('teams as team2', 'team2.team_id','=', 'matches.team2')
                ->join('group1', 'group1.aa_group' ,'=','matches.group1')
                ->join('fields', 'fields.aa_gipedou','=','matches.court')
                ->join('referees as ref', 'matches.referee','=', 'ref.refaa')
                ->join('referees as h1', 'matches.helper1','=', 'h1.refaa')
                ->join('referees as h2', 'matches.helper2','=', 'h2.refaa')
                ->whereBetween('matches.date_time',array($date_from, $date_to))
                ->orderby('group1.title', 'asc')
                ->orderby('matches.date_time', 'desc')
                ->get();
         return Datatables::of($matches)
        ->addColumn('actions',function($matches){
                //return $herbs->getEditButtonAttribute($herbs->id);
                //return view('backend.includes.partials.program-actions',['id'=>$matches->id, 'category'=>$matches->cat, 'page'=>'matches']);
        })
        ->addColumn('match', function($matches){
                return '<center>'.$matches->ghp.' - '.$matches->fil.'</center>';
            })
        ->addColumn('date-court', function($matches){
            if ($matches->date_time==config('default.datetime')){
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
            ->addColumn('referee', function($matches){
                $readonly=(strlen($matches->score1)>0 || $matches->groupLocked==1)?true:false;
                if ($matches->ref_id == config('default.referee')){
                  $ref_days='';
                  $refBlock='';
                  $teamBlock='';
                  $sameTime='';
                  $accepted = null;
                } else {
                    $ref_days = $this->checkDay($matches->ref_id, $matches->id);
                    $refBlock = $this->checkRefBlocks($matches->ref_id, $matches->id);
                    $teamBlock = $this->checkTeamBlocks($matches->ref_id, $matches->id);
                    $sameTime = $this->checkOtherMatches($matches->ref_id, $matches->id);
                    $accepted = RefereeNotification::whereMatchId($matches->id)->whereRefereeId($matches->ref_id)->first();
                }
                return view('backend.orismos.partials.referee',[
                    'lastname' => $matches->ref_lastname, 
                    'firstname' => $matches->ref_firstname, 
                    'id' => $matches->ref_id, 
                    'match' => $matches->id, 
                    'readonly' => $readonly, 
                    'ref_days' => $ref_days, 
                    'refBlock' => $refBlock, 
                    'teamBlock' => $teamBlock, 
                    'sameTime' => $sameTime,
                    'accepted' => ($accepted) ? $accepted : null
                ]);
                })
            ->addColumn('helper1', function($matches){
                $readonly=(strlen($matches->score1)>0 || $matches->groupLocked==1)?true:false;
                if ($matches->h1_id==config('default.referee')){
                  $ref_days='';
                  $refBlock='';
                  $teamBlock='';
                  $sameTime='';
                  $accepted = null;
                }
                else
                {
                    $ref_days = $this->checkDay($matches->h1_id, $matches->id);
                    $refBlock = $this->checkRefBlocks($matches->h1_id, $matches->id);
                    $teamBlock = $this->checkTeamBlocks($matches->h1_id, $matches->id);
                    $sameTime = $this->checkOtherMatches($matches->h1_id, $matches->id);
                    $accepted = RefereeNotification::whereMatchId($matches->id)->whereRefereeId($matches->h1_id)->first();
                }
                
    
                return view('backend.orismos.partials.helper1',[
                    'lastname'=>$matches->h1_lastname, 
                    'firstname'=>$matches->h1_firstname, 
                    'id'=>$matches->h1_id, 
                    'match'=>$matches->id, 
                    'readonly'=> $readonly, 
                    'ref_days'=>$ref_days, 
                    'refBlock'=>$refBlock, 
                    'teamBlock'=>$teamBlock, 
                    'sameTime'=>$sameTime,
                    'accepted' => ($accepted) ? $accepted : null
                ]);
                })
            ->addColumn('helper2', function($matches){
                $readonly=(strlen($matches->score1)>0 || $matches->groupLocked==1)?true:false;
                if ($matches->h2_id==config('default.referee')){
                  $ref_days='';
                  $refBlock='';
                  $teamBlock='';
                  $sameTime='';
                  $accepted = null;
                }
                else
                {
                    $ref_days=$this->checkDay($matches->h2_id, $matches->id);
                    $refBlock=$this->checkRefBlocks($matches->h2_id, $matches->id);
                    $teamBlock=$this->checkTeamBlocks($matches->h2_id, $matches->id);
                    $sameTime=$this->checkOtherMatches($matches->h2_id, $matches->id);
                    $accepted = RefereeNotification::whereMatchId($matches->id)->whereRefereeId($matches->h2_id)->first();
                }
                return view('backend.orismos.partials.helper2',[
                    'lastname'=>$matches->h2_lastname, 
                    'firstname'=>$matches->h2_firstname, 
                    'id'=>$matches->h2_id, 
                    'match'=>$matches->id, 
                    'readonly'=> $readonly, 
                    'ref_days'=>$ref_days, 
                    'refBlock'=>$refBlock, 
                    'teamBlock'=>$teamBlock, 
                    'sameTime'=>$sameTime,
                    'accepted' => ($accepted) ? $accepted : null
                ]);
                })
        ->addColumn('ref_publ', function($matches){
             $readonly=($matches->groupLocked==1)?true:false;
            return view('backend.orismos.partials.ref_publ',['ref_publ'=>$matches->ref_publ, 'match'=>$matches->id, 'readonly'=>$readonly ]);
            })
        ->addColumn('ref_nof', function($matches){
                $readonly = ($matches->groupLocked == 1) ? true : false;
               return view('backend.orismos.partials.ref_nof',[
                   'ref_nof' => $matches->ref_nof, 
                   'match' => $matches->id, 
                   'readonly' =>$readonly 
               ]);
               })
        ->addColumn('check', function($matches){
                return '<input type="checkbox" class="form-check-input match" name="selected_matches[]" value="'.$matches->id.'" checked="checked">';   
            }) 
        ->rawColumns(['category','actions', 'match',  'ref_publ', 'prog_publ','check', 'referee', 'helper1', 'helper2', 'date-court', 'ref_nof'])
        ->make(true);

    }


     public function showEpoReport(){

        $date_from= request('date_from');

        if(is_null($date_from)){
            $date_from= Carbon::now()->format('mm-yyyy');
        }

        $mY=explode('-',$date_from);
        
        $date_from= $mY[1].'/'.$mY[0].'/1 00:00';
        $date_to= $mY[1].'/'.$mY[0].'/31 23:59';
        $matches= matches::selectRaw('matches.aa_game as id, matches.*, team1.onoma_web as ghp, team2.onoma_web as fil, fields.eps_name as arena, fields.aa_gipedou as arena_id, group1.title as category, group1.category as cat, group1.locked as groupLocked, matches.score_team_1 as score1, champs.category as catName, matches.score_team_2 as score2, matches.publ as prog_publ, matches.published as ref_publ, matches.publ_doc as doc_publ, matches.publ_ref_obs as ref_obs_publ, "-" as dash, 
            ref.Lastname as ref_lastname, ref.Firstname as ref_firstname, ref.refaa as ref_id,
            h1.Lastname as h1_lastname, h1.Firstname as h1_firstname, h1.refaa as h1_id,
            h2.Lastname as h2_lastname, h2.Firstname as h2_firstname, h2.refaa as h2_id,
            ref_paratirites.waLastName as wa_lastname, ref_paratirites.waFirstName as wa_firstname')
                ->join('teams as team1', 'team1.team_id','=', 'matches.team1')
                ->join('teams as team2', 'team2.team_id','=', 'matches.team2')
                ->join('group1', 'group1.aa_group' ,'=','matches.group1')
                ->join('champs', 'group1.category' ,'=','champs.champ_id')
                ->join('fields', 'fields.aa_gipedou','=','matches.court')
                ->join('referees as ref', 'matches.referee','=', 'ref.refaa')
                ->join('referees as h1', 'matches.helper1','=', 'h1.refaa')
                ->join('referees as h2', 'matches.helper2','=', 'h2.refaa')
                ->join('ref_paratirites', 'matches.ref_paratiritis','=', 'ref_paratirites.wa_id')
                ->where('matches.date_time','<>',config('default.datetime'))
                ->where('group1.category','<=', 10)
                ->whereBetween('matches.date_time',array($date_from, $date_to))
                ->orderby('matches.group1', 'asc')
                ->orderby('matches.date_time', 'asc')
                ->get();
        
        $response= Datatables::of($matches)
        ->addColumn('competition', function($matches){
                return substr($matches->catName, 0, 2);
            })
        ->addColumn('referee', function($matches){
                return $matches->ref_lastname.' '.$matches->ref_firstname;
            })
        ->addColumn('helper1', function($matches){
                return $matches->h1_lastname.' '.$matches->h1_firstname;
            })
        ->addColumn('helper2', function($matches){
                return $matches->h2_lastname.' '.$matches->h2_firstname;
            })
        ->addColumn('ref_paratiritis', function($matches){
                return $matches->wa_lastname.' '.$matches->wa_firstname;
            })
        ->addColumn('date', function($matches){
            if ($matches->date_time==config('default.datetime')){
                $date='-';
                $dataDate=Carbon::now()->format('d/m/Y H:i');
            }else{
                $date=Carbon::parse($matches->date_time)->format('d/m/Y');
                $dataDate=Carbon::parse($matches->date_time)->format('d/m/Y');
            }
            return $date;
            })
        ->addColumn('time', function($matches){
            if ($matches->date_time==config('default.datetime')){
                $date='-';
                $dataDate=Carbon::now()->format('d/m/Y H:i');
            }else{
                $date=Carbon::parse($matches->date_time)->format('H:i');
                $dataDate=Carbon::parse($matches->date_time)->format('H:i');
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
     * Saves the program for the selected matches.
     *
     * @param  \App\program  $program
     * @return \Illuminate\Http\Response
     */
    public function saveSelected()
    {
        
        $matches = Input::get('selected_matches');
        if (sizeof($matches)>0){
        foreach ($matches as $match){
            $datetime=request('datetime-'.$match);
            $court=request('court_id-'.$match);
            $score1=request('score1-'.$match);
            $score2=request('score2-'.$match);
            if( Request::input('published-'.$match) ) {
                    $publ=1;
                } else {
                    $publ=0;
                }
            
            $format = 'd/m/Y H:i';
            $datetime = Carbon::createFromFormat($format, $datetime); 
             $cur_match= matches::findOrFail($match);
             $cur_match->date_time= Carbon::parse($datetime)->format('Y/m/d H:i');
             $cur_match->court=$court;
             $cur_match->score_team_1=$score1;
             $cur_match->score_team_2=$score2;
             $cur_match->publ=$publ;
             $cur_match->save();
        }

       return redirect()->back()->withFlashSuccess('Επιτυχής Αποθήκευση');
   }else{
        return redirect()->back()->withFlashDanger('Δεν έχετε επιλέξει κάποια αναμέτρηση');
   }
    }


    /**
     * Check how many days has the referee play with the same team
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\referees  $referees
     * @return \Illuminate\Http\Response
     */
    public function checkDays()
    {
        $ref= Input::get('id');
        $match_id= Input::get('match_id');
        $response= true;
        $isMatch=matches::findOrFail($match_id);
        $matches=matches::selectRaw('matches.*')
                          ->where(function($query) use ($ref){
                                    $query->where('referee','=', $ref)
                                          ->orWhere('helper1','=', $ref)
                                          ->orWhere('helper2','=', $ref);
                                    })
                          ->where(function($query) use ($isMatch){
                                    $query->where('team1','=', $isMatch->team1)
                                          ->orWhere('team2','=',$isMatch->team2)
                                          ->orWhere('team2','=', $isMatch->team1)
                                          ->orWhere('team1','=',$isMatch->team2);
                                    })
                          ->where('matches.date_time','>=',Carbon::parse($isMatch->date_time)->subDays(config('settings.ref_days'))->format('Y/m/d'))
                          ->where('aa_game','<>',$match_id)
                          ->get();
    
        if (count($matches)){
            foreach ($matches as $m){
                $response=false;
                $msg='Έχει ορισθεί με την ίδια ομάδα στον αγώνα'.$m->aa_game;
            }
            
        }
        else{
            $response=true;
            $msg='';
            
        }
        /*History Log record*/
        //event(new refereesUpdate($referees));

        return view('backend.orismos.partials.check', compact('response', 'msg'));

    }

        public function checkDay($id, $match)
    {
        $ref= $id;
        $match_id= $match;
        $response= true;
        $isMatch=matches::findOrFail($match_id);
        $matches=matches::selectRaw('matches.*')
                          ->where(function($query) use ($ref){
                                    $query->where('referee','=', $ref)
                                          ->orWhere('helper1','=', $ref)
                                          ->orWhere('helper2','=', $ref);
                                    })
                          ->where(function($query) use ($isMatch){
                                    $query->where('team1','=', $isMatch->team1)
                                          ->orWhere('team2','=',$isMatch->team2)
                                          ->orWhere('team2','=', $isMatch->team1)
                                          ->orWhere('team1','=',$isMatch->team2);
                                    })
                          ->where('matches.date_time','>=',Carbon::parse($isMatch->date_time)->subDays(config('settings.ref_days'))->format('Y/m/d'))
                          ->where('aa_game','<>',$match_id)
                          ->get();
    
        if (count($matches)){
            foreach ($matches as $m){
                $response=false;
                $msg='Έχει ορισθεί με την ίδια ομάδα στον αγώνα'.$m->aa_game;
            }
            
        }
        else{
            $response=true;
            $msg='';
            
        }
        

        $html= view('backend.orismos.partials.check', compact('response', 'msg'))->render();

        return $html;

    }

    /**
     * Check if referee have an issue for the date and time of the match 
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\referees  $referees
     * @return \Illuminate\Http\Response
     */
    public function checkRefBlock()
    {
        $ref= Input::get('id');
        $match_id= Input::get('match_id');
        $response= true;
        $isMatch=matches::findOrFail($match_id);
        $kwlymata=refTimeKol::selectRaw('*')
                          ->where('ref','=',$ref)
                          ->get();
        $days= [1=>'Δευτέρα', 2=>'Τρίτη', 3=>'Tετάρτη', 4=>'Πέμπτη', 5=>'Παρασκευή', 6=>'Σάββατο', 7=>'Κυριακή'];
        $match_date_time=Carbon::parse($isMatch->date_time);
        $day=$match_date_time->dayOfWeekIso;
        $hour=$match_date_time->hour;
        $minute=$match_date_time->minute;
        $response=true;
        $msg='';
            foreach ($kwlymata as $m){
                $data=json_decode($m->data, true);
                if ($data['kind']==1){
                    $dateFrom=Carbon::parse($data['dateFrom']);
                    $dateTo=Carbon::parse($data['dateTo']);
                    if ($match_date_time->gte($dateFrom) && $match_date_time->lte($dateTo)){
                         $response=false;
                        $msg='O Διαιτητής έχει κώλυμα από '.Carbon::parse($dateFrom)->format('d/m/Y').' μέχρι '.Carbon::parse($dateTo)->format('d/m/Y') ;
                    }
                 }
                 if ($data['kind']==2){
                    foreach ($data as $key => $v) {
                      if ($key!='kind'){
                        if ($day==$v['day']){
                            if ($v['compare']==0){
                                $response=false;
                                $msg='O Διαιτητής έχει κώλυμα κάθε '.$days[$v['day']];
                            }elseif($v['compare']==1){
                                $time=explode(':', $v['time']);
                                if ($hour<=$time[0] && $minute<=$time[1]){
                                  $response=false;
                                  $msg='O Διαιτητής έχει κώλυμα κάθε '.$days[$v['day']].' πριν από τις '.$v['time']; 
                                }
                            }else{
                                $time=explode(':', $v['time']);
                                if ($hour>=$time[0] && $minute>=$time[1]){
                                  $response=false;
                                  $msg='O Διαιτητής έχει κώλυμα κάθε '.$days[$v['day']].' μετά από τις '.$v['time']; 
                                }
                            }
                        }
                        
                      }
                    }
                 }
            }
            

        return view('backend.orismos.partials.check', compact('response', 'msg'));

    }
 public function checkRefBlocks($id,$match)
    {
        $ref= $id;
        $match_id= $match;
        $response= true;
        $isMatch=matches::findOrFail($match_id);
        $kwlymata=refTimeKol::selectRaw('*')
                          ->where('ref','=',$ref)
                          ->get();
        $days= [1=>'Δευτέρα', 2=>'Τρίτη', 3=>'Tετάρτη', 4=>'Πέμπτη', 5=>'Παρασκευή', 6=>'Σάββατο', 7=>'Κυριακή'];
        $match_date_time=Carbon::parse($isMatch->date_time);
        $day=$match_date_time->dayOfWeekIso;
        $hour=$match_date_time->hour;
        $minute=$match_date_time->minute;
        $response=true;
        $msg='';
            foreach ($kwlymata as $m){
                $data=json_decode($m->data, true);
                if ($data['kind']==1){
                    $dateFrom=Carbon::parse($data['dateFrom']);
                    $dateTo=Carbon::parse($data['dateTo']);
                    if ($match_date_time->gte($dateFrom) && $match_date_time->lte($dateTo)){
                         $response=false;
                        $msg='O Διαιτητής έχει κώλυμα από '.Carbon::parse($dateFrom)->format('d/m/Y').' μέχρι '.Carbon::parse($dateTo)->format('d/m/Y') ;
                    }
                 }
                 if ($data['kind']==2){
                    foreach ($data as $key => $v) {
                      if ($key!='kind'){
                        if ($day==$v['day']){
                            if ($v['compare']==0){
                                $response=false;
                                $msg='O Διαιτητής έχει κώλυμα κάθε '.$days[$v['day']];
                            }elseif($v['compare']==1){
                                $time=explode(':', $v['time']);
                                if ($hour<=$time[0] && $minute<=$time[1]){
                                  $response=false;
                                  $msg='O Διαιτητής έχει κώλυμα κάθε '.$days[$v['day']].' πριν από τις '.$v['time']; 
                                }
                            }else{
                                $time=explode(':', $v['time']);
                                if ($hour>=$time[0] && $minute>=$time[1]){
                                  $response=false;
                                  $msg='O Διαιτητής έχει κώλυμα κάθε '.$days[$v['day']].' μετά από τις '.$v['time']; 
                                }
                            }
                        }
                        
                      }
                    }
                 }
            }
            

        $html= view('backend.orismos.partials.check', compact('response', 'msg'))->render();

        return $html;

    }
        /**
     * Check if referee have an issue with one of the teams 
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\referees  $referees
     * @return \Illuminate\Http\Response
     */
    public function checkTeamBlock()
    {
        $ref= Input::get('id');
        $match_id= Input::get('match_id');
        $response= true;
        $isMatch=matches::findOrFail($match_id);
        $matches=teamBlock::selectRaw('*, teams.onoma_web as team')
                         ->join('teams', 'ref_team_kol.team','=', 'teams.team_id')
                         ->where(function($query) use ($isMatch){
                                    $query->where('team','=', $isMatch->team1)
                                          ->orWhere('team','=',$isMatch->team2);
                                    })
                          ->where('ref','=',$ref)
                          ->get();
    
        if (count($matches)){
            foreach ($matches as $m){
                $response=false;
                $msg = ($m->ref_to_team == 1 ? 'O Διαιτητής έχει κώλυμα με την ομάδα '.$m->team : 'Η Ομάδα '.$m->team.' έχει κώλυμα με τον διατητή'.' αιτία: ').$m->reason ;
            }
            
        }
        else{
            $response=true;
            $msg='';
            
        }
        /*History Log record*/
        //event(new refereesUpdate($referees));

        return view('backend.orismos.partials.check', compact('response', 'msg'));

    }


        public function checkTeamBlocks($id, $match)
    {
        $ref= $id;
        $match_id= $match;
        $response= true;
        $isMatch=matches::findOrFail($match_id);
        $matches=teamBlock::selectRaw('*, teams.onoma_web as team')
                         ->join('teams', 'ref_team_kol.team','=', 'teams.team_id')
                         ->where(function($query) use ($isMatch){
                                    $query->where('team','=', $isMatch->team1)
                                          ->orWhere('team','=',$isMatch->team2);
                                    })
                          ->where('ref','=',$ref)
                          ->get();
    
        if (count($matches)){
            foreach ($matches as $m){
                $response=false;
                $msg = ($m->ref_to_team == 1 ? 'O Διαιτητής έχει κώλυμα με την ομάδα '.$m->team : 'Η Ομάδα '.$m->team.' έχει κώλυμα με τον διατητή').' αιτία: '.$m->reason;
            }
            
        }
        else{
            $response=true;
            $msg='';
            
        }
        /*History Log record*/
        //event(new refereesUpdate($referees));

        $html= view('backend.orismos.partials.check', compact('response', 'msg'))->render();
        return $html;
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
                          ->where(function($query) use ($ref){
                                    $query->where('referee','=', $ref)
                                          ->orWhere('helper1','=', $ref)
                                          ->orWhere('helper2','=', $ref);
                                    })
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

        public function checkOtherMatches($id, $match)
    {
        $ref= $id;
        $match_id= $match;
        $response= true;
        $isMatch=matches::findOrFail($match_id);
        $matches=matches::selectRaw('matches.*, team1.onoma_web as t1, team2.onoma_web as t2')
                        ->join('teams as team1', 'team1.team_id','=', 'matches.team1')
                        ->join('teams as team2', 'team2.team_id','=', 'matches.team2')
                          ->where(function($query) use ($ref){
                                    $query->where('referee','=', $ref)
                                          ->orWhere('helper1','=', $ref)
                                          ->orWhere('helper2','=', $ref);
                                    })
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

        $html= view('backend.orismos.partials.check', compact('response', 'msg'))->render();
        return $html;
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
        if ($col=="helper1")
            $isMatch->helper1=$ref;
        elseif($col=="helper2")
            $isMatch->helper2=$ref;
        else
            $isMatch->referee=$ref;
        $isMatch->notified = 0;
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
        if ($status==1)
            $isMatch->published=1;
        else
            $isMatch->published=0;
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
        $response=$status.'-'.$match_id;
        return $response;

    }
       /**
     * Save notified status 
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\referees  $referees
     * @return \Illuminate\Http\Response
     */
    public function saveNof()
    {
        
        $match_id= Input::get('match_id');
        $status= Input::get('status');
        $response= 1;
        $isMatch=matches::findOrFail($match_id);
        $referees = [];
        if ($status==1){
            $isMatch->notified = 0;
            
        } else {
            $isMatch->notified = 1;
            $this->notifyReferee($isMatch);
            
        }
        $save = $isMatch->save();
        
        if (!$save) {
            $response = 0;            
        } else {
            $response = 1;            
        }
        /*History Log record*/
        //event(new refereesUpdate($referees));
        $response=$status.'-'.$match_id;

        return $response;

    }

    public function notifyReferee(matches $isMatch) {
        $referees[] = referees::find($isMatch->referee);
        $referees[] = referees::find($isMatch->helper1);
        $referees[] = referees::find($isMatch->helper2);
        $eps = eps::first();
        $team1 = team::find($isMatch->team1);
        $team2 = team::find($isMatch->team2);
        foreach ($referees as $referee) {
            $user = User::whereMobile($referee->tel)->first();
            $details = [
                'email' => (! empty($referee->email)) ? $referee->email : (($user) ? $user->email : ''),
                'data' => [
                    'message' => 'Οριστήκατε Διαιτητής στην Αναμέτρηση '.
                    $team1->onoma_web.' - '.
                    $team2->onoma_web.' ('.
                    Carbon::parse($isMatch->datetime)->format('d/m/Y H:i').
                    ')',
                    'name' =>   $referee->Lastname.' '.$referee->Firstname,
                    'eps' => $eps->name,
                    'url' => $eps->administration_url
                ],
                'subject' => $eps->short_name.': Ορισμός σε Αναμέτρηση',
            ];

            $refereeNotification = RefereeNotification::updateOrCreate([
                'match_id' => $isMatch->aa_game,
                'referee_id' => $referee->refaa
            ],[
                'notified' => 1,
                'accepted' => 0,
                'refused' => 0,
            ]); 

            $email = new NotifyReferees( $details[ 'data' ] , $details[ 'subject' ]);
            Mail::to($details['email'])->send($email);
        }
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

    public function accept(matches $match) {
        $user = request()->user();
        $referee = referees::whereTel($user->mobile)->first();
        $refereeNotification = RefereeNotification::whereMatchId($match->aa_game)->whereRefereeId($referee->refaa)->first();
        if ($refereeNotification){
            $refereeNotification->accepted = 1;
            $refereeNotification->save();

            return redirect()->back()->withFlashSuccess('Αποδεχθήκατε επιτυχώς τον Ορισμό σας στην Αναμέτρηση');
        }   

        return redirect()->back()->withFlashDanger('Κάποιο λάθος έγινε. Επικοινωνήστε με το διαχειριστή');
        
    }


    public function ρεφθσε(matches $match) {
        $user = request()->user();
        $referee = referees::whereTel($user->mobile)->first();
        $refereeNotification = RefereeNotification::whereMatchId($match->aa_game)->whereRefereeId($referee->refaa)->first();
        if ($refereeNotification){
            $refereeNotification->refused = 1;
            $refereeNotification->save();

            return redirect()->back()->withFlashSuccess('Απορρίψατε επιτυχώς τον Ορισμό σας στην Αναμέτρηση');
        }   

        return redirect()->back()->withFlashDanger('Κάποιο λάθος έγινε. Επικοινωνήστε με το διαχειριστή');
    }


}
