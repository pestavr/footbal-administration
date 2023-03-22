<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request; 
use App\Http\Controllers\Controller;
use App\Models\Access\User\User; 
use Illuminate\Support\Facades\Auth; 
use Validator;
/**
 * Class ContactController.
 */
class ApiLoginController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */

    public $successStatus = 200;

    public function login(){ 
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')-> accessToken; 
            return response()->json(['success' => $success], $this-> successStatus); 
        } 
        else{ 
            return response()->json(['error'=>'Unauthorised'], 401); 
        } 
    }
	
	    public function test()
    {
	

        return response()->json(["username"=>"ok1","password"=>"ok-2"], 200);
    }

}
