<?php

namespace App\Http\Controllers\Backend\Kollimata;

use Redirect;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Controllers\Controller;
use App\Models\Backend\refTeamKol;
use App\Models\Backend\referees;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return view('backend.kollimata.team.index');
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $referees= referees::selectRaw('referees.Lastname as refLast, referees.Firstname as refFirst')
                ->where('refaa','=',$id)
                ->get();
         $teams= refTeamKol::selectRaw('teams.team_id as id, teams.onoma_web as name')
                ->join('teams','teams.team_id','=','ref_team_kol.team')
                ->where('ref','=', $id)
                ->orderby('teams.onoma_web', 'asc')
                ->get();
        foreach ($teams as $team)
        {
            $results[] = [ 'id' => $team->id, 'text' => $team->name ];
        }
        $teamsJson= Response::json($results);
        return view('backend.kollimata.team.edit', compact('referees', 'teamsJson'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.kollimata.team.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(), [
            'ref_id'=> 'required',
            'teams' => 'required'
        ]);
   $teams=Input::get('teams');
   $ref=Input::get('ref_id');
    foreach ($teams as $team){  
        $refTeamKol= new refTeamKol;
        $refTeamKol->team=$team;
        $refTeamKol->ref=$ref;
        $refTeamKol->reason = $request->reason;
        $refTeamKol->ref_to_team = $request->ref_to_team;
        $refTeamKol->save();

    }   
   

    return redirect()->route('admin.kollimata.team.index')->withFlashSuccess('ΕΠιτυχής απόθηκευση Κωλύματος');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\team  $team
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $team= refTeamKol::selectRaw('team_kol_id as id, ref_team_kol.*, teams.onoma_web as team, referees.Lastname as refLast, referees.Firstname as refFirst')
                ->join('referees','referees.refaa','=','ref_team_kol.ref')
                ->join('teams','teams.team_id','=','ref_team_kol.team')
                ->orderby('referees.Lastname', 'asc')
                ->get();
        return Datatables::of($team)
        ->addColumn('referee', function($team){
                return $team->refLast.' '.$team->refFirst;
            })
        ->editColumn('team', function($team){
            return $team->team;
        })
        ->editColumn('ref_to_team', function($team){
            return $team->ref_to_team == 0 ? 'ομάδα κώλυμα με διαιτητή' : 'διαιτητής κώλυμα με ομάδα';
        })
        ->editColumn('reason', function($team){
            return $team->reason;
        })
        ->addColumn('actions',function($team){
                return view('backend.kollimata.partials.teamActions',['id'=>$team->id]);
        })
        ->rawColumns(['actions'])
        ->make(true);
    } 




     public function insert()
    {
        
        return view('backend.kollimata.team.insert');
    }


        /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\team  $team
     * @return \Illuminate\Http\Response
     */
    public function do_insert(Request $request)
    {
        $this->validate(request(), [
                'ref_id'=> 'required',
                'teams' => 'required'
            ]);
       $teams=Input::get('teams');
       $ref=Input::get('ref_id');
        foreach ($teams as $team){  
            $refTeamKol= new refTeamKol;
            $refTeamKol->team=$team;
            $refTeamKol->ref=$ref;
            $refTeamKol->save();

        }   
       

        return Redirect::route('admin.kollimata.team.index');

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\team  $team
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ref_team_kol= refTeamKol::where('team_kol_id','=',$id)->delete();


        return redirect()->back()->withFlashSuccess('Επιτυχής Διαγραφή');     
    }

}
