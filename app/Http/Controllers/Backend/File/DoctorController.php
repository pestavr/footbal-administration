<?php

namespace App\Http\Controllers\Backend\File;

use Redirect;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Controllers\Controller;
use App\Models\Backend\doctor;
use App\Models\Backend\matches;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return view('backend.file.doctor.index');
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function deactivated(){
        return view('backend.file.doctor.deactivated');
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
     * @param  \App\doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $doctor= doctor::selectRaw('doctors.doc_id as id, doctors.* ')
                ->where('active','=','1')
                ->orderby('docLastName', 'asc')
                ->get();
        return Datatables::of($doctor)
        ->addColumn('actions',function($doctor){
                //return $herbs->getEditButtonAttribute($herbs->id);
                return view('backend.includes.partials.actions',['id'=>$doctor->id, 'condition'=>'activate', 'page'=>'doctor']);
        })
        ->rawColumns(['actions'])
        ->make(true);

    } 
    /**
     * Display the specified resource.
     *
     * @param  \App\doctor  $doctor
     * @return \Illuminate\Http\Response
     */

    public function show_deactivated()
    {
        $doctor= doctor::selectRaw('doctors.doc_id as id, doctors.* ')
                ->where('active','=','0')
                ->orderby('docLastName', 'asc')
                ->get();
        return Datatables::of($doctor)
        ->addColumn('actions',function($doctor){
                //return $herbs->getEditButtonAttribute($herbs->id);
                return view('backend.includes.partials.actions',['id'=>$doctor->id, 'condition'=>'deactivate', 'page'=>'doctor']);
        })
        ->rawColumns(['actions'])
        ->make(true);
    } 
    
    public function activate($id)
    {
         $doctor= doctor::findOrFail($id);               
         $doctor->active= 1;
         $doctor->save();

         return Redirect::route('admin.file.doctor.index');
    }

    public function deactivate($id)
    {
        $doctor= doctor::findOrFail($id);               
         $doctor->active= 0;
         $doctor->save();

         return Redirect::route('admin.file.doctor.index');
    }

    public function program($id){
        return view('backend.file.doctor.program', compact('id'));
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
                ->where('matches.doctor','=', $id)
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $doctors=doctor::selectRaw('doctors.doc_id as id, doctors.* ')->where('doc_id','=',$id)->get();

        return view('backend.file.doctor.edit', compact('doctors'));
    }
     public function show_modal($id)
    {
        $doctors=doctor::selectRaw('doctors.doc_id as id, doctors.* ')->where('doc_id','=',$id)->get();

        return view('backend.file.doctor.modal-content', compact('doctors'));
    }

     public function insert()
    {
        
        return view('backend.file.doctor.insert');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $this->validate(request(), [
                'docLastName'=> 'required',
                'docFirstName'=> 'required',
                'docTel'=> 'required | size:10',
            ]);

        $doctor= doctor::findOrFail($id);               
        $doctor->docLastName= $this->grstrtoupper(request('docLastName'));
        $doctor->docFirstName= $this->grstrtoupper(request('docFirstName'));
        $doctor->Fname= $this->grstrtoupper(request('Fname'));
        $doctor->Address= request('Address');
        $doctor->tk= request('tk');
        $doctor->city= request('city');
        $doctor->docTel= request('docTel');
        $doctor->docTel2= request('docTel2');
        $doctor->email= request('email');
        $doctor->save();
        /*History Log record*/
        //event(new doctorUpdate($doctor));

        return Redirect::route('admin.file.doctor.index');

    }

        /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function do_insert()
    {
        $this->validate(request(), [
                'docLastName'=> 'required',
                'docFirstName'=> 'required',
                'Bdate'=>'date_format:"d/m/Y"',
                'docTel'=> 'required | size:10',
            ]);
  
        $doctor= new doctor;               
        $doctor->docLastName= $this->grstrtoupper(request('docLastName'));
        $doctor->docFirstName= $this->grstrtoupper(request('docFirstName'));
        $doctor->Fname= $this->grstrtoupper(request('Fname'));
        $doctor->Address= request('Address');
        $doctor->tk= request('tk');
        $doctor->city= request('city');
        $doctor->docTel= request('docTel');
        $doctor->docTel2= request('docTel2');
        $doctor->email= request('email');
        $doctor->save();
        /*History Log record*/
        //event(new doctorUpdate($doctor));

        return Redirect::route('admin.file.doctor.index');

    }

    /* Autocomplete doctor getter */
    public function getDoctor(){
        $term = Input::get('term');
    
        $results = array();
        
        $doctors = doctor::selectRaw('doc_id as id, docLastName as ln, docFirstName as fn')
            ->where('docLastName', 'LIKE', $term.'%')
            ->where('active','=', '1')
            ->take(10)->
            get();
        
        foreach ($doctors as $doctor)
        {
            $results[] = [ 'id' => $doctor->id, 'value' => $doctor->ln.' '.$doctor->fn ];
        }
    return Response::json($results);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function destroy(doctor $doctor)
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
