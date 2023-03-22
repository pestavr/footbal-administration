<?php

namespace App\Http\Controllers\Backend\Prints;

use PDF;
use DB;
use Redirect;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Controllers\Controller;
use App\Models\Backend\matches;
use App\Models\Backend\players;
use App\Models\Backend\doctor;
use Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;

class DoctorController extends Controller
{
    public function index(){

    	return view('backend.prints.doctor.index');
    }

     public function orismoi(){

        return view('backend.prints.doctor.orismoi');
    }
   /**
     * Display the specified resource.
     *
     * @param  \App\doctors  $doctors
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $doctors= doctor::selectRaw('doctors.doc_id as id, doctors.* ')
                ->where('active','=','1')
                ->orderby('docLastname', 'asc')->get();
        return Datatables::of($doctors)
        ->addColumn('name',function($doctors){
                return $doctors->docLastName.' '.$doctors->docFirstName;
        })
        ->addColumn('address',function($doctors){
                return $doctors->Address.' TK '.$doctors->tk;
        })
        ->rawColumns(['actions'])
        ->make(true);
    } 


     public function getOrismoi(){

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
        $matches= matches::selectRaw('matches.aa_game as id, matches.*, team1.onoma_web as ghp, team2.onoma_web as fil, fields.eps_name as arena, fields.aa_gipedou as arena_id, group1.title as category, group1.category as cat, group1.locked as groupLocked, matches.score_team_1 as score1, champs.flexible as flexible, matches.score_team_2 as score2, matches.publ as prog_publ, matches.published as ref_publ, matches.publ_doc as doc_publ, matches.publ_ref_obs as ref_obs_publ, "-" as dash, doctors.docLastName as lastname, doctors.docFirstName as firstname')
                ->join('teams as team1', 'team1.team_id','=', 'matches.team1')
                ->join('teams as team2', 'team2.team_id','=', 'matches.team2')
                ->join('group1', 'group1.aa_group' ,'=','matches.group1')
                ->join('champs', 'group1.category' ,'=','champs.champ_id')
                ->join('fields', 'fields.aa_gipedou','=','matches.court')
                ->join('doctors', 'matches.referee','=', 'doctors.doc_id')
                ->where('matches.date_time','<>',config('default.datetime'))
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
            return $date.'-'.$matches->arena;
            })
        ->addColumn('category', function($matches){
                return $matches->category.' '.$matches->match_day.'η Αγωνιστική';
            })
        ->addColumn('doctor', function($matches){
                return $matches->lastname.' '.$matches->firstname;
            });
        $response=$response->make(true);
        return $response;
    }
}
