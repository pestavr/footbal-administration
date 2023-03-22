<?php

namespace App\Http\Controllers\Backend\File;

use Redirect;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use App\Models\Backend\teamsAccountable;
use App\Models\Backend\transfer;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TeamsAccountableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return view('backend.file.teamsAccountable.index');
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function deactivated(){
        return view('backend.file.teamsAccountable.deactivated');
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
     * @param  \App\teamsAccountable  $teamsAccountable
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $teamsAccountable= teamsAccountable::selectRaw('teamsAccountable.*, teams.onoma_web')
                ->join('teams','teams.team_id','=','teamsAccountable.team_id')
                ->where('teamsAccountable.active','=','1')
                ->orderby('teamsAccountable.Surname', 'asc');
        return Datatables::of($teamsAccountable)
        ->addColumn('actions',function($teamsAccountable){
                //return $herbs->getEditButtonAttribute($herbs->id);
                return view('backend.includes.partials.actions',['id'=>$teamsAccountable->id, 'condition'=>'activate', 'page'=>'teamsAccountable']);
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
        $teamsAccountable= teamsAccountable::selectRaw('teamsAccountable.*, teams.onoma_web')
                ->join('teams','teams.team_id','=','teamsAccountable.team_id')
                ->where('teamsAccountable.active','=','0')
                ->orderby('teamsAccountable.Surname', 'asc');
        return Datatables::of($teamsAccountable)
        ->addColumn('actions',function($teamsAccountable){
                //return $herbs->getEditButtonAttribute($herbs->id);
                return view('backend.includes.partials.actions',['id'=>$teamsAccountable->id, 'condition'=>'deactivate', 'page'=>'teamsAccountable']);
        })
        ->rawColumns(['actions'])
        ->make(true);
    } 
    
    public function activate($id)
    {
         $teamsAccountable= teamsAccountable::findOrFail($id);               
         $teamsAccountable->active= 1;
         $teamsAccountable->save();

         return Redirect::route('admin.file.teamsAccountable.index');
    }

    public function deactivate($id)
    {
        $teamsAccountable= teamsAccountable::findOrFail($id);               
         $teamsAccountable->active= 0;
         $teamsAccountable->save();

         return Redirect::route('admin.file.teamsAccountable.index');
    }

    public function program($id){
        return view('backend.file.teamsAccountable.program', compact('id'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\teamsAccountable  $teamsAccountable
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $teamsAccountable=teamsAccountable::selectRaw('teamsAccountable.id as id, teamsAccountable.* ')->where('id','=',$id)->get();

        return view('backend.file.teamsAccountable.edit', compact('teamsAccountable'));
    }

    public function show_modal($id)
    {
        $teamsAccountable=teamsAccountable::selectRaw('teamsAccountable.*, teams.onoma_web as team')
                 ->join('teams','teams.team_id','=','teamsAccountable.team_id')
                 ->where('id','=',$id)->get();

        return view('backend.file.teamsAccountable.modal-content', compact('teamsAccountable'));
    }

     public function insert()
    {
        
        return view('backend.file.teamsAccountable.insert');
    }

    public function per_team($id)
    {
        $team_id=$id;
        return view('backend.file.team.teamsAccountable', compact('team_id'));
    }

    public function show_per_team($id)
    {
        $teamsAccountable= teamsAccountable::selectRaw('teamsAccountable.*, teams.onoma_web')
                ->join('teams','teams.team_id','=','teamsAccountable.team_id')
                ->where('teamsAccountable.active','=','1')
                ->where('teamsAccountable.team_id','=',$id)
                ->orderby('teamsAccountable.Surname', 'asc');
        return Datatables::of($teamsAccountable)
        ->addColumn('actions',function($teamsAccountable){
                //return $herbs->getEditButtonAttribute($herbs->id);
                return view('backend.includes.partials.actions',['id'=>$teamsAccountable->id, 'condition'=>'activate', 'page'=>'teamsAccountable']);
        })
        ->rawColumns(['actions'])
        ->make(true);
        
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
                'Surname'=> 'required',
                'Name'=> 'required',
                'email'=>'required',
                'team'=>'required',
                'Mobile'=>'required',
            ]);

        $teamsAccountable= teamsAccountable::findOrFail($id);            
        $teamsAccountable->Surname= request('Surname');
        $teamsAccountable->Name= request('Name');
        $teamsAccountable->FName=request('FName');
        $teamsAccountable->Address= request('Address');
        $teamsAccountable->Tk= request('Tk');
        $teamsAccountable->Region= request('Region');
        $teamsAccountable->City= request('City');
        $teamsAccountable->Tel= request('Tel');
        $teamsAccountable->Mobile= request('Mobile');
        $teamsAccountable->email= request('email');
        $teamsAccountable->team_id= request('team');
        $teamsAccountable->active= 1;
        $teamsAccountable->save();
        /*History Log record*/
        //event(new refereesUpdate($referees));

        return Redirect::route('admin.file.teamsAccountable.index')->withFlashSuccess('Επιτυχής Ενημέρωση του Υπέυθυνου Σωματείου');;

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
                'Surname'=> 'required',
                'Name'=> 'required',
                'email'=>'required',
                'team'=>'required',
                'Mobile'=>'required',
            ]);

        $teamsAccountable= new teamsAccountable;               
        $teamsAccountable->Surname= request('Surname');
        $teamsAccountable->Name= request('Name');
        $teamsAccountable->FName=request('FName');
        $teamsAccountable->Address= request('Address');
        $teamsAccountable->Tk= request('Tk');
        $teamsAccountable->Region= request('Region');
        $teamsAccountable->City= request('City');
        $teamsAccountable->Tel= request('Tel');
        $teamsAccountable->Mobile= request('Mobile');
        $teamsAccountable->email= request('email');
        $teamsAccountable->team_id= request('team');
        $teamsAccountable->active= 1;
        $teamsAccountable->save();
        /*History Log record*/
        //event(new teamsAccountableUpdate($teamsAccountable));

        return Redirect::route('admin.file.teamsAccountable.index')->withFlashSuccess('Επιτυχής Δημιουργία του Υπέυθυνου Σωματείου');

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\referees  $referees
     * @return \Illuminate\Http\Response
     */
    public function destroy(referees $referees)
    {
        //
    }


}
