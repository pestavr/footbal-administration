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
use App\Models\Backend\transfer;
use Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;

class PlayersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return view('backend.prints.players.index');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function transfers(){
        return view('backend.prints.players.transfers');
    }
 //Omades ana Omilo 
    public function getPlayers(){


        $team= request('team');
        $active= request('active');
        $operator= request('operator');
        $year= request('year');
        
        session()->put('team', $team);

        $players= players::selectRaw('players.*, teams.onoma_web, YEAR(Birthdate) as birthYear')
                ->join('teams','teams.team_id','=','players.teams_team_id')
                ->orderby('players.Surname', 'asc');
        if ($team!=null)        
            $players->where('teams_team_id','=',$team);
        if ($active!=null)
            $players->where('players.active','=', $active);
        if ($operator!=null)
            $players->whereRaw('YEAR(Birthdate)'.$operator.' '.$year);
        return Datatables::of($players)
        ->make(true);
    }

    //Programma kathe Omadas 
    public function getTransfers(){

        $teamFrom= request('teamFrom');
        $teamTo= request('teamTo');
        

         $transfers= transfer::selectRaw('transfers.met_id as met_id, transfers.player_id as deltio, CONCAT(players.Surname," ",players.Name) as name, players.F_name as F_name, teams_from.onoma_web as teamFrom, teams_to.onoma_web as teamTo, transfers.date as date')
                ->join('players', 'players.player_id','=', 'transfers.player_id')
                ->join('teams as teams_from','teams_from.team_id','=','transfers.team_id_from')
                ->join('teams as teams_to','teams_to.team_id','=','transfers.team_id_to')
                ->whereRaw('transfers.date Between "'.season::getAll(session('season'))->enarxi.'" and "'.season::getAll(session('season'))->lixi.'"')
                ->orderby('transfers.date', 'desc');
         if ($teamFrom!=null)        
            $transfers->where('transfers.team_id_from','=',$teamFrom);
        if ($teamTo!=null)
            $transfers->where('transfers.team_id_to','=',$teamTo);        

        return $response= Datatables::of($transfers)
                    ->addColumn('date', function($transfers){
                        return Carbon::parse($transfers->date)->format('d/m/Y');                    
                    })
                    ->make(true);
    }






   

}
