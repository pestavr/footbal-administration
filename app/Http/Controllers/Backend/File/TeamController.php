<?php

namespace App\Http\Controllers\Backend\File;

use Redirect;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Controllers\Controller;
use App\Models\Backend\team;
use App\Models\Backend\age_level;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return view('backend.file.team.index');
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function deactivated(){
        return view('backend.file.team.deactivated');
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
     * @param  \App\team  $team
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $team= team::selectRaw('teams.team_id as id, teams.*, age_level.Title, age_level.Age_Level_Title')
                ->join('age_level','age_level.id','=','teams.age_level')
                ->where('active','=','1')
                ->orderby('onoma_eps', 'asc')->get();
        return Datatables::of($team)
        ->addColumn('category', function($team){
                return $team->Title.((strlen($team->Age_Level_Title)>0)?' - ':'').$team->Age_Level_Title;
            })
        ->addColumn('actions',function($team){
                //return $herbs->getEditButtonAttribute($herbs->id);
                return view('backend.includes.partials.actions',['id'=>$team->id, 'condition'=>'activate', 'page'=>'team']);
        })
        ->rawColumns(['actions'])
        ->make(true);
    } 
    /**
     * Returns Teams Per Age Level for autocomplete.
     *
     * @param  \App\cat  $cat
     * @return \Illuminate\Http\Response
     */
    public function getTeamsAutocomplete(){
        $cat = Input::get('cat');
        $term= Input::get('term');
        $all=false;
        if (Input::has('all'))
            $all=true;
        $results = array();
        if (!$all)
        $teams = team::selectRaw('team_id as id, onoma_web as name')
            ->join('age_level','age_level.id','=','teams.age_level')
            ->join('champs','age_level.id','=','champs.age_level')
            ->where('teams.onoma_web','LIKE', '%'.$term.'%')
            ->where('champs.champ_id', '=', $cat)
            ->where('teams.active','=', '1')
            ->groupBy('teams.team_id')
            ->get();
        else
            $teams = team::selectRaw('team_id as id, onoma_web as name, age_level.title as age_level')
            ->join('age_level','age_level.id','=','teams.age_level')
            ->join('champs','age_level.id','=','champs.age_level')
            ->where('teams.onoma_web','LIKE', '%'.$term.'%')
            ->where('teams.active','=', '1')
            ->groupBy('teams.team_id')
            ->get();  
        
        foreach ($teams as $team)
        {
            $results[] = [ 'id' => $team->id, 'value' => (($all)?$team->name.'-'.$team->age_level:$team->name) ];
        }
    return Response::json($results);
    }
    /**
     * Returns Teams Per Age Level.
     *
     * @param  \App\cat  $cat
     * @return \Illuminate\Http\Response
     */
    public function getTeamsPerAgeLevel(){
        $cat = Input::get('cat');
        $term= Input::get('search');
        $results = array();
        
        $teams = team::selectRaw('team_id as id, onoma_web as name')
            ->join('age_level','age_level.id','=','teams.age_level')
            ->join('champs','age_level.id','=','champs.age_level')
            ->where('teams.onoma_web','LIKE', '%'.$term.'%')
            ->where('champs.champ_id', '=', $cat)
            ->where('teams.active','=', '1')
            ->get();
        
        foreach ($teams as $team)
        {
            $results[] = [ 'id' => $team->id, 'text' => $team->name ];
        }
    return Response::json($results);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\team  $team
     * @return \Illuminate\Http\Response
     */

    public function show_deactivated()
    {
         $team= team::selectRaw('teams.team_id as id, teams.*, age_level.Title, age_level.Age_Level_Title')
                ->join('age_level','age_level.id','=','teams.age_level')
                ->where('active','=','0')
                ->orderby('onoma_eps', 'asc')->get();
        return Datatables::of($team)
        ->addColumn('category', function($team){
                return $team->Title.((strlen($team->Age_Level_Title)>0)?' - ':'').$team->Age_Level_Title;
            })
        ->addColumn('actions',function($team){
                //return $herbs->getEditButtonAttribute($herbs->id);
                return view('backend.includes.partials.actions',['id'=>$team->id, 'condition'=>'deactivate', 'page'=>'team']);
        })
        ->rawColumns(['actions'])
        ->make(true);
    } 
    
    public function activate($id)
    {
         $team= team::findOrFail($id);               
         $team->active= 1;
         $team->save();

         return Redirect::route('admin.file.team.index');
    }

    public function deactivate($id)
    {
        $team= team::findOrFail($id);               
         $team->active= 0;
         $team->save();

         return Redirect::route('admin.file.team.index');
    }

    public function program($id){
        return view('backend.file.team.program', compact('id'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\team  $team
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $teams=team::selectRaw('teams.team_id as id, teams.* ')->where('team_id','=',$id)->get();

        return view('backend.file.team.edit', compact('teams'));
    }

    public function show_modal($id)
    {
        $teams=team::selectRaw('teams.team_id as id, teams.*, age_level.Title, age_level.Age_Level_Title , fields1.sort_name as edra, fields2.sort_name as edra2')
              ->join('age_level','age_level.id','=','teams.age_level')
              ->join('fields as fields1', 'fields1.aa_gipedou','=','teams.court')
              ->join('fields as fields2', 'fields2.aa_gipedou','=','teams.court2')
              ->where('team_id','=',$id)->get();
        $category=team::selectRaw('GROUP_CONCAT(group1.title SEPARATOR ", ") as categories')
                  ->join('teamspergroup','teamspergroup.team','=','teams.team_id')
                  ->join('group1', 'group1.aa_group' ,'=','teamspergroup.group')
                  ->join('season', 'season.season_id','=', 'group1.aa_period')
                  ->where('team_id','=',$id)
                  ->where('season.season_id','=',session('season'))
                  ->groupBy('team_id')
                  ->get();

        return view('backend.file.team.modal-content', compact('teams', 'category'));
    }

     public function insert()
    {
        
        return view('backend.file.team.insert');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\team  $team
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate(request(), [
                'onoma_web'=> 'required',
                'emblem' => 'file|image|mimes:jpeg,png,gif|max:2048',
                'etos_idrisis'=>'numeric|nullable',
                'aa_epo'=>'numeric|nullable',
                'code_gga'=>'numeric|nullable',
                'afm'=>'numeric|nullable'
            ]);

       
          
        $team= team::findOrFail($id);    
        if ($request->hasFile('emblem')){
             $photoName = config('settings.storage_folder').'/logos/'.time().'.'.$request->emblem->getClientOriginalExtension(); 
                $t = Storage::disk('s3')->put($photoName, file_get_contents($request->file('emblem')), 'public');
             $team->emblem=substr(Storage::url($t), 0, -2).'/'.$photoName;
         }       
        $team->onoma_web= $request->onoma_web;
        $team->onoma_eps= $this->grstrtoupper($request->onoma_web);
        $team->onoma_SMS= $this->convert_SMS_chars($this->grstrtoupper($request->onoma_web));
        $team->region= $request->region;
        $team->site= $request->site;
        $team->parent= $request->parent;
        $team->address= $request->address;
        $team->afm= $request->afm;
        $team->tel= $request->tel;
        $team->city= $request->city;
        $team->court= $request->court;
        $team->tk= $request->tk;
        $team->court2= $request->court2;
        $team->code_gga= $request->code_gga;
        $team->fax= $request->fax;
        $team->etos_idrisis= $request->etos_idrisis;
        $team->email= $request->email;
        $team->smstel= $request->smstel;
        $team->age_level= $request->age_level;
        $team->save();

        /*History Log record*/
        //event(new teamUpdate($team));

        return Redirect::route('admin.file.team.index')
                ->with('success','Η ενημέρωση έγινε επιτυχώς.');

    }

        /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\team  $team
     * @return \Illuminate\Http\Response
     */
    public function do_insert(Request $request)
    {
        $this->validate(request(), [
                'onoma_web'=> 'required',
                'emblem' => 'file|image|mimes:jpeg,png,gif|max:2048',
                'etos_idrisis'=>'numeric|nullable',
                'aa_epo'=>'numeric|nullable',
                'code_gga'=>'numeric|nullable',
                'afm'=>'numeric|nullable'
            ]);

       
          
        $team= new team;    
        if ($request->hasFile('emblem')){
             $photoName = config('settings.storage_folder').'/logos/'.time().'.'.$request->emblem->getClientOriginalExtension(); 
                $t = Storage::disk('s3')->put($photoName, file_get_contents($request->file('emblem')), 'public');
             $team->emblem=substr(Storage::url($t), 0, -2).'/'.$photoName;
         }           
        $team->onoma_web= $request->onoma_web;
        $team->onoma_eps= $this->grstrtoupper($request->onoma_web);
        $team->onoma_SMS= $this->convert_SMS_chars($this->grstrtoupper($request->onoma_web));
        $team->region= $request->region;
        $team->site= $request->site;
        $team->parent= $request->parent;
        $team->address= $request->address;
        $team->afm= $request->afm;
        $team->tel= $request->tel;
        $team->city= $request->city;
        $team->court= $request->court;
        $team->tk= $request->tk;
        $team->court2= $request->court2;
        $team->code_gga= $request->code_gga;
        $team->fax= $request->fax;
        $team->etos_idrisis= $request->etos_idrisis;
        $team->email= $request->email;
        $team->smstel= $request->smstel;
        $team->age_level= $request->age_level;
        $team->save();
        /*History Log record*/
        //event(new teamUpdate($team));

        return Redirect::route('admin.file.team.index');

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\team  $team
     * @return \Illuminate\Http\Response
     */
    public function destroy(team $team)
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
