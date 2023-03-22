<?php

namespace App\Http\Controllers\Backend\Prints;

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

class MatchSheetsController extends Controller
{
    public function index(){

    	return view('backend.prints.matchsheets.index');
    }
    public function show_per_date(){

    	return view('backend.prints.matchsheets.date');
    }

    public function my_match_sheet(){
        if (config('settings.referee'))
    	       return view('backend.prints.matchsheets.my_match_sheets');
        else
            return redirect()->back()->withFlashDanger('Δεν έχετε δικαιώμα να εκτυπώσετε Φύλλα Αγώνα');
    }
    public function my_last_match_sheet(){
        if (config('settings.referee'))
    	       return view('backend.prints.matchsheets.my_last_match_sheets');
        else
            return redirect()->back()->withFlashDanger('Δεν έχετε δικαιώμα να εκτυπώσετε Φύλλα Αγώνα');
    }

    public function print_ypodomes_matchSheet($id) {
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
                    $team1=players::selectRaw('Surname, Name, YEAR(Birthdate) as BirthYear, player_id')
                            ->where('teams_team_id','=',$match->t1)
                            ->where('active','=',1)->get();
                    $team2=players::selectRaw('Surname, Name, YEAR(Birthdate) as BirthYear, player_id')
                            ->where('teams_team_id','=',$match->t2)
                            ->where('active','=',1)->get();
                }
        return view('backend.prints.matchsheets.pdf.fyllo', compact('matches','team1','team2'));
    }

    public function print_men_matchSheet($id){
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
            
        return view('backend.prints.matchsheets.pdf.fyllo-men', compact('matches'));
    }

      //Πρόγραμμα με φύλλα αγώνα ανά κατηγορία και αγωνιστική 
    public function per_md(){
        session()->put('category',request('category'));
        session()->put('md_from',request('md_from'));
        session()->put('md_to',request('md_to'));
        $category= request('category');
        $md_from= request('md_from');
        $md_to= request('md_to');
        $matches= matches::selectRaw('matches.aa_game as id, matches.*, team1.onoma_web as ghp, team2.onoma_web as fil, fields.eps_name as arena, group1.title as category, group1.category as cat')
                ->join('teams as team1', 'team1.team_id','=', 'matches.team1')
                ->join('teams as team2', 'team2.team_id','=', 'matches.team2')
                ->join('group1', 'group1.aa_group' ,'=','matches.group1')
                ->join('season', 'season.season_id','=', 'group1.aa_period')
                ->join('fields', 'fields.aa_gipedou','=','matches.court')
                ->where('matches.group1','=', $category)
                ->whereBetween('matches.match_day',array($md_from, $md_to))
                ->orderby('matches.date_time', 'desc')->get();
        return Datatables::of($matches)
        ->addColumn('actions',function($matches){
                //return $herbs->getEditButtonAttribute($herbs->id);
                return view('backend.prints.matchsheets.partials.actions',['id'=>$matches->id, 'category'=>$matches->cat, 'page'=>'matches']);
        })
        ->addColumn('match', function($matches){
                return $matches->ghp.' - '.$matches->fil;
            })
        ->addColumn('date', function($matches){
                return Carbon::parse($matches->date_time)->format('d/m/Y H:i');
            })
        ->addColumn('check', function($matches){
                return '<input type="checkbox" name="selected_matches[]" value="'.$matches->id.'">';   
            }) 
        ->rawColumns(['actions', 'check'])
        ->make(true);
    }

    //Πρόγραμμα με φύλλα αγώνα ανά ημερομηνία
    public function per_date(Request $request){
        session()->put('date_from',request('date_from'));
        session()->put('date_to',request('date_to'));
        if (! empty($request->date_from) && ! empty($request->date_to)){
            $date_from = Carbon::createFromFormat('d/m/Y', request('date_from'));
            $date_to = Carbon::createFromFormat('d/m/Y', request('date_to'));
        }else{
            $date_from=Carbon::parse(Carbon::now())->format('Y-m-d');
            $date_to=Carbon::parse(Carbon::now())->format('Y-m-d');
        }
        
        $date_from= Carbon::parse($date_from)->format('Y-m-d');
        $date_to= Carbon::parse($date_to)->format('Y-m-d');
        $matches= matches::selectRaw('matches.aa_game as id, matches.*, team1.onoma_web as ghp, team2.onoma_web as fil, fields.eps_name as arena, group1.title as category, group1.category as cat')
                ->join('teams as team1', 'team1.team_id','=', 'matches.team1')
                ->join('teams as team2', 'team2.team_id','=', 'matches.team2')
                ->join('group1', 'group1.aa_group' ,'=','matches.group1')
                ->join('season', 'season.season_id','=', 'group1.aa_period')
                ->join('fields', 'fields.aa_gipedou','=','matches.court')
                ->whereBetween('matches.date_time',array($date_from, $date_to))
                ->orderby('matches.date_time', 'desc')->get();
        return Datatables::of($matches)
        ->addColumn('actions',function($matches){
                //return $herbs->getEditButtonAttribute($herbs->id);
                return view('backend.prints.matchsheets.partials.actions',['id'=>$matches->id, 'category'=>$matches->cat, 'page'=>'matches']);
        })
        ->addColumn('match', function($matches){
                return $matches->ghp.' - '.$matches->fil;
            })
        ->addColumn('check', function($matches){
                return '<input type="checkbox" name="selected_matches[]" value="'.$matches->id.'">';   
            }) 
        ->addColumn('date', function($matches){
                return Carbon::parse($matches->date_time)->format('d/m/Y H:i');
            })
        ->rawColumns(['actions', 'check'])
        ->make(true);
    }
    public function printSelected()
    {
        $view='';
        $matches = Input::get('selected_matches');
        foreach ($matches as $match){
            $cats= matches::selectRaw('group1.category as cat')
                  ->join('group1', 'group1.aa_group' ,'=','matches.group1')
                   ->where('matches.aa_game','=', $match)->get();
            foreach ($cats as $cat) {
                if ($cat->cat>50){
                    $view.=$this->print_ypodomes_matchSheet($match)->render();
                }else{
                    $view.=$this->print_men_matchSheet($match)->render();
                }
            }
        }
        $pdf = PDF::loadHTML($view);
        return $pdf->stream('document.pdf');
    }

    public function print($id){

           
        $pdf = PDF::loadHTML($this->print_ypodomes_matchSheet($id));
        return $pdf->stream('document.pdf');
    }

    public function printMen($id){

            
            
        $pdf = PDF::loadHTML($this->print_men_matchSheet($id));
        return $pdf->stream('document.pdf');
    }
     public function show_md(){
        $category = Input::get('category');
        $results = array();
        $matches= matches::selectRaw('distinct match_day as md')
                  ->where('group1','=', $category)
                  ->orderby('md')
                  ->get();
        foreach ($matches as $match)
        {
            $results[] = [ 'id' => $match->md, 'md' => $match->md ];
        }
        return Response::json($results);

    }

    /*Για κάθε Διαιτητή*/
    //Πρόγραμμα με φύλλα αγώνα για κάθε Διαιτητή
    public function matchsheet(){
            $user=request('referee');
            $time=request('time');
            $symbol= ($time=='before')?'<':'>=';
            $referees= Referees::selectRaw('refaa as id')
                                ->join('users', 'users.mobile','=','referees.tel')
                                ->where('users.id','=',$user)
                                ->get();
            foreach($referees as $referee)
            $id= $referee->id;
            $matches= matches::selectRaw('matches.aa_game as id, matches.*, team1.onoma_web as ghp, team2.onoma_web as fil, fields.eps_name as arena, group1.title as category, group1.category as cat')
                ->join('teams as team1', 'team1.team_id','=', 'matches.team1')
                ->join('teams as team2', 'team2.team_id','=', 'matches.team2')
                ->join('group1', 'group1.aa_group' ,'=','matches.group1')
                ->join('season', 'season.season_id','=', 'group1.aa_period')
                ->join('fields', 'fields.aa_gipedou','=','matches.court')
                ->where('season.season_id','=',session('season'))
                ->where('matches.published','=', '0')
                ->where(function($query) use ($id){
                    $query->where('matches.referee','=', $id)
                          ->orWhere('matches.helper1','=', $id)
                          ->orWhere('matches.helper2','=', $id);
                })
                ->whereDate('matches.date_time',$symbol, Carbon::today()->toDateString())
                ->orderby('matches.date_time', 'desc')->get();
        return Datatables::of($matches)
        ->addColumn('actions',function($matches){
                //return $herbs->getEditButtonAttribute($herbs->id);
                return view('backend.prints.matchsheets.partials.actions',['id'=>$matches->id, 'category'=>$matches->cat, 'page'=>'matches']);
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
   

    /*Τέλος Για κάθε Διαιτητή*/
}
