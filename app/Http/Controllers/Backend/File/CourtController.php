<?php

namespace App\Http\Controllers\Backend\File;

use Redirect;
use Mapper;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Controllers\Controller;
use App\Models\Backend\court;
use App\Models\Backend\matches;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;

class CourtController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return view('backend.file.court.index');
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function deactivated(){
        return view('backend.file.court.deactivated');
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
     * @param  \App\court  $court
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $court= court::selectRaw('fields.aa_gipedou, fields.sort_name , GROUP_CONCAT(teams.onoma_web SEPARATOR ", ") as teams')
                ->leftJoin('teams', 'teams.court','=', 'fields.aa_gipedou')
                ->where('fields.active','=','1')
                ->orderby('fields.eps_name', 'asc')
                ->groupBy('fields.aa_gipedou')
                ->get();
        return Datatables::of($court)
        ->addColumn('actions',function($court){
                //return $herbs->getEditButtonAttribute($herbs->id);
                return view('backend.includes.partials.actions',['id'=>$court->aa_gipedou, 'condition'=>'activate', 'page'=>'court']);
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
         $court= court::selectRaw('fields.aa_gipedou, fields.sort_name , GROUP_CONCAT(teams.onoma_web SEPARATOR ", ") as teams')
                ->leftJoin('teams', 'teams.court','=', 'fields.aa_gipedou')
                ->where('fields.active','=','0')
                ->orderby('fields.eps_name', 'asc')
                ->groupBy('fields.aa_gipedou')
                ->get();
        return Datatables::of($court)
        ->addColumn('actions',function($court){
                //return $herbs->getEditButtonAttribute($herbs->id);
                return view('backend.includes.partials.actions',['id'=>$court->aa_gipedou, 'condition'=>'deactivate', 'page'=>'court']);
        })
        ->rawColumns(['actions'])
        ->make(true);
    } 
    
    public function activate($id)
    {
         $court= court::findOrFail($id);               
         $court->active= 1;
         $court->save();

         return Redirect::route('admin.file.court.index');
    }

    public function deactivate($id)
    {
        $court= court::findOrFail($id);               
         $court->active= 0;
         $court->save();

         return Redirect::route('admin.file.court.index');
    }

    public function program($id){
        return view('backend.file.court.program', compact('id'));
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
                ->where('matches.court','=', $id)
                ->orderby('matches.date_time', 'desc')->get();
        return Datatables::of($matches)
        ->addColumn('actions',function($matches){
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\court  $court
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $courts=court::selectRaw('fields.aa_gipedou as id, fields.* ')->where('aa_gipedou','=',$id)->get();

        return view('backend.file.court.edit', compact('courts'));
    }

    public function show_modal($id)
    {
        $courts=court::selectRaw('fields.aa_gipedou as id, fields.* ')->where('aa_gipedou','=',$id)->get();

        return view('backend.file.court.modal-content', compact('courts'));
    }

    public function show_map($id)
    {
        $courts=court::selectRaw('fields.aa_gipedou as id, fields.* ')->where('aa_gipedou','=',$id)->get();
        foreach ($courts as $court) {
            if(strlen($court->latitude)>0){
            Mapper::map($court->latitude, $court->longitude,[
                'zoom'=>$court->zoom,
                'draggable'=>true,
                'eventDragEnd' => '$("#latitude").val(event.latLng.lat()); $("#longitude").val(event.latLng.lng()); $("#zoom").val(map.getZoom())'
                ]);
            
        }else{
            Mapper::map(39.637207644197666, 22.41657257080078,[
                'draggable'=>true,
                'eventDragEnd' => '$("#latitude").val(event.latLng.lat()); $("#longitude").val(event.latLng.lng()); $("#zoom").val(map.getZoom())'
                ]);
        }
        }
        
        
        return view('backend.file.court.map', compact('courts'));

        
    } 


    public function map_update($id)
    {
        $this->validate(request(), [
                'latitude'=> 'required|numeric',
                'longitude'=> 'required|numeric',
                'zoom'=> 'required|numeric',
            ]);
        
        $court= court::findOrFail($id);               
        $court->latitude= request('latitude');
        $court->longitude= request('longitude');
        $court->zoom= request('zoom');    
        $court->save();
        /*History Log record*/
        //event(new refereesUpdate($referees));

        return Redirect::route('admin.file.court.index');

    }
    
    public function show_cities($id)
    {
        $courts=court::selectRaw('fields.aa_gipedou as id, fields.* ')->where('aa_gipedou','=',$id)->get();

        return view('backend.file.court.cities', compact('courts'));
    }
    
    public function cities_update(Request $request, $id)
    {
        
        
        $court= court::findOrFail($id);     
        if ($request->has('Kms')){          
            $court->Kms= request('Kms');
            $court->diodia= request('diodia');
        }   
        if ($request->has('Kms2')){
            $court->Kms2= request('Kms2');
            $court->diodia2= request('diodia2');
        }   
        if ($request->has('Kms')){
            $court->Kms3= request('Kms3');
            $court->diodia3= request('diodia3');
        }   
        $court->save();
        /*History Log record*/
        //event(new refereesUpdate($referees));

        return Redirect::route('admin.file.court.index');

    }

     public function insert()
    {
        
        return view('backend.file.court.insert');
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
                'eps_name'=> 'required',
            ]);
        
        $court= court::findOrFail($id);               
        $court->eps_name= $this->grstrtoupper(request('eps_name'));   
        $court->sort_name= request('eps_name');
        $court->smsName= $this->convert_SMS_chars($this->grstrtoupper(request('eps_name'))); 
        if (!config('settings.cities') && !config('settings.google'))                    
            $court->Kms= request('Kms');
        $court->fild= request('fild');
        $court->apoditiria= request('apoditiria');
        $court->Sheets=request('Sheets');
        $court->address= request('address');
        $court->tk= request('tk');
        $court->region= request('region');
        $court->town= request('town');
        $court->tel= request('tel');
        $court->fax= request('fax');
        $court->email= request('email');
        $court->administrator= request('administrator');
        $court->tel_admin= request('tel_admin');    
        $court->save();
        /*History Log record*/
        //event(new refereesUpdate($referees));
        return redirect()->back()->withFlashSuccess('Επιτυχής Ενημέρωση του Γηπέδου');

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
                'eps_name'=> 'required',
            ]);
       
        $court= new court; 
        $court->eps_name= $this->grstrtoupper(request('eps_name'));      
        $court->sort_name= request('eps_name'); 
        $court->smsName= $this->convert_SMS_chars($this->grstrtoupper(request('eps_name')));            
        $court->fild= request('fild');
        $court->apoditiria= request('apoditiria');
        $court->Sheets=request('Sheets');
        $court->address= request('address');
        $court->tk= request('tk');
        $court->region= request('region');
        $court->town= request('town');
        $court->tel= request('tel');
        $court->fax= request('fax');
        $court->email= request('email');
        $court->administrator= request('administrator');
        $court->tel_admin= request('tel_admin');    
        $court->save();
        /*History Log record*/
        //event(new courtUpdate($court));

        return Redirect::route('admin.file.court.index');

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

       /* Autocomplete player getter */
    public function getCourt(){
        $term = Input::get('term');
    
        $results = array();
        
        $courts = court::selectRaw('aa_gipedou as court_id, eps_name as court')
            ->where('eps_name', 'LIKE', '%'.$term.'%')
            ->where('active','=', '1')
            ->take(10)->
            get();
        
        foreach ($courts as $court)
        {
            $results[] = [ 'id' => $court->court_id, 'value' => $court->court ];
        }
    return Response::json($results);
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
