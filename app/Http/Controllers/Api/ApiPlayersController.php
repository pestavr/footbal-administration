<?php
namespace App\Http\Controllers\Api;

use Yajra\Datatables\Facades\Datatables;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller;
use App\Models\Access\User\User; 
use Illuminate\Support\Facades\Auth; 
use Validator;
use App\Models\Backend\referees;
use App\Models\Backend\players;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
/**
 * Class ContactController.
 */
class ApiPlayersController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */


    public function saveNewPlayer(Request $request){ 
        $format = 'Y';


        $date = Carbon::createFromFormat($format, Input::get('Bdate'));
        $maxPlayerID=new players;
        $players= new players; 
        $player_id=intval($maxPlayerID->getMaxPlayerID(Input::get('team')))+1;
        $players->player_id= $player_id;              
        $players->Surname= Input::get('Lastname');
        $players->Name= Input::get('Firstname');
        $players->F_name=Input::get('F_name');
        $players->Birthdate= Carbon::parse($date)->format('Y/m/d');
        $players->teams_team_id= Input::get('team');
        $players->active= 1;
        try{
            $players->save();
            $res='ok';
        }catch (\Exception $e) {
            $res=$e;
        } 
        
    }

    
   



}
