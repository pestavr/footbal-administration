<?php

namespace App\Http\Controllers\Backend\File;

use Redirect;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Controllers\Controller;
use App\Models\Backend\observer;
use App\Models\Backend\matches;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;

class ObserverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return view('backend.file.observer.index');
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function deactivated(){
        return view('backend.file.observer.deactivated');
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
     * @param  \App\observer  $observer
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $observer= observer::selectRaw('paratirites.wa_id as id, paratirites.* ')
                ->where('active','=','1')
                ->orderby('waLastName', 'asc')
                ->get();
        return Datatables::of($observer)
        ->addColumn('actions',function($observer){
                //return $herbs->getEditButtonAttribute($herbs->id);
                return view('backend.includes.partials.actions',['id'=>$observer->id, 'condition'=>'activate', 'page'=>'observer']);
        })
        ->rawColumns(['actions'])
        ->make(true);
    } 
    /**
     * Display the specified resource.
     *
     * @param  \App\observer  $observer
     * @return \Illuminate\Http\Response
     */

    public function show_deactivated()
    {
        $observer= observer::selectRaw('paratirites.wa_id as id, paratirites.* ')
                ->where('active','=','0')
                ->orderby('waLastName', 'asc')
                ->get();
        return Datatables::of($observer)
        ->addColumn('actions',function($observer){
                //return $herbs->getEditButtonAttribute($herbs->id);
                return view('backend.includes.partials.actions',['id'=>$observer->id, 'condition'=>'deactivate', 'page'=>'observer']);
        })
        ->rawColumns(['actions'])
        ->make(true);
    } 
    
    public function activate($id)
    {
         $observer= observer::findOrFail($id);               
         $observer->active= 1;
         $observer->save();

         return Redirect::route('admin.file.observer.index');
    }

    public function deactivate($id)
    {
        $observer= observer::findOrFail($id);               
         $observer->active= 0;
         $observer->save();

         return Redirect::route('admin.file.observer.index');
    }

    public function program($id){
        return view('backend.file.observer.program', compact('id'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\observer  $observer
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $observers=observer::selectRaw('paratirites.wa_id as id, paratirites.* ')->where('wa_id','=',$id)->get();

        return view('backend.file.observer.edit', compact('observers'));
    }
     public function show_modal($id)
    {
        $observers=observer::selectRaw('paratirites.wa_id as id, paratirites.* ')->where('wa_id','=',$id)->get();

        return view('backend.file.observer.modal-content', compact('observers'));
    }
     public function insert()
    {
        
        return view('backend.file.observer.insert');
    }

    /* Autocomplete doctor getter */
    public function getObserver(){
        $term = Input::get('term');
    
        $results = array();
        
        $observers = observer::selectRaw('wa_id as id, waLastName as ln, waFirstName as fn')
            ->where('waLastName', 'LIKE', $term.'%')
            ->where('active','=', '1')
            ->take(10)->
            get();
        
        foreach ($observers as $observer)
        {
            $results[] = [ 'id' => $observer->id, 'value' => $observer->ln.' '.$observer->fn ];
        }
    return Response::json($results);
    }


    public function get_program($id)
    {

        $matches= matches::selectRaw('matches.aa_game as id, matches.*, team1.onoma_web as ghp, team2.onoma_web as fil, fields.eps_name as arena, group1.title as category, group1.category as cat')
                ->join('teams as team1', 'team1.team_id','=', 'matches.team1')
                ->join('teams as team2', 'team2.team_id','=', 'matches.team2')
                ->join('group1', 'group1.aa_group' ,'=','matches.group1')
                ->join('season', 'season.season_id','=', 'group1.aa_period')
                ->join('fields', 'fields.aa_gipedou','=','matches.court')
                ->where('season.season_id','=',session('season'))
                ->where('matches.paratiritis','=', $id)
                ->orderby('matches.date_time', 'desc')->get();
        return Datatables::of($matches)
        ->addColumn('actions',function($matches){
                //return $herbs->getEditButtonAttribute($herbs->id);
                return view('backend.includes.partials.actions',['id'=>$matches->id, 'category'=>$matches->cat, 'page'=>'matches']);
        })
        ->addColumn('match', function($matches){
                return $matches->ghp.' - '.$matches->fil;
            })
        ->addColumn('date', function($matches){
                return Carbon::parse($matches->date_time)->format('d/m/Y H:i');
            })
        ->rawColumns(['actions'])
        ->make(true);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\observer  $observer
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $this->validate(request(), [
                'waLastName'=> 'required',
                'waFirstName'=> 'required',
                'waTel'=> 'required | size:10',
            ]);

        $observer= observer::findOrFail($id);               
        $observer->waLastName= $this->grstrtoupper(request('waLastName'));
        $observer->waFirstName= $this->grstrtoupper(request('waFirstName'));
        $observer->Fname= $this->grstrtoupper(request('Fname'));
        $observer->Address= request('Address');
        $observer->tk= request('tk');
        $observer->city= request('city');
        $observer->waTel= request('waTel');
        $observer->waTel2= request('waTel2');
        $observer->email= request('email');
        $observer->save();
        /*History Log record*/
        //event(new observerUpdate($observer));

        return Redirect::route('admin.file.observer.index')
                ->withSuccess('Η ενημέρωση έγινε επιτυχώς.');


    }

        /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\observer  $observer
     * @return \Illuminate\Http\Response
     */
    public function do_insert()
    {
        $this->validate(request(), [
                'waLastName'=> 'required',
                'waFirstName'=> 'required',
                'Bdate'=>'date_format:"d/m/Y"',
                'waTel'=> 'required | size:10',
            ]);
  
        $observer= new observer;               
        $observer->waLastName= $this->grstrtoupper(request('waLastName'));
        $observer->waFirstName= $this->grstrtoupper(request('waFirstName'));
        $observer->Fname= $this->grstrtoupper(request('Fname'));
        $observer->Address= request('Address');
        $observer->tk= request('tk');
        $observer->city= request('city');
        $observer->waTel= request('waTel');
        $observer->waTel2= request('waTel2');
        $observer->email= request('email');
        $observer->save();
        /*History Log record*/
        //event(new observerUpdate($observer));

        return Redirect::route('admin.file.observer.index');

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\observer  $observer
     * @return \Illuminate\Http\Response
     */
    public function destroy(observer $observer)
    {
        //
    }

    public function convert_SMS_chars($string){
            $latin_check = '/[\x{0030}-\x{007f}]/u';
        if (preg_match($latin_check, $string))
        {
            $string = strtoupper($string);
        }
        if (substr($string, -4) == 'ΟΣ')
                  $string= substr_replace($string, 'Ε', -4);
                elseif ((substr($string, -4) == 'ΑΣ') || (substr($string, -4) == 'ΗΣ') || (substr($string, -4) == 'ΕΣ'))
                  $string= substr($string, 0, -2);
                $letters = array('Α', 'Β', 'Ε', 'Ζ', 'Η', 'Ι', 'Κ',  'Μ', 'Ν', 'Ο', 'Ρ', 'Τ', 'Υ', 'Χ');
        $letters_to_latin= array('A', 'B', 'E', 'Z', 'H', 'I', 'K', 'M', 'N', 'O', 'P', 'T', 'Y', 'X');
        $latin_string = str_replace($letters, $letters_to_latin, $string);
                
        return $latin_string;
}

public function grstrtoupper($string) {
        $latin_check = '/[\x{0030}-\x{007f}]/u';
        if (preg_match($latin_check, $string))
        {
            $string = strtoupper($string);
        }
        $letters = array('α', 'β', 'γ', 'δ', 'ε', 'ζ', 'η', 'θ', 'ι', 'κ', 'λ', 'μ', 'ν', 'ξ', 'ο', 'π', 'ρ', 'σ', 'τ', 'υ', 'φ', 'χ', 'ψ', 'ω');
        $letters_accent = array('ά', 'έ', 'ή', 'ί', 'ό', 'ύ', 'ώ');
        $letters_upper_accent= array('Ά', 'Έ', 'Ή', 'Ί', 'Ό', 'Ύ', 'Ώ');
        $letters_upper_solvents = array('ϊ', 'ϋ');
        $letters_other  = array('ς');
        $letters_to_uppercase= array('Α', 'Β', 'Γ', 'Δ', 'Ε', 'Ζ', 'Η', 'Θ', 'Ι', 'Κ', 'Λ', 'Μ', 'Ν', 'Ξ', 'Ο', 'Π', 'Ρ', 'Σ', 'Τ', 'Υ', 'Φ', 'Χ', 'Ψ', 'Ω');
        $letters_accent_to_uppercase= array('Α', 'Ε', 'Η', 'Ι', 'Ο', 'Υ', 'Ω');
        $letters_upper_accent_to_uppercase= array('Α', 'Ε', 'Η', 'Ι', 'Ο', 'Υ', 'Ω');
        $letters_upper_solvents_to_uppercase= array('Ι', 'Υ');
        $letters_other_to_uppercase= array('Σ');
        $lowercase = array_merge($letters, $letters_accent, $letters_upper_accent, $letters_upper_solvents, $letters_other);
        $uppercase = array_merge($letters_to_uppercase, $letters_accent_to_uppercase, $letters_upper_accent_to_uppercase, $letters_upper_solvents_to_uppercase, $letters_other_to_uppercase);
        $uppecase_string = str_replace($lowercase, $uppercase, $string);
        return $uppecase_string;
    }
}
