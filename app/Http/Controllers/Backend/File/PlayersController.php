<?php

namespace App\Http\Controllers\Backend\File;

use Redirect;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use App\Models\Backend\players;
use App\Models\Backend\team;
use App\Models\Backend\transfer;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PlayersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return view('backend.file.players.index');
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function deactivated(){
        return view('backend.file.players.deactivated');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function uploadPlayersFromFile(){
        return view('backend.file.players.uploadPlayersFromFile');
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

    /* Autocomplete player getter */
    public function getPLayer(){
        $term = Input::get('term');
    
        $results = array();
        
        $players = players::selectRaw('player_id, CONCAT(Surname, " ", Name) as player, F_name, YEAR(Birthdate) as BirthYear, teams_team_id as team, teams.onoma_web as team_name')
            ->join('teams','teams.team_id','=','players.teams_team_id')
            ->where('player_id', 'LIKE', $term.'%')
            ->where('players.active','=', '1')
            ->take(10)->
            get();
        
        foreach ($players as $player)
        {
            $results[] = [ 'id' => $player->player_id, 'value' => $player->player_id, 'player' => $player->player, 'fname' => $player->F_name, 'BirthYear' => $player->BirthYear, 'team' => $player->team, 'team_name' => $player->team_name ];
        }
    return Response::json($results);
    }

        /* Search player getter */
    public function searchPLayer(Request $request,$id){
        $player_id = $request->player_id;
        $Surname = $request->Surname;
        $birthYear = $request->birthYear;
        $team=$id;
        
        
        $players = players::selectRaw('player_id, Surname, Name, F_name, YEAR(Birthdate) as birthYear, teams_team_id as team, teams.onoma_web as team_name')
            ->join('teams','teams.team_id','=','players.teams_team_id')
            ->where('player_id', 'LIKE', '%'.$player_id.'%')
            ->where('Surname','LIKE', '%'.$Surname.'%')
            ->whereRaw('YEAR(Birthdate) LIKE "%'.$birthYear.'%"');
         return Datatables::of($players)
        ->addColumn('actions',function($players) use($team){
                //return $herbs->getEditButtonAttribute($herbs->id);
                return view('backend.includes.partials.players-transfer-actions',['id'=>$players->player_id,'team'=>$team]);
        })
        ->rawColumns(['actions'])
        ->make(true);
       
    return Response::json($results);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\players  $players
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $players= players::selectRaw('players.*, teams.onoma_web')
                ->join('teams','teams.team_id','=','players.teams_team_id')
                ->where('players.active','=','1')
                ->orderby('players.Surname', 'asc');
        return Datatables::of($players)
        ->addColumn('actions',function($players){
                //return $herbs->getEditButtonAttribute($herbs->id);
                return view('backend.includes.partials.actions',['id'=>$players->player_id, 'condition'=>'activate', 'page'=>'players']);
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

    public function show_deactivated()
    {
         $players= players::selectRaw('players.*, teams.onoma_web ')
                ->join('teams','teams.team_id','=','players.teams_team_id')
                ->where('players.active','=','0')
                ->orderby('players.Surname', 'asc');
        return Datatables::of($players)
        ->addColumn('actions',function($players){
                //return $herbs->getEditButtonAttribute($herbs->id);
                return view('backend.includes.partials.actions',['id'=>$players->player_id, 'condition'=>'deactivate', 'page'=>'players']);
        })
        ->rawColumns(['actions'])
        ->make(true);
    } 
    
    public function activate($id)
    {
         $players= players::findOrFail($id);               
         $players->active= 1;
         $players->save();

         return Redirect::route('admin.file.players.index');
    }

    public function deactivate($id)
    {
        $players= players::findOrFail($id);               
         $players->active= 0;
         $players->save();

         return Redirect::route('admin.file.players.index');
    }

    public function program($id){
        return view('backend.file.players.program', compact('id'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\players  $players
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $players=players::selectRaw('players.player_id as id, players.* ')->where('player_id','=',$id)->get();

        return view('backend.file.players.edit', compact('players'));
    }

    public function show_modal($id)
    {
        $players=players::selectRaw('players.player_id as id, players.*, teams.onoma_web as team')
                 ->join('teams','teams.team_id','=','players.teams_team_id')
                 ->where('player_id','=',$id)->get();

        return view('backend.file.players.modal-content', compact('players'));
    }

     public function insert()
    {
        
        return view('backend.file.players.insert');
    }

    public function per_team($id)
    {
        $team_id=$id;
        return view('backend.file.team.players', compact('team_id'));
    }

    public function show_per_team($id)
    {
        $players= players::selectRaw('players.*, teams.onoma_web, YEAR(Birthdate) as birthYear')
                ->join('teams','teams.team_id','=','players.teams_team_id')
                ->where('players.active','=','1')
                ->where('teams_team_id','=',$id)
                ->orderby('players.Surname', 'asc');
        return Datatables::of($players)
        ->addColumn('actions',function($players){
                //return $herbs->getEditButtonAttribute($herbs->id);
                return view('backend.includes.partials.actions',['id'=>$players->player_id, 'condition'=>'activate', 'page'=>'players']);
        })
        ->rawColumns(['actions'])
        ->make(true);
        
    } 

         public function insertTeamPlayer($id)
    {
        $team=$id;
        return view('backend.file.team.insert_player', compact('team'));
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
            ]);

        $format = 'd/m/Y';

        $date = Carbon::createFromFormat($format, request('Bdate'));
        $players= players::findOrFail($id);
        if ($players->teams_team_id!=request('team')){
            $transfer= new transfer;
            $transfer->player_id=request('player_id'); 
            $transfer->team_id_from=$players->teams_team_id;
            $transfer->team_id_to=request('team');
            $transfer->date=Carbon::parse(Carbon::now())->format('Y/m/d');
            $transfer->save();
        }               
        $players->player_id= request('player_id');              
        $players->Surname= request('Lastname');
        $players->Name= request('Firstname');
        $players->F_name=request('Fname');
        $players->Birthdate= Carbon::parse($date)->format('Y/m/d');
        $players->country= request('country');
        $players->position= request('position');
        $players->teams_team_id= request('team');
        $players->active= 1;
        $players->save();
        /*History Log record*/
        //event(new refereesUpdate($referees));

        return Redirect::route('admin.file.players.index');

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
                'Lastname'=> 'required',
                'Firstname'=> 'required',
                'Bdate'=>'date_format:"d/m/Y"',
            ]);
        $format = 'd/m/Y';

        $date = Carbon::createFromFormat($format, request('Bdate'));
        $players= new players; 
        $players->player_id= request('player_id');              
        $players->Surname= request('Lastname');
        $players->Name= request('Firstname');
        $players->F_name=request('Fname');
        $players->Birthdate= Carbon::parse($date)->format('Y/m/d');
        $players->country= request('country');
        $players->position= request('position');
        $players->teams_team_id= request('team');
        $players->active= 1;
        $players->save();
        /*History Log record*/
        //event(new playersUpdate($players));

        return redirect()->back()->withFlashSuccess('Επιτυχής Εισαγωγή Ποδοσφαιριστή');

    }

    public function do_st_insert()
    {
        $this->validate(request(), [
                'player_id'=>'required',
                'Lastname'=> 'required',
                'Firstname'=> 'required',
            ]);
        
        $players= new players; 
        $players->player_id= request('player_id');              
        $players->Surname= request('Lastname');
        $players->Name= request('Firstname');
        $players->F_name=request('Fname');
        $players->teams_team_id= request('team');
        $players->active= 1;
        try{
            $players->save();
            $res='ok';
        }catch (\Exception $e) {
            $res='Ο ποδοσφαιριστής Υπάρχει ήδη στην βάση Δεδομένων';
        } 
        /*History Log record*/
        //event(new playersUpdate($players));

        return $res;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\referees  $referees
     * @return \Illuminate\Http\Response
     */
    public function doUploadPlayersFromFile(Request $request)
    {
         $this->validate($request, [
                'csv_file'=>'required',
            ]);
        if ($request->hasFile('csv_file')){
            $path = $request->file('csv_file')->getRealPath();
            $data = array_map('str_getcsv', file($path));
            $csv_data = array_slice($data, 0);
            $newPlayers=0;
            $transfers=0;
            $noChange=0;
            foreach ($csv_data as $row) {       
                foreach ($row as $key => $value) {
                    $row_vals= explode(';', $value);
                    $teamTo=team::select('team_id')->where('aa_epo','=',$row_vals[4])->first();
                    //echo $teamTo;
                    if (players::where('player_id', '=',$row_vals[0])->exists()){
                            if (players::where('player_id', '=',$row_vals[0])->where('teams_team_id','=',$teamTo['team_id'])->exists()){
                                $players=players::findOrFail($row_vals[0]);
                                $players->active= 1;          
                                $players->Surname= $row_vals[2];
                                $players->Name= $row_vals[1];
                                $players->Birthdate=Carbon::parse(Carbon::createFromFormat('d/m/Y', $row_vals[3]))->format('Y/m/d');
                                $players->teams_team_id= $teamTo['team_id'];
                                try{
                                    $players->save();
                                    $noChange++;
                                }catch (\Exception $e) {
                                    $res=$e;
                                } 
                                
                            }else{
                                $players=players::findOrFail($row_vals[0]);
                                $transfer= new transfer;
                                $transfer->player_id=$row_vals[0]; 
                                $transfer->team_id_from=$players->teams_team_id;
                                $transfer->team_id_to=$teamTo['team_id'];
                                $transfer->date=Carbon::parse(Carbon::now())->format('Y/m/d');
                                $transfer->save();
                                $players->active= 1;          
                                $players->Surname= $row_vals[2];
                                $players->Name= $row_vals[1];
                                $players->Birthdate=Carbon::parse(Carbon::createFromFormat('d/m/Y', $row_vals[3]))->format('Y/m/d');
                                $players->teams_team_id= $teamTo['team_id'];
                                try{
                                    $players->save();
                                    $transfers++;
                                }catch (\Exception $e) {
                                    $res=$e;
                                } 
                                
                            }
                    }else{
                        $players= new players; 
                        $players->player_id= $row_vals[0];              
                        $players->Surname= $row_vals[2];
                        $players->Name= $row_vals[1];
                        $players->Birthdate=Carbon::parse(Carbon::createFromFormat('d/m/Y', $row_vals[3]))->format('Y/m/d');
                        $players->teams_team_id= $teamTo['team_id'];
                        $players->active= 1;
                        try{
                            $players->save();
                            $newPlayers++;
                        }catch (\Exception $e) {
                            $res=$e;
                        } 

                    }
                }
            }
            return redirect()->back()->withFlashSuccess('Επιτυχής Εισαγωγή '.$newPlayers.' νέων ποδοσφαιριστών '.$transfers.' μεταγραφών και '.$noChange.' χωρίς καμία αλλαγή');
        }else{
            return redirect()->back()->withFlashDanger('Δεν φορτώσατε αρχείο');
        }
    }


}
