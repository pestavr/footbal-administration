<?php

namespace App\Http\Controllers\Backend\Movement;

use Redirect;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Controllers\Controller;
use App\Models\Backend\players;
use App\Models\Backend\transfer;
use App\Models\Backend\season;
use App\Models\Backend\team;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TransferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return view('backend.movement.transfer.index');
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function deactivated(){
        return view('backend.movement.transfer.deactivated');
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

    /**
     * Display the specified resource.
     *
     * @param  \App\transfer  $transfer
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $transfer= transfer::selectRaw('transfers.met_id as met_id, transfers.player_id as deltio, CONCAT(players.Surname," ",players.Name) as name, teams_from.onoma_web as team_from, teams_to.onoma_web as team_to')
                ->join('players', 'players.player_id','=', 'transfers.player_id')
                ->join('teams as teams_from','teams_from.team_id','=','transfers.team_id_from')
                ->join('teams as teams_to','teams_to.team_id','=','transfers.team_id_to')
                ->whereRaw('transfers.date Between "'.season::getAll(session('season'))->enarxi.'" and "'.season::getAll(session('season'))->lixi.'"')
                ->orderby('transfers.date', 'desc')
                ->get();
        return Datatables::of($transfer)
        ->addColumn('actions',function($transfer){
                //return $herbs->getEditButtonAttribute($herbs->id);
                return view('backend.includes.partials.move-actions',['id'=>$transfer->met_id, 'condition'=>'activate', 'page'=>'transfer']);
        })
        ->rawColumns(['actions'])
        ->make(true);
        
    } 
    /**
     * Display the specified resource.
     *
     * @param  \App\referees  $referees
     * @return \Illuminate\Http\Response
     */


    
    

    public function program($id){
        return view('backend.movement.transfer.program', compact('id'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\transfer  $transfer
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $transfers=transfer::selectRaw('transfers.met_id as id, transfers.* ')->where('met_id','=',$id)->get();

        return view('backend.movement.transfer.edit', compact('transfers'));
    }

    public function show_modal($id)
    {
        $transfers=transfer::selectRaw('transfers.met_id as id, transfers.*, CONCAT(players.Surname," ",players.Name) as name, teams_from.onoma_web as team_from, teams_to.onoma_web as team_to')
                    ->join('players', 'players.player_id','=', 'transfers.player_id')
                    ->join('teams as teams_from','teams_from.team_id','=','transfers.team_id_from')
                    ->join('teams as teams_to','teams_to.team_id','=','transfers.team_id_to')
                    ->where('met_id','=',$id)->get();

        return view('backend.movement.transfer.modal-content', compact('transfers'));
    }

     public function insert()
    {
        
        return view('backend.movement.transfer.insert');
    }

    public function per_team($id)
    {
        $team_id=$id;
        return view('backend.movement.team.transfer', compact('team_id'));
    }

    public function show_per_team($id)
    {
        $transfer= transfer::selectRaw('transfer.*, teams.onoma_web')
                ->join('teams','teams.team_id','=','transfer.teams_team_id')
                ->where('transfer.active','=','1')
                ->where('teams_team_id','=',$id)
                ->orderby('transfer.Surname', 'asc');
        return Datatables::of($transfer)
        ->addColumn('actions',function($transfer){
                //return $herbs->getEditButtonAttribute($herbs->id);
                return view('backend.includes.partials.actions',['id'=>$transfer->player_id, 'condition'=>'activate', 'page'=>'transfer']);
        })
        ->rawColumns(['actions'])
        ->make(true);
        
    } 

    public function transferToTeam($id){
        $team=$id;
        return view('backend.file.team.transfer',compact('team'));
    }

    public function doTransferToTeam($id,$team)
    {

        $date=Carbon::now()->format('Y-m-d');

        $player= players::findOrFail($id);
        if ($player->teams_team_id==$team){
            return redirect()->back()->withFlashDanger('Ο ποδοσφαιριστής υπάρχει ήδη στην ομάδα');
        }
        $team_from=$player->teams_team_id;
        $player->teams_team_id=$team;
        $player->save();
        
        $transfer= new transfer; 
        $transfer->player_id= $id;              
        $transfer->team_id_from= $team_from;
        $transfer->team_id_to= $team;
        $transfer->date= Carbon::parse($date)->format('Y/m/d');
        $transfer->save();

        return redirect()->back()->withFlashSuccess('Επιτυχής Μεταγραφή Ποδοσφαιριστή');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\referees  $referees
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $this->validate(request(), [
                'Lastname'=> 'required',
                'Firstname'=> 'required',
                'Bdate'=>'date_format:"d/m/Y"',
                'country'=>'required',
                'Fname'=>'required',
            ]);
    
        $format = 'd/m/Y';

        $date = Carbon::createFromFormat($format, request('Bdate'));
        $transfer= transfer::findOrFail($id);
        if ($transfer->teams_team_id!=request('team')){
            $transfer= new transfer;
            $transfer->player_id=request('player_id'); 
            $transfer->team_id_from=$transfer->teams_team_id;
            $transfer->team_id_to=request('team_');
            $transfer->date=Carbon::parse(Carbon::now())->format('Y/m/d');
            $transfer->timestamp=Carbon::parse(Carbon::now())->format('Y/m/d H:s:i');
            $transfer->save();
        }               
        $transfer->player_id= request('player_id');              
        $transfer->Surname= request('Lastname');
        $transfer->Name= request('Firstname');
        $transfer->F_name=request('Fname');
        $transfer->Birthdate= Carbon::parse($date)->format('Y/m/d');
        $transfer->country= request('country');
        $transfer->position= request('position');
        $transfer->teams_team_id= request('team');
        $transfer->active= 1;
        $transfer->save();
        /*History Log record*/
        //event(new refereesUpdate($referees));

        return Redirect::route('admin.move.transfer.index');

    }

        /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\referees  $referees
     * @return \Illuminate\Http\Response
     */
    public function do_insert()
    {
        $this->validate(request(), [
                'player_id'=> 'required',
                'team_from'=>'required',
                'team_to'=>'required',
            ]);

         $team=team::selectRaw('age_level.age as age')
                ->join('age_level','teams.age_level','=','age_level.id')
                ->where('teams.team_id','=',request('team_to'))
                ->get();
        $age=intval(Carbon::now()->year)-intval(request('BirthYear'));
        foreach ($team as $t) {
            if ($age> $t->age){
                 return Redirect::route('admin.move.transfer.insert')
                        ->withErrors(array('Error'=>'Δεν μπορείτε να τον μεταγράψετε στην ομάδα Λόγω Ηλικίας'))
                        ->withInput();
            }
        }
        $format = 'd/m/Y';

        $date = Carbon::createFromFormat($format, request('Date'));
        $transfer= new transfer; 
        $transfer->player_id= request('player_id');              
        $transfer->team_id_from= request('team_from');
        $transfer->team_id_to= request('team_to');
        $transfer->date= Carbon::parse($date)->format('Y/m/d');
        $transfer->save();
        /*History Log record*/
        //event(new transferUpdate($transfer));
        $player= players::findOrFail(request('player_id'));
        $player->teams_team_id=request('team_to');
        $player->save();
        return Redirect::route('admin.move.transfer.index');

    }

       /**
     * Insert Transfer from Matchsheet Stats
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\referees  $referees
     * @return \Illuminate\Http\Response
     */
    public function do_st_insert()
    {
        $this->validate(request(), [
                'player_id'=> 'required',
                'team_from'=>'required',
                'team_to'=>'required',
            ]);

         
        $date=Carbon::now()->format('Y-m-d');

        $player= players::findOrFail(request('player_id'));
        if ($player->teams_team_id==request('team_to')){
            $res='Ο ποδοσφαιριστής υπάρχει ήδη στην ομάδα';
            return $res;
        }
        $player->teams_team_id=request('team_to');
        $player->save();
        
        $transfer= new transfer; 
        $transfer->player_id= request('player_id');              
        $transfer->team_id_from= request('team_from');
        $transfer->team_id_to= request('team_to');
        $transfer->date= Carbon::parse($date)->format('Y/m/d');
        $transfer->save();
        /*History Log record*/
        //event(new transferUpdate($transfer));
        
        $response='ok';
        return $response;

    }
    /**
     * Removement the specified resource from storage.
     *
     * @param  \App\referees  $referees
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $transfer= transfer::findOrFail($id)->delete();


       return Redirect::route('admin.move.transfer.index');
    }


}
