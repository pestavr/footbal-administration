<?php

namespace App\Http\Controllers\Backend\Kollimata;

use Redirect;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Controllers\Controller;
use App\Models\Backend\refTimeKol;
use App\Models\Backend\referees;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;

class TimeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return view('backend.kollimata.time.index');
    }

    /**
     * Display Κωλήματα Ανά Διαιτητή
     *
     * @return \Illuminate\Http\Response
     */
    public function myKollimata(){
        return view('backend.kollimata.time.perRef');
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
         $times= reftimeKol::selectRaw('times.time_id as id, times.onoma_web as name')
                ->join('times','times.time_id','=','ref_time_kol.time')
                ->where('ref','=', $id)
                ->orderby('times.onoma_web', 'asc')
                ->get();
        foreach ($times as $time)
        {
            $results[] = [ 'id' => $time->id, 'text' => $time->name ];
        }
        $timesJson= Response::json($results);
        return view('backend.kollimata.time.edit', compact('referees', 'timesJson'));
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
     * @param  \App\time  $time
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $days= [1=>'Δευτέρα', 2=>'Τρίτη', 3=>'Tετάρτη', 4=>'Πέμπτη', 5=>'Παρασκευή', 6=>'Σάββατο', 7=>'Κυριακή'];
        $time= reftimeKol::selectRaw('time_kol_id as id, ref_time_kol.*, referees.Lastname as refLast, referees.Firstname as refFirst')
                ->join('referees','referees.refaa','=','ref_time_kol.ref')
                ->orderby('referees.Lastname', 'asc')
                ->get();
        return Datatables::of($time)
        ->addColumn('referee', function($time){
                return $time->refLast.' '.$time->refFirst;
            })
        ->addColumn('actions',function($time){
                //return $herbs->getEditButtonAttribute($herbs->id);
                return view('backend.kollimata.partials.timeActions',['id'=>$time->id]);
        })
        ->addColumn('data',function($time) use ($days){
                $data=json_decode($time->data, true);
                $text='';
                if ($data['kind']==1){
                     $text='Από: '.Carbon::parse($data['dateFrom'])->format('d/m/Y').' Μέχρι: '.Carbon::parse($data['dateTo'])->format('d/m/Y');
                 }
                 if ($data['kind']==2){
                    foreach ($data as $key => $v) {
                      if ($key!='kind'){
                        $text.='Kάθε '.$days[$v['day']].' ';
                        if ($v['compare']==0){
                            $text.='όλη μέρα <br/>';
                        }elseif($v['compare']==1){
                            $text.=' πρίν από τις '.$v['time'].'<br/>';
                        }else{
                            $text.=' μετά από τις '.$v['time'].'<br/>';
                        }
                      }
                    }
                 }
            
                
                return $text;
        })
        ->rawColumns(['actions', 'data'])
        ->make(true);
    } 

/**
     * Display Per referee Blocks
     *
     * @param  \App\time  $time
     * @return \Illuminate\Http\Response
     */
    public function getPerRef(Request $request)
    {
        $referee=$request->referee;
        $days= [1=>'Δευτέρα', 2=>'Τρίτη', 3=>'Tετάρτη', 4=>'Πέμπτη', 5=>'Παρασκευή', 6=>'Σάββατο', 7=>'Κυριακή'];
        $time= reftimeKol::selectRaw('time_kol_id as id, ref_time_kol.*, referees.Lastname as refLast, referees.Firstname as refFirst')
                ->join('referees','referees.refaa','=','ref_time_kol.ref')
                ->where('referees.refaa', '=', $referee)
                ->orderby('referees.Lastname', 'asc')
                ->get();
        return Datatables::of($time)
        ->addColumn('referee', function($time){
                return $time->refLast.' '.$time->refFirst;
            })
        ->addColumn('actions',function($time){
                //return $herbs->getEditButtonAttribute($herbs->id);
                return view('backend.kollimata.partials.timeActions',['id'=>$time->id]);
        })
        ->addColumn('data',function($time) use ($days){
                $data=json_decode($time->data, true);
                $text='';
                if ($data['kind']==1){
                     $text='Από: '.Carbon::parse($data['dateFrom'])->format('d/m/Y').' Μέχρι: '.Carbon::parse($data['dateTo'])->format('d/m/Y');
                 }
                 if ($data['kind']==2){
                    foreach ($data as $key => $v) {
                      if ($key!='kind'){
                        $text.='Kάθε '.$days[$v['day']].' ';
                        if ($v['compare']==0){
                            $text.='όλη μέρα <br/>';
                        }elseif($v['compare']==1){
                            $text.=' πρίν από τις '.$v['time'].'<br/>';
                        }else{
                            $text.=' μετά από τις '.$v['time'].'<br/>';
                        }
                      }
                    }
                 }
            
                
                return $text;
        })
        ->rawColumns(['actions', 'data'])
        ->make(true);
    } 


     public function insert()
    {
        
        return view('backend.kollimata.time.insert');
    }


        /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\time  $time
     * @return \Illuminate\Http\Response
     */
    public function do_insert(Request $request)
    {
        if ($request->kind==1){
            $this->validate(request(), [
                'ref_id'=> 'required',
                'dateFrom'=> 'date_format:"d/m/Y"',
                'dateTo'=> 'date_format:"d/m/Y"',
            ]);
            $ref=Input::get('ref_id');
             $format = 'd/m/Y';
            $dateFrom = Carbon::createFromFormat($format, $request->dateFrom);
            $dateTo = Carbon::createFromFormat($format, $request->dateTo);
            $data= array();
            $data['kind']=1;
            $data['dateFrom']=Carbon::parse($dateFrom)->format('Y/m/d');
            $data['dateTo']=Carbon::parse($dateTo)->format('Y/m/d');
            $json= json_encode($data);
        }else{
             $this->validate(request(), [
                'ref_id'=> 'required'
            ]);
            $ref=Input::get('ref_id');
            $days=Input::get('days');
            $data= array();
            if (sizeof($days)>0){
                $data['kind']=2;
                foreach($days as $k=>$v){
                    $data[$k]['day']=$k;
                    $data[$k]['compare']=Input::get('compare-'.$k);
                    if ($data[$k]['compare']==1 || $data[$k]['compare']==2){
                        $data[$k]['time']=Input::get('time-'.$k);
                    }
                }
                $json= json_encode($data);
            }
        }
        
            $reftimeKol= new reftimeKol;
            $reftimeKol->data=$json;
            $reftimeKol->ref=$ref;
            $reftimeKol->save();
       

        return Redirect::route('admin.kollimata.time.index');

    }
    /**
     * Display inputs that cup matches filled in.
     *
     * @return \Illuminate\Http\Response
     */
    public function timeForms(){
            $kind=Input::get('kind');
            return view('backend.kollimata.partials.timeForms', compact('kind'));    
        
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\time  $time
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ref_time_kol= reftimeKol::where('time_kol_id','=',$id)->delete();


        return redirect()->back()->withFlashSuccess('Επιτυχής Διαγραφή');     
    }

}
