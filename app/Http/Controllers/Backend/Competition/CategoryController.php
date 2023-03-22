<?php

namespace App\Http\Controllers\Backend\Competition;

use Redirect;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Controllers\Controller;
use App\Models\Backend\champs;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return view('backend.competition.category.index');
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function deactivated(){
        return view('backend.competition.category.deactivated');
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
     * @param  \App\category  $category
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $category= champs::selectRaw('champs.champ_id as id, champs.*, age_level.Title as age_level ')
        ->join('age_level', 'age_level.id', '=' , 'champs.age_level') 
                ->where('active','=','1')
                ->orderby('champ_id', 'asc')
                ->get();
        return Datatables::of($category)
        ->addColumn('actions',function($category){
                $flexible= ($category->flexible==0)?false:true;
                return view('backend.competition.partials.categoryActions',['id'=>$category->id, 'condition'=>'activate', 'flexible'=>$flexible]);
        })
        ->rawColumns(['actions'])
        ->make(true);
    } 
    /**
     * Display the specified resource.
     *
     * @param  \App\category  $category
     * @return \Illuminate\Http\Response
     */

    public function show_deactivated()
    {
        $category= champs::selectRaw('champs.champ_id as id, champs.*, age_level.Title as age_level ')
        ->join('age_level', 'age_level.id', '=' , 'champs.age_level') 
                ->where('active','=','0')
                ->orderby('champ_id', 'asc')
                ->get();
        return Datatables::of($category)
        ->addColumn('actions',function($category){
                $flexible= ($category->flexible==0)?false:true;
                return view('backend.competition.partials.categoryActions',['id'=>$category->id, 'condition'=>'deactivate', 'flexible'=>$flexible]);
        })
        ->rawColumns(['actions'])
        ->make(true);
    } 
        public function makeFlexible($id)
    {
         $category= champs::findOrFail($id);               
         $category->flexible= 1;
         $category->save();

         return Redirect::route('admin.competition.category.index');
    }
        public function makeNotFlexible($id)
    {
         $category= champs::findOrFail($id);               
         $category->flexible= 0;
         $category->save();

         return Redirect::route('admin.competition.category.index');
    }
    
    public function activate($id)
    {
         $category= champs::findOrFail($id);               
         $category->active= 1;
         $category->save();

         return Redirect::route('admin.competition.category.index');
    }

    public function deactivate($id)
    {
        $category= champs::findOrFail($id);               
         $category->active= 0;
         $category->save();

         return Redirect::route('admin.competition.category.deactivated');
    }

    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category=champs::selectRaw('champs.champ_id as id, champs.*')
                        ->where('champ_id','=',$id)
                        ->get();

        return view('backend.competition.category.edit', compact('category'));
    }

    public function show_modal($id)
    {
        $category=champs::selectRaw('champs.champ_id as id, champs.*, age_level.Title as age_level')
                        ->join('age_level', 'age_level.id', '=' , 'champs.age_level') 
                        ->where('champ_id','=',$id)
                        ->get();

        return view('backend.competition.category.modal-content', compact('category'));
    }

     public function insert()
    {
        
        return view('backend.competition.category.insert');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate(request(), [
                'category'=> 'required',
                'age_level'=> 'required',
                'logo' => 'file|image|mimes:jpeg,png,gif|max:2048',
                'ref'=> 'numeric',
                'hel'=> 'numeric',
                'ref_daily'=> 'numeric',
                'hel_daily'=> 'numeric',
                'eu_Km'=> 'numeric',
                'wa_ma'=> 'numeric',
                'waEuKm'=> 'numeric',
                'wa_ref'=> 'numeric',
                'warefEuKm'=> 'numeric',
                'doc'=> 'numeric',
                'docEuKm'=> 'numeric',
            ]);
        
        $category= champs::findOrFail($id); 
        if ($request->hasFile('logo')){
             $photoName = time().'.'.$request->logo->getClientOriginalExtension(); 
             $t = Storage::put('logos/'.$photoName, file_get_contents($request->file('logo')), 'public');    
             $category->logo=url('logos/'.$photoName);
         }  
        $category->category= request('category');             
        $category->age_level= request('age_level');
        $category->hel= request('hel');
        $category->ref= request('ref');
        $category->ref_daily= request('ref_daily');
        $category->hel_daily= request('hel_daily');
        $category->eu_Km= request('eu_Km');
        $category->wa_ma= request('wa_ma');
        $category->waEuKm= request('waEuKm');
        $category->wa_ref= request('wa_ref');
        $category->waRefEuKm= request('waRefEuKm');
        $category->doc= request('doc');
        $category->docEuKm= request('docEuKm');
        $category->save();
        /*History Log record*/
        //event(new categoryUpdate($category));

        return redirect()->back()->withFlashSuccess('Επιτυχής Αποθήκευση');

    }

        /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\category  $category
     * @return \Illuminate\Http\Response
     */
    public function do_insert()
    {
        $this->validate(request(), [
                'Lastname'=> 'required',
                'Firstname'=> 'required',
                'Bdate'=>'date_format:"d/m/Y"|nullable',
                'tel'=> 'required | size:10',
            ]);
        $format = 'd/m/Y';

        $date = Carbon::createFromFormat($format, request('Bdate'));
        $category= new champs;               
        $category->Lastname= $this->grstrtoupper(request('Lastname'));
        $category->Firstname= $this->grstrtoupper(request('Firstname'));
        $category->smsLastName= $this->convert_SMS_chars($this->grstrtoupper(request('Lastname')));
        $category->Geniki= $this->grstrtoupper(request('Lastname').' '.substr(request('Firstname'),0,6));
        $category->Fname= $this->grstrtoupper(request('Fname'));
        $category->Bdate= Carbon::parse($date)->format('Y/m/d');
        $category->address= request('address');
        $category->tk= request('tk');
        $category->city= request('city');
        $category->tel= request('tel');
        $category->email= request('email');
        $category->startpoint= request('startpoint');
        $category->save();
        /*History Log record*/
        //event(new categoryUpdate($category));

        return Redirect::route('admin.competition.category.index');

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(category $category)
    {
        //
    }

 
}
