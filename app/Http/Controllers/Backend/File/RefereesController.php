<?php

namespace App\Http\Controllers\Backend\File;

use Hash;
use Redirect;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Controllers\Controller;
use App\Models\Backend\referees;
use App\Models\Backend\matches;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Access\User\User;
use App\Models\Access\Role\Role;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;

class RefereesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return view('backend.file.referees.index');
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function deactivated(){
        return view('backend.file.referees.deactivated');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function referees(){
        return view('backend.file.referees.referees');
    }

        public function tel()
    {
        $referees= referees::selectRaw('referees.refaa as id, referees.* ')
                ->where('active','=','1')
                ->orderby('Lastname', 'asc')->get();
        return Datatables::of($referees)
        ->make(true);
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
     * @param  \App\referees  $referees
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $referees= referees::selectRaw('referees.refaa as id, referees.* ')
                ->where('active','=','1')
                ->orderby('Lastname', 'asc')->get();
        return Datatables::of($referees)
        ->addColumn('actions',function($referees){
                
                return view('backend.includes.partials.actions',['id'=>$referees->id, 'condition'=>'activate', 'page'=>'referees']);
        })
        ->addColumn('tel', function($referees){
                return '<a href="tel:'.$referees->tel.'">'.$referees->tel.'</a>';
            })
        ->rawColumns(['actions', 'tel'])
        ->make(true);
    } 

    /**
     * Display the specified resource.
     *
     * @param  \App\referees  $referees
     * @return \Illuminate\Http\Response
     */
    public function refStats($id)
    {
        $referees=referees::selectRaw('referees.refaa as id, referees.* ')->where('refaa','=',$id)->get();
        $matchesRef= matches::selectRaw('COUNT(matches.aa_game) as syn_matches, group1.title as title ')
                ->join('group1','matches.group1','=','group1.aa_group')
                ->where('group1.aa_period','=',session('season'))
                ->where('matches.referee', '=',$id)
                ->groupBy('group1.aa_group')
                ->orderby('group1.aa_group', 'asc')
                ->get();
        $matchesH1= matches::selectRaw('COUNT(matches.aa_game) as syn_matches, group1.title as title ')
                ->join('group1','matches.group1','=','group1.aa_group')
                ->where('group1.aa_period','=',session('season'))
                ->where('matches.helper1', '=',$id)
                ->groupBy('group1.aa_group')
                ->orderby('group1.aa_group', 'asc')
                ->get();
        $matchesH2= matches::selectRaw('COUNT(matches.aa_game) as syn_matches, group1.title as title ')
                ->join('group1','matches.group1','=','group1.aa_group')
                ->where('group1.aa_period','=',session('season'))
                ->where('matches.helper2', '=',$id)
                ->groupBy('group1.aa_group')
                ->orderby('group1.aa_group', 'asc')
                ->get();
        return view('backend.file.referees.refStats', compact('referees','matchesRef','matchesH1','matchesH2'));
    } 
    /**
     * Display the specified resource.
     *
     * @param  \App\referees  $referees
     * @return \Illuminate\Http\Response
     */

    public function show_deactivated()
    {
        $referees= referees::selectRaw('referees.refaa as id, referees.* ')
                ->where('active','=','0')
                ->orderby('Lastname', 'asc')->get();
        return Datatables::of($referees)
        ->addColumn('actions',function($referees){
                
                return view('backend.includes.partials.actions',['id'=>$referees->id, 'condition'=>'deactivate', 'page'=>'referees']);
        })
        ->rawColumns(['actions'])
        ->make(true);
    } 
    
    public function activate($id)
    {
         $referees= referees::findOrFail($id);               
         $referees->active= 1;
         $referees->save();

         return Redirect::route('admin.file.referees.index');
    }

    public function deactivate($id)
    {
        $referees= referees::findOrFail($id);               
         $referees->active= 0;
         $referees->save();

         return Redirect::route('admin.file.referees.index');
    }

    public function program($id){
        return view('backend.file.referees.program', compact('id'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\referees  $referees
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $referees=referees::selectRaw('referees.refaa as id, referees.* ')->where('refaa','=',$id)->get();

        return view('backend.file.referees.edit', compact('referees'));
    }

    public function show_modal($id)
    {
        $referees=referees::selectRaw('referees.refaa as id, referees.* ')->where('refaa','=',$id)->get();

        return view('backend.file.referees.modal-content', compact('referees'));
    }

     public function insert()
    {
        
        return view('backend.file.referees.insert');
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
                'Lastname'=> 'required',
                'Firstname'=> 'required',
                'tel'=> 'required | size:10',
            ]);
        $format = 'd/m/Y';
        try {
            $date = Carbon::createFromFormat($format, request('Bdate'));
        } catch (\Exception $e) {
           $date= config('default.datetime');
        }

        $referees= referees::findOrFail($id);               
        $referees->Lastname= $this->grstrtoupper(request('Lastname'));
        $referees->Firstname= $this->grstrtoupper(request('Firstname'));
        $referees->smsLastName= $this->convert_SMS_chars($this->grstrtoupper(request('Lastname')));
        $referees->Geniki= $this->grstrtoupper(request('Lastname').' '.substr(request('Firstname'),0,6));
        $referees->Fname= $this->grstrtoupper(request('Fname'));
        $referees->Bdate= Carbon::parse($date)->format('Y/m/d');
        $referees->address= request('address');
        $referees->tk= request('tk');
        $referees->city= request('city');
        $referees->tel= request('tel');
        $referees->email= request('email');
        if (config('settings.cities'))
        $referees->startpoint= request('startpoint');
        $referees->save();
        /*History Log record*/
        //event(new refereesUpdate($referees));

        return Redirect::route('admin.file.referees.index');

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
                'Lastname'=> 'required',
                'Firstname'=> 'required',
                'tel'=> 'required | size:10',
            ]);
        $format = 'd/m/Y';
        try {
            $date = Carbon::createFromFormat($format, request('Bdate'));
        } catch (\Exception $e) {
           $date= config('default.datetime');
        }
        $referees= new referees;               
        $referees->Lastname= $this->grstrtoupper(request('Lastname'));
        $referees->Firstname= $this->grstrtoupper(request('Firstname'));
        $referees->smsLastName= $this->convert_SMS_chars($this->grstrtoupper(request('Lastname')));
        $referees->Geniki= $this->grstrtoupper(request('Lastname').' '.substr(request('Firstname'),0,6));
        $referees->Fname= $this->grstrtoupper(request('Fname'));
        $referees->Bdate= Carbon::parse($date)->format('Y/m/d');
        $referees->address= request('address');
        $referees->tk= request('tk');
        $referees->city= request('city');
        $referees->tel= request('tel');
        $referees->email= request('email');
        if (config('settings.cities'))
        $referees->startpoint= request('startpoint');
        $referees->save();
        /*History Log record*/
        //event(new refereesUpdate($referees));

        return Redirect::route('admin.file.referees.index');

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

           /* Autocomplete referee getter */
    public function getreferee(){
        $term = Input::get('term');
    
        $results = array();
        
        $referees = referees::selectRaw('refaa as id, Lastname as ln, Firstname as fn')
            ->where('Lastname', 'LIKE', $term.'%')
            ->where('active','=', '1')
            ->take(10)->
            get();
        
        foreach ($referees as $referee)
        {
            $results[] = [ 'id' => $referee->id, 'value' => $referee->ln.' '.$referee->fn ];
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

           /* Autocomplete referee getter */
    public function massStore(){
        $referees = referees::whereActive(1)->get();
        $roles = Role::whereName('referee')->first();

        foreach ($referees as $referee) {
            if (!empty($referee->email)){
                $user = User::updateOrCreate([
                    'mobile' => $referee->tel
                ],[
                    'first_name' => $referee->Firstname,
                    'last_name' => $referee->Lastname,
                    'email' => $referee->email,
                    'password' => Hash::make($referee->tel),
                    'status' => 1,
                    'confirmed' => 1,
                ]);

                $user->attachRoles([$roles->id]);
            }
            
        }
        return redirect()->back()->withFlashSuccess('Οι χρήστες δημιουργηθήκαν επιτυχώς');
    }
}
