<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
/**
 * Class ContactController.
 */
class ApiLoginController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function login()
    {
	
		$username =request('username');
		$password =request('password');
        return response()->json(["username"=>$username,"password"=>$password], 200);
    }
	
	    public function test()
    {
	

        return response()->json(["username"=>"ok1","password"=>"ok-2"], 200);
    }

}
