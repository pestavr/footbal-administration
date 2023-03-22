<?php

namespace App\Http\Controllers\Backend;

use Redirect;
use App\Http\Controllers\Controller;
use App\Models\Backend\eps;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
/**
 * Class DashboardController.
 */
class DashboardController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
    	
        return view('backend.dashboard');
    }

    public function edit($id)
    {
    	
    	$eps=eps::selectRaw('*')->where('eps_id','=',$id)->get();

        return view('backend.edit', compact('eps'));
    }

    public function update(Request $request, $id)
    {
        $this->validate(request(), [
                'name'=> 'required',
                'short_name'=> 'required',
                'acronym'=> 'required',
                'logo' => 'file|image|mimes:jpeg,png,gif|max:2048',
                'email'=>'email|nullable'
            ]);

       
          
        $eps= eps::findOrFail($id);    
        if ($request->hasFile('logo')){
            $photoName = config('settings.storage_folder').'/logos/'.time().'.'.$request->logo->getClientOriginalExtension(); 
                $t = Storage::disk('s3')->put($photoName, file_get_contents($request->file('logo')), 'public');  
             $eps->logo=substr(Storage::disk('s3')->url($t), 0, -2).'/'.$photoName;
         }       
        $eps->name= $request->name;
        $eps->short_name=$request->short_name;
        $eps->acronym= $request->acronym;
        $eps->etos_idrisis= $request->etos_idrisis;
        $eps->email= $request->email;
        $eps->address= $request->address;
        $eps->tk= $request->tk;
        $eps->district= $request->district;
        $eps->city= $request->city;
        $eps->county= $request->county;
        $eps->region= $request->region;
        $eps->tel= $request->tel;
        $eps->tel2= $request->tel2;
        $eps->fax= $request->fax;
        $eps->facebook= $request->facebook;
        $eps->twitter= $request->twitter;
        $eps->etos_idrisis= $request->etos_idrisis;
        $eps->save();

        /*History Log record*/
        //event(new teamUpdate($team));

        return Redirect::route('admin.dashboard')
                ->with('success','Η ενημέρωση έγινε επιτυχώς.');

    }
}
