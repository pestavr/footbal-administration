<?php

namespace App\Http\Controllers\Backend\Orismos\Grades;

use Redirect;
use DB;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Controllers\Controller;
use App\Models\Backend\matches;
use App\Models\Backend\refBlock;
use App\Models\Backend\teamBlock;
use App\Models\Backend\team;
use Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;

class GradesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return view('backend.orismos.referee.grades.index');
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function per_date(){
        return view('backend.orismos.referee.grades.date');
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
        $matches= matches::selectRaw('matches.aa_game as id, matches.*, team1.onoma_web as ghp, team2.onoma_web as fil, fields.eps_name as arena, fields.aa_gipedou as arena_id, group1.title as catego, group1.category as cat, matches.score_team_1 as score1, matches.score_team_2 as score2, matches.publ as prog_publ, matches.published as ref_publ, matches.notified as ref_nof, 
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
            $readonly=(strlen($matches->score1)>0)?false:true;
            $grades=true;
            return view('backend.orismos.partials.referee',['lastname'=>$matches->ref_lastname, 'firstname'=>$matches->ref_firstname, 'id'=>$matches->ref_id, 'match'=>$matches->id, 'readonly'=> $readonly, 'ref_grades'=>$matches->ref_grades, 'grades'=> $grades]);
            })
        ->addColumn('helper1', function($matches){
            $readonly=(strlen($matches->score1)>0)?false:true;
            $grades=true;
            return view('backend.orismos.partials.helper1',['lastname'=>$matches->h1_lastname, 'firstname'=>$matches->h1_firstname, 'id'=>$matches->h1_id, 'match'=>$matches->id, 'readonly'=> $readonly, 'h1_grades'=>$matches->h1_grades,'grades'=> $grades]);
            })
        ->addColumn('helper2', function($matches){
            $readonly=(strlen($matches->score1)>0)?false:true;
            $grades=true;
            return view('backend.orismos.partials.helper2',['lastname'=>$matches->h2_lastname, 'firstname'=>$matches->h2_firstname, 'id'=>$matches->h2_id, 'match'=>$matches->id, 'readonly'=> $readonly, 'h2_grades'=>$matches->h2_grades,'grades'=> $grades]);
            })
        ->addColumn('ref_publ', function($matches){
            $readonly=(strlen($matches->score1)>0)?false:true;
            $grades=true;
            return view('backend.orismos.partials.ref_publ',['ref_publ'=>$matches->ref_publ, 'match'=>$matches->id, 'readonly'=> $readonly, 'grades'=> $grades ]);
            })
        ->addColumn('check', function($matches){
                return '<input type="checkbox" class="form-check-input match" name="selected_matches[]" value="'.$matches->id.'" checked="checked">';   
            }) 
        ->rawColumns(['category','actions', 'match',  'ref_publ', 'prog_publ','check', 'referee', 'helper1', 'helper2', 'date-court', 'ref_nof'])
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
        $matches= matches::selectRaw('matches.aa_game as id, matches.*, team1.onoma_web as ghp, team2.onoma_web as fil, fields.eps_name as arena, fields.aa_gipedou as arena_id, group1.title as catego, group1.category as cat, matches.score_team_1 as score1, matches.score_team_2 as score2, matches.publ as prog_publ, matches.published as ref_publ, matches.notified as ref_nof, 
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
            $readonly=(strlen($matches->score1)>0)?false:true;
            $grades=true;
            return view('backend.orismos.partials.referee',['lastname'=>$matches->ref_lastname, 'firstname'=>$matches->ref_firstname, 'id'=>$matches->ref_id, 'match'=>$matches->id, 'readonly'=> $readonly, 'ref_grades'=>$matches->ref_grades, 'grades'=> $grades]);
            })
        ->addColumn('helper1', function($matches){
            $readonly=(strlen($matches->score1)>0)?false:true;
            $grades=true;
            return view('backend.orismos.partials.helper1',['lastname'=>$matches->h1_lastname, 'firstname'=>$matches->h1_firstname, 'id'=>$matches->h1_id, 'match'=>$matches->id, 'readonly'=> $readonly, 'h1_grades'=>$matches->h1_grades,'grades'=> $grades]);
            })
        ->addColumn('helper2', function($matches){
            $readonly=(strlen($matches->score1)>0)?false:true;
            $grades=true;
            return view('backend.orismos.partials.helper2',['lastname'=>$matches->h2_lastname, 'firstname'=>$matches->h2_firstname, 'id'=>$matches->h2_id, 'match'=>$matches->id, 'readonly'=> $readonly, 'h2_grades'=>$matches->h2_grades,'grades'=> $grades]);
            })
        ->addColumn('ref_publ', function($matches){
            $readonly=(strlen($matches->score1)>0)?false:true;
            $grades=true;
            return view('backend.orismos.partials.ref_publ',['ref_publ'=>$matches->ref_publ, 'match'=>$matches->id, 'readonly'=> $readonly, 'grades'=> $grades ]);
            })
        ->addColumn('check', function($matches){
                return '<input type="checkbox" class="form-check-input match" name="selected_matches[]" value="'.$matches->id.'" checked="checked">';   
            }) 
        ->rawColumns(['category','actions', 'match',  'ref_publ', 'prog_publ','check', 'referee', 'helper1', 'helper2', 'date-court', 'ref_nof'])
        ->make(true);

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
            $ref_grades=request('referee-grade-'.$match);
            $h1_grades=request('helper1-grade-'.$match);
            $h2_grades=request('helper2-grade-'.$match);
            // if( Request::input('published-'.$match) ) {
            //         $publ=1;
            //     } else {
            //         $publ=0;
            //     }

             $cur_match= matches::findOrFail($match);
             $cur_match->ref_grades=$ref_grades;
             $cur_match->h1_grades=$h1_grades;
             $cur_match->h2_grades=$h2_grades;
             //$cur_match->publ=$publ;
             $cur_match->save();
        }

          return redirect()->back()->withFlashSuccess('Επιτυχής Αποθήκευση');
       }else{
            return redirect()->back()->withFlashDanger('Δεν έχετε επιλέξει κάποια αναμέτρηση');
       }
    }

    public function matchGrades($id) {
        $matches= matches::selectRaw('matches.*, matches.match_day, matches.date_time, matches.group1, matches.score_team_1 as score1, matches.score_team_2 as score2, group1.omilos, group1.title  AS omilos, teams1.onoma_web AS team1, teams2.onoma_web AS team2,  referees_ref.Lastname AS ref_last_name, referees_ref.Firstname AS ref_firstname, matches.referee as ref_id, matches.team1 as t1, matches.team2 as t2, referees_h1.Lastname AS h1_last_name, referees_h1.Firstname AS h1_firstname, matches.helper1 as h1_id, season.period as season_name,referees_h2.Lastname AS h2_last_name, referees_h2.Firstname AS h2_firstname, matches.helper2 as h2_id, fields.sort_name AS field')
                ->join('teams as teams1', 'teams1.team_id','=', 'matches.team1')
                ->join('teams as teams2', 'teams2.team_id','=', 'matches.team2')
                ->join('group1', 'group1.aa_group' ,'=','matches.group1')
                ->join('champs', 'champs.champ_id','=','group1.category')
                ->join('season', 'season.season_id','=', 'group1.aa_period')
                ->join('fields', 'fields.aa_gipedou','=','matches.court')
                ->join('referees as referees_ref', 'referees_ref.refaa', '=', 'matches.referee')
                ->join('referees as referees_h1', 'referees_h1.refaa', '=', 'matches.helper1')
                ->join('referees as referees_h2', 'referees_h2.refaa', '=', 'matches.helper2')
                ->where('matches.aa_game','=', $id)
                ->get();
        return view('backend.orismos.referee.grades.modal', compact('matches'));
    }
    

}
