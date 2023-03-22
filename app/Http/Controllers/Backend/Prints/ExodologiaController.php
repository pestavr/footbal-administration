<?php

namespace App\Http\Controllers\Backend\Prints;

use PDF;
use DB;
use Redirect;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Controllers\Controller;
use App\Models\Backend\matches;
use App\Models\Backend\players;
use App\Models\Backend\exodologia;
use App\Models\Backend\referees;
use App\Models\Backend\champs;
use App\Models\Backend\penaltyOfficial;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;

class ExodologiaController extends Controller
{
    public function show_to_create_per_date(){

        return view('backend.prints.exodologia.create.date');
    }
    public function printByDate(){

        return view('backend.prints.exodologia.print.date');
    }
    
     public function createPerDate(Request $request){
        $date_from= request('date_from');
        $date_to= request('date_to');
        if (is_null($date_to)){
            $date_to=$date_from;
        }elseif(is_null($date_from)){
            $date_from=$date_to;
        }elseif(is_null($date_from) && is_null($date_to)){
            $date_from= Carbon::now();
            $date_to= Carbon::now();
        }else{
            $format = 'd/m/Y';
            $date_from = Carbon::createFromFormat($format, $date_from);
            $date_to = Carbon::createFromFormat($format, $date_to); 
        }

        session()->put('date_from', $date_from);
        session()->put('date_to', $date_to);
        
        $date_from= Carbon::parse($date_from)->format('Y/m/d 00:00');
        $date_to= Carbon::parse($date_to)->format('Y/m/d 23:59');
        $matches= matches::selectRaw('matches.aa_game as id, matches.*, team1.onoma_web as ghp, team2.onoma_web as fil, fields.eps_name as arena, group1.title as category, group1.category as cat')
                ->join('teams as team1', 'team1.team_id','=', 'matches.team1')
                ->join('teams as team2', 'team2.team_id','=', 'matches.team2')
                ->join('group1', 'group1.aa_group' ,'=','matches.group1')
                ->join('fields', 'fields.aa_gipedou','=','matches.court')
                ->where('matches.referee','<>',config('default.referee'))
                ->whereNotIn('matches.aa_game', function($q){
                    $q->select('match_id')->from('exodologia');
                })
                ->whereBetween('matches.date_time',array($date_from, $date_to))
                ->orderby('matches.date_time', 'desc');
        if (!config('settings.exodologiaKids'))
            $matches->where('group1.category','<','50');
        $matches->get();
        return Datatables::of($matches)
        ->addColumn('match', function($matches){
                return $matches->ghp.' - '.$matches->fil;
            })
        ->addColumn('check', function($matches){
                return '<input type="checkbox" name="selected_matches[]" value="'.$matches->id.'">';   
            }) 
        ->addColumn('date', function($matches){
                return Carbon::parse($matches->date_time)->format('d/m/Y H:i');
            })
        ->rawColumns(['actions', 'check'])
        ->make(true);
     }
     /*Creates exodologia depends on the EPS system*/
    public function create()
    {

        $matches = Input::get('selected_matches');
        foreach ($matches as $match){
            $cur_matches= matches::selectRaw('matches.aa_game as id, matches.match_day, matches.date_time, matches.group1, group1.title  AS omilos, team1.onoma_web AS team1, team2.onoma_web AS team2, 
                                      referees_ref.Lastname AS ref_last_name, referees_ref.Firstname AS
                                      ref_firstname, referees_ref.startpoint as StartPoint, referees_ref.city as city, matches.referee as ref_id, matches.team1 as t1, matches.team2 as t2, referees_h1.Lastname AS
                                      h1_last_name, referees_h1.Firstname AS h1_firstname, matches.helper1 as h1_id, referees_ref.city as refCity,
                                      referees_h2.Lastname AS h2_last_name, 
                                      referees_h2.Firstname AS h2_firstname, matches.helper2 as h2_id, 
                                      fields.sort_name AS field, fields.*, ref_paratirites.waLastName as 
                                      ref_par_last_name, ref_paratirites.waFirstName as ref_par_first_name, ref_paratirites.city as refObsCity, ref_paratirites.wa_id as refObsID,
                                      champs.ref as ref_sal, champs.hel as hel_sal, champs.champ_id as champ_id, champs.*')
                ->join('teams as team1', 'team1.team_id','=', 'matches.team1')
                ->join('teams as team2', 'team2.team_id','=', 'matches.team2')
                ->join('group1', 'group1.aa_group' ,'=','matches.group1')
                ->join('champs', 'champs.champ_id','=','group1.category')
                ->join('referees as referees_ref', 'referees_ref.refaa', '=', 'matches.referee')
                ->join('referees as referees_h1', 'referees_h1.refaa', '=', 'matches.helper1')
                ->join('referees as referees_h2', 'referees_h2.refaa', '=', 'matches.helper2')
                ->join('ref_paratirites', 'ref_paratirites.wa_id','=','matches.ref_paratiritis')
                ->join('paratirites', 'paratirites.wa_id','=','matches.paratiritis')
                ->join('doctors', 'doctors.doc_id','=','matches.doctor')
                ->join('fields', 'fields.aa_gipedou','=','matches.court')
                ->where('matches.aa_game','=',$match)
                ->orderby('matches.date_time', 'desc')
                ->get();
                $i=0;
            foreach ($cur_matches as $cur_match) {
                $dist=0.0;
                $ref=0.0;
                $hel=0.0;
                $wa_ma=0.0;
                $waEuKm=0.0;
                $wa_ref=0.0;
                $waRefEuKm=0.0;
                $doc=0.0;
                $docEuKm=0.0;
                $refObsdist=0.0;
                $ref_daily=0.0;
                $hel_daily=0.0;
                
                /* Υπολογισμός ΑΠόστασης και Διοδίων με */
                if (config('settings.cities')){// Υπολογισμός από διαφορετικά σημεία έναρξης
                    if($cur_match->StartPoint==1){
                        $dist=round(floatval($cur_match->Kms),2);
                        $tolls=round(floatval($cur_match->diodia),2);
                    }elseif($cur_match->StartPoint==2){
                        $dist=round(floatval($cur_match->Kms2),2);
                        $tolls=round(floatval($cur_match->diodia2),2);
                    }elseif($cur_match->StartPoint==3){
                        $dist=round(floatval($cur_match->Kms3),2);
                        $tolls=round(floatval($cur_match->diodia3),2);
                    }else{
                        $dist=0;
                        $tolls=0;
                    }
                }elseif (config('settings.google')){// Υπολογισμός από google
                    $dist=0.0;
                    $ref=0.0;  
                    $city=$cur_match->refCity;
                    $prepAddr = str_replace(' ','+',$city);
                    $geocode=file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($prepAddr).'&sensor=false&key='.config('settings.GOOGLE_API_KEY'));
                    //$output= json_decode($geocode);
                    $geo = json_decode($geocode, true); // Convert the JSON to an array
                    if ($geo['status'] == 'OK') {
                      $latitude = $geo['results'][0]['geometry']['location']['lat']; // Latitude
                      $longitude = $geo['results'][0]['geometry']['location']['lng']; // Longitude
                      $drive= $this->GetDrivingDistance($latitude,$cur_match->latitude, $longitude, $cur_match->longitude);
                    }else{
                       $drive['distance']=-1;
                       $longitude='https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($prepAddr).'&sensor=false&key='.config('settings.GOOGLE_API_KEY');
                       $latitude=-1;
                    }
                    $dist=round(floatval($drive['distance']),2);
                    $tolls=round(floatval($cur_match->diodia),2);    
                }else{ //υπολογίζονται οι αποστάσεις από μία πόλη μόνο
                     $dist=round(floatval($cur_match->Kms),2);
                     $tolls=round(floatval($cur_match->diodia),2);
                }

                /*Τέλος Υπολογισμού απόστασης και Διοδίων*/

                /*Υπολογισμός Αμοιβής Παρατηρητή Διαιτησίας*/
                if (config('settings.exodologioRefObserver')){
                    $wa_ref=$cur_match->wa_ref;
                }

                /* Υπολογισμός ΑΠόστασης και Διοδίων Παρατηρητή Διαιτησίας */
                if (config('settings.distanceRefObserver')){
                    /*Εδώ λείπει ο υπολογισμός αμοιβής με απόσταση από γήπεδο*/
                   if (config('settings.google')){
                        if($cur_match->refObsID<>config('default.refobserver')){
                            $city=$cur_match->refObsCity;
                            $prepAddr = str_replace(' ','+',$city);
                            $geocode=file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($prepAddr).'&sensor=false&key='.config('settings.GOOGLE_API_KEY'));
                            //$output= json_decode($geocode);
                            $geo = json_decode($geocode, true); // Convert the JSON to an array
                            if ($geo['status'] == 'OK') {
                              $latitude = $geo['results'][0]['geometry']['location']['lat']; // Latitude
                              $longitude = $geo['results'][0]['geometry']['location']['lng']; // Longitude
                              $drive= $this->GetDrivingDistance($latitude,$cur_match->latitude, $longitude, $cur_match->longitude);
                            }else{
                               $drive['distance']=-1;
                            }
                            $refObsdist=round(floatval($drive['distance']),2);    
                        }
                    }   

                }
                /*Τέλος Υπολογισμού απόστασης και Διοδίων*/

                /*Υπολογισμός Αμοιβής Γιατρού*/
                if (config('settings.exodologioDoctor')){
                    $doc=$cur_match->doc;
                }
                if (config('settings.distanceDoctor')){
                    //θα το φτιάξω όταν χρειαστεί
                }
                /*Υπολογισμός Αμοιβής Παρατηρητή*/
                if (config('settings.exodologioObserver')){
                         $wa_ma=$cur_match->wa_ma;
                }
                if (config('settings.distanceObserver')){
                    //θα το φτιάξω όταν χρειαστεί
                }

                $eu_Km=round(floatval($cur_match->eu_Km),2);
                $ref=round(floatval($cur_match->ref_sal),2);
                $hel=round(floatval($cur_match->hel_sal),2);
                $ref_daily=round(floatval($cur_match->ref_daily),2);
                $hel_daily=round(floatval($cur_match->hel_daily),2);

                /*Υπολογισμός Αμοιβής σε περίπτωση αγώνα Κυπέλλου*/
                if ($cur_match->champ_id==config('default.cup')){
                    $t1=$cur_match->t1;
                    $t2=$cur_match->t2;
                    $cat=champs::selectRaw('champs.ref as ref_sal, champs.hel as hel_sal, champs.ref_daily as ref_daily, champs.hel_daily as hel_daily, champs.eu_Km as eu_Km')
                         ->join('group1', 'champs.champ_id','=','group1.category')
                         ->join('teamspergroup','group1.aa_group','=','teamspergroup.group')
                         ->join('season', 'season.season_id','=', 'group1.aa_period')
                         ->where(function($query) use ($t1, $t2){
                                $query->where('teamspergroup.team','=', $t1)
                                      ->orWhere('teamspergroup.team','=', $t2);
                            })
                         ->where('season.running','=','1')
                         ->where('champs.champ_id', '!=', config('default.cup'))
                         ->orderBy('champs.champ_id', 'desc')
                         ->take(1)
                         ->get();
                    \Log::info(json_encode($cat));
                    foreach ($cat as $ca) {
                            $ref=$ca->ref_sal;
                            $hel=$ca->hel_sal;
                            $ref_daily=$ca->ref_daily;
                            $hel_daily=$ca->hel_daily;
                            $eu_Km=$ca->eu_Km;
                    }
                 /*Οι ομάδες μοιράζονται το κόστος*/   
                    $ref=round(floatval($ref),2);
                    $hel=round(floatval($hel),2);
                    $ref_daily=round(floatval($ref_daily),2);
                    $hel_daily=round(floatval($hel_daily),2);
                    
                }
                /*Υπολογισμός Ποινών Αξιωματούχων*/
                if (config('settings.exodologioShowOfficialsPenalties')){
                    $penaltiesOfficials=penaltyOfficial::selectRaw('penalties_officials.*, teams_p.onoma_eps as team_name, infliction_date, fine, match_days, kind_of_days, penalties_officials.team_id as team_pen, remain')
                                                        ->join('teams as teams_p' ,'penalties_officials.team_id','=','teams_p.team_id')
                                                        
                                                         ->where(function($query) use ($match){
                                                                 $query->where('penalties_officials.team_id','=', matches::getAll($match)->team1)
                                                                       ->orWhere('penalties_officials.team_id','=', matches::getAll($match)->team2);
                                                                   })
                                                        
                                                        ->orderBy('penalties_officials.infliction_date', 'asc')
                                                        ->get();
                     $officials=array();
                     $i=1;
                     foreach($penaltiesOfficials as $pOf){
                        if ($pOf->kind_of_days==2){
                            $until_date=Carbon::parse($pOf->infliction_date)->addDays($pOf->match_days);
                            $match_date=Carbon::parse(matches::getAll($match)->date_time);
                            if ($until_date->gte($match_date)){
                                $officials[$i]['name']=$pOf->name;
                                $officials[$i]['title']=$pOf->title;
                                $officials[$i]['team_name']=$pOf->team_name;
                                $officials[$i]['until_date']=$until_date->format('Y-m-d');
                                $officials[$i]['match_date']=$pOf->match_date;
                            }
                        }elseif($pOf->kind_of_days==3){
                            $until_date=Carbon::parse($pOf->infliction_date)->addMonths($pOf->match_days);
                            $match_date=Carbon::parse(matches::getAll($match)->date_time);
                            if ($until_date->gte($match_date)){
                                $officials[$i]['name']=$pOf->name;
                                $officials[$i]['title']=$pOf->title;
                                $officials[$i]['team_name']=$pOf->team_name;
                                $officials[$i]['until_date']=$until_date->format('Y-m-d');
                                $officials[$i]['match_date']=$pOf->match_date;
                            }
                        }else{
                            if($pOf->remain>0){
                                $officials[$i]['name']=$pOf->name;
                                $officials[$i]['title']=$pOf->title;
                                $officials[$i]['team_name']=$pOf->team_name;
                            }
                        }
                        $i++;
                     }      
                     $penOfficials=json_encode($officials);         
                }
                /*Τέλος Υπολογισμού ΠΟινών Αξιωματούχων*/
                /*Αποθήκευση εξοδολογίου*/
                    $exodologio= new exodologia;
                    $exodologio->match_id=$match;
                    $exodologio->ref_sal=$ref;
                    $exodologio->ref_mov=round($dist*$eu_Km*2,2);
                    $exodologio->hel_sal=round($hel*2,2);
                    $exodologio->hel_mov=0;
                    $exodologio->ref_wa_sal= $wa_ref;
                    $exodologio->ref_wa_mov=$refObsdist*$waRefEuKm;
                    $exodologio->obs_sal=$wa_ma;
                    $exodologio->obs_mov= $waEuKm;
                    $exodologio->doc_sal= $doc;
                    $exodologio->doc_mov=$docEuKm;
                    $exodologio->toll=$tolls;
                    $exodologio->printable=0;
                    $exodologio->ref_printed=0;
                    $exodologio->ref_daily=$ref_daily;
                    $exodologio->hel_daily=round($hel_daily*2,2);
                    $sum=$ref+round($dist*$eu_Km*2,2)+round($hel*2,2)+$wa_ref+($refObsdist*$waRefEuKm)+$wa_ma+$waEuKm+ $doc + $docEuKm + $tolls + $ref_daily + round($hel_daily*2,2);
                    $exodologio->sum=round($sum,2);
                    if (config('settings.exodologioShowOfficialsPenalties'))
                    $exodologio->penalties=$penOfficials;
                    $exodologio->save();
                    $i++;
                    
            }
            

        }
        
        return redirect()->back()->withFlashSuccess('Επιτυχής Δημιουργία');
    }
    /*Function that returns the distance between two geoPoints*/
    function GetDrivingDistance($lat1, $lat2, $long1, $long2)
    {
        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$lat1.",".$long1."&destinations=".$lat2.",".$long2."&mode=driving&language=pl-PL&key=".config('settings.GOOGLE_API_KEY');
        try{
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            $response = curl_exec($ch);
            curl_close($ch);
        }catch (\Exception $e) {
              return $e->getMessage();
          }
                
        $response_a = json_decode($response, true);
        if (isset($response_a['rows'][0]['elements'][0]['distance']['text'])){
        $dist = $response_a['rows'][0]['elements'][0]['distance']['text'];
        $time = $response_a['rows'][0]['elements'][0]['duration']['text'];
        }else{
        $dist=0;
        $time=0;
        }
        return array('distance' => $dist, 'time' => $time);
    }

     public function show_per_date(){
        return view('backend.prints.exodologia.edit.date');
     }

     public function show_per_cat(){
        return view('backend.prints.exodologia.edit.cat');
     }

     public function getPerDate(Request $request){

        $date_from= request('date_from');
        $date_to= request('date_to');
        if (is_null($date_to)){
            $date_to=$date_from;
        }elseif(is_null($date_from)){
            $date_from=$date_to;
        }elseif(is_null($date_from) && is_null($date_to)){
            $date_from= Carbon::now();
            $date_to= Carbon::now();
        }else{
            $format = 'd/m/Y';
            $date_from = Carbon::createFromFormat($format, $date_from);
            $date_to = Carbon::createFromFormat($format, $date_to); 
        }

        session()->put('date_from', $date_from);
        session()->put('date_to', $date_to);
        
        $date_from= Carbon::parse($date_from)->format('Y/m/d 00:00');
        $date_to= Carbon::parse($date_to)->format('Y/m/d 23:59');
        $matches= matches::selectRaw('matches.aa_game as m_id, matches.match_day, matches.date_time, matches.group1, group1.title  AS omilos, team1.onoma_web AS team1, team2.onoma_web AS team2, 
                                      referees_ref.Lastname AS ref_last_name, referees_ref.Firstname AS
                                      ref_firstname, referees_ref.StartPoint as startpoint, matches.referee as
                                      ref_id, matches.team1 as t1, matches.team2 as t2, referees_h1.Lastname AS
                                      h1_last_name, referees_h1.Firstname AS h1_firstname, matches.helper1 as h1_id,referees_h2.Lastname AS h2_last_name, group1.locked as groupLocked,
                                      referees_h2.Firstname AS h2_firstname, matches.helper2 as h2_id, 
                                      fields.sort_name AS field,  ref_paratirites.waLastName as 
                                      ref_par_last_name, ref_paratirites.waFirstName as ref_par_first_name,
                                      champs.ref as ref_sal1, champs.hel as hel_sal1, champs.champ_id as champ_id, exodologia.*')
                ->join('teams as team1', 'team1.team_id','=', 'matches.team1')
                ->join('teams as team2', 'team2.team_id','=', 'matches.team2')
                ->join('group1', 'group1.aa_group' ,'=','matches.group1')
                ->join('champs', 'champs.champ_id','=','group1.category')
                ->join('exodologia', 'exodologia.match_id','=', 'matches.aa_game')
                ->join('referees as referees_ref', 'referees_ref.refaa', '=', 'matches.referee')
                ->join('referees as referees_h1', 'referees_h1.refaa', '=', 'matches.helper1')
                ->join('referees as referees_h2', 'referees_h2.refaa', '=', 'matches.helper2')
                ->join('ref_paratirites', 'ref_paratirites.wa_id','=','matches.ref_paratiritis')
                ->join('fields', 'fields.aa_gipedou','=','matches.court')
                ->where('matches.referee','<>','0')
                ->whereBetween('matches.date_time',array($date_from, $date_to))
                ->orderby('matches.date_time', 'desc');
                if (!config('settings.exodologiaKids'))
                    $matches->where('group1.category','<','50');
                $matches->get();
        
        return Datatables::of($matches)
       
        ->addColumn('match', function($matches){
                return $matches->omilos.'<br/>'.Carbon::parse($matches->date_time)->format('d/m/Y H:i').'<br/>'.$matches->field.'<br/>'.$matches->team1.' - '.$matches->team2;
            })
        ->addColumn('actions',function($matches){
                $editable=(strlen($matches->score1)>0 || $matches->groupLocked==1)?false:true;
                return view('backend.prints.exodologia.partials.actions',['id'=>$matches->match_id, 'editable'=>$editable]);
        })
        ->addColumn('referee', function($matches){
                return $matches->ref_last_name.' '.$matches->ref_firstname.'<br/>'.'Αμοιβή:'.$matches->ref_sal.' €'.'<br/>'.'Μετακίνηση:'.$matches->ref_mov.' €';
            })
        ->addColumn('helpers', function($matches){
                return $matches->h1_last_name.' '.$matches->h1_firstname.'<br/>'.$matches->h2_last_name.' '.$matches->h2_firstname.'<br/>'.'Αμοιβή:'.$matches->hel_sal.' €'.'<br/>'.'Μετακίνηση:'.$matches->hel_mov.' €';
            })
        ->addColumn('tolls', function($matches){
                return $matches->toll.' €';
            })
        ->addColumn('ref_par', function($matches){
                return $matches->ref_par_last_name.' '.$matches->ref_par_first_name.'<br/> Αμοιβή: '.$matches->ref_wa_sal.' €';
            })
        ->addColumn('printable', function($matches){
                $res='';
                if ($matches->printable==1){
                    $res='<i class="fa fa-check-circle" style="color:green; font-size: 1.5em"></i>';
                }else{
                    $res='<i class="fa fa-times-circle" style="color:red; font-size: 1.5em"></i>';
                }
                return $res;
            })
        ->addColumn('ref_printed', function($matches){
                $res='';
                if ($matches->ref_printed==1){
                    $res='<i class="fa fa-check-circle" style="color:green; font-size: 1.5em"></i>';
                }else{
                    $res='<i class="fa fa-times-circle" style="color:red; font-size: 1.5em"></i>';
                }
                return $res;
            })
        ->rawColumns(['match','actions','referee','helpers','tolls','ref_par', 'printable', 'ref_printed'])
        ->make(true);
     }

     public function per_md(){
        session()->put('category',request('category'));
        session()->put('md_from',request('md_from'));
        session()->put('md_to',request('md_to'));
        $category= request('category');
        $md_from= request('md_from');
        $md_to= request('md_to');
         $matches= matches::selectRaw('matches.aa_game as m_id, matches.match_day, matches.date_time, matches.group1, group1.title  AS omilos, team1.onoma_web AS team1, team2.onoma_web AS team2, 
                                      referees_ref.Lastname AS ref_last_name, referees_ref.Firstname AS
                                      ref_firstname, referees_ref.StartPoint as startpoint, matches.referee as
                                      ref_id, matches.team1 as t1, matches.team2 as t2, referees_h1.Lastname AS
                                      h1_last_name, referees_h1.Firstname AS h1_firstname, matches.helper1 as h1_id,referees_h2.Lastname AS h2_last_name, group1.locked as groupLocked,
                                      referees_h2.Firstname AS h2_firstname, matches.helper2 as h2_id, 
                                      fields.sort_name AS field,  ref_paratirites.waLastName as 
                                      ref_par_last_name, ref_paratirites.waFirstName as ref_par_first_name,
                                      champs.ref as ref_sal1, champs.hel as hel_sal1, champs.champ_id as champ_id, exodologia.*')
                ->join('teams as team1', 'team1.team_id','=', 'matches.team1')
                ->join('teams as team2', 'team2.team_id','=', 'matches.team2')
                ->join('group1', 'group1.aa_group' ,'=','matches.group1')
                ->join('champs', 'champs.champ_id','=','group1.category')
                ->join('exodologia', 'exodologia.match_id','=', 'matches.aa_game')
                ->join('referees as referees_ref', 'referees_ref.refaa', '=', 'matches.referee')
                ->join('referees as referees_h1', 'referees_h1.refaa', '=', 'matches.helper1')
                ->join('referees as referees_h2', 'referees_h2.refaa', '=', 'matches.helper2')
                ->join('ref_paratirites', 'ref_paratirites.wa_id','=','matches.ref_paratiritis')
                ->join('fields', 'fields.aa_gipedou','=','matches.court')
                ->where('matches.referee','<>','0')
                ->where('matches.group1','=', $category)
                ->whereBetween('matches.match_day',array($md_from, $md_to))
                ->orderby('matches.date_time', 'desc');
                if (!config('settings.exodologiaKids'))
                    $matches->where('group1.category','<','50');
                $matches->get();
        
        
        return Datatables::of($matches)
       
        ->addColumn('match', function($matches){
                return $matches->omilos.'<br/>'.Carbon::parse($matches->date_time)->format('d/m/Y H:i').'<br/>'.$matches->field.'<br/>'.$matches->team1.' - '.$matches->team2;
            })
        ->addColumn('actions',function($matches){
                $editable=(strlen($matches->score1)>0 || $matches->groupLocked==1)?false:true;
                return view('backend.prints.exodologia.partials.actions',['id'=>$matches->match_id, 'editable'=>$editable]);
        })
        ->addColumn('referee', function($matches){
                return $matches->ref_last_name.' '.$matches->ref_firstname.'<br/>'.'Αμοιβή:'.$matches->ref_sal.' €'.'<br/>'.'Μετακίνηση:'.$matches->ref_mov.' €';
            })
        ->addColumn('helpers', function($matches){
                return $matches->h1_last_name.' '.$matches->h1_firstname.'<br/>'.$matches->h2_last_name.' '.$matches->h2_firstname.'<br/>'.'Αμοιβή:'.$matches->hel_sal.' €'.'<br/>'.'Μετακίνηση:'.$matches->hel_mov.' €';
            })
        ->addColumn('tolls', function($matches){
                return $matches->toll.' €';
            })
        ->addColumn('ref_par', function($matches){
                return $matches->ref_par_last_name.' '.$matches->ref_par_first_name.'<br/> Αμοιβή: '.$matches->ref_wa_sal.' €';
            })
        ->addColumn('printable', function($matches){
                $res='';
                if ($matches->printable==1){
                    $res='<i class="fa fa-check-circle" style="color:green; font-size: 1.5em"></i>';
                }else{
                    $res='<i class="fa fa-times-circle" style="color:red; font-size: 1.5em"></i>';
                }
                return $res;
            })
        ->addColumn('ref_printed', function($matches){
                $res='';
                if ($matches->ref_printed==1){
                    $res='<i class="fa fa-check-circle" style="color:green; font-size: 1.5em"></i>';
                }else{
                    $res='<i class="fa fa-times-circle" style="color:red; font-size: 1.5em"></i>';
                }
                return $res;
            })
        ->rawColumns(['match','actions','referee','helpers','tolls','ref_par', 'printable', 'ref_printed'])
        ->make(true);
     }


     public function edit($id){
        $match=matches::selectRaw('matches.aa_game as id, matches.match_day, matches.date_time, matches.group1, 
                                      group1.title  AS omilos, team1.onoma_web AS team1, team2.onoma_web AS team2, fields.*, ref_paratirites.waLastName as ref_par_last_name, ref_paratirites.waFirstName as ref_par_first_name, referees_ref.Lastname AS ref_last_name, referees_ref.Firstname AS ref_firstname, referees_ref.StartPoint as startpoint, matches.referee as ref_id, matches.team1 as t1, matches.team2 as t2, referees_h1.Lastname AS h1_last_name, referees_h1.Firstname AS h1_firstname, referees_h2.Lastname AS h2_last_name, referees_h2.Firstname AS h2_firstname, fields.sort_name AS field')
                        ->join('teams as team1', 'team1.team_id','=', 'matches.team1')
                        ->join('teams as team2', 'team2.team_id','=', 'matches.team2')
                        ->join('group1', 'group1.aa_group' ,'=','matches.group1')
                        ->join('referees as referees_ref', 'referees_ref.refaa', '=', 'matches.referee')
                        ->join('referees as referees_h1', 'referees_h1.refaa', '=', 'matches.helper1')
                        ->join('referees as referees_h2', 'referees_h2.refaa', '=', 'matches.helper2')
                        ->join('ref_paratirites', 'ref_paratirites.wa_id','=','matches.ref_paratiritis')
                        ->join('fields', 'fields.aa_gipedou','=','matches.court')
                        ->where('aa_game','=', $id)
                        ->get();
        $exod=exodologia::selectRaw('exodologia.*')->where('match_id','=', $id)->get();
        return view('backend.prints.exodologia.edit.edit', compact('exod', 'match'));
     }
     public function update($id)
    {
        $this->validate(request(), [
                'ref_sal'=> 'numeric|nullable',
                'ref_mov'=> 'numeric|nullable',
                'hel_daily'=> 'numeric|nullable',
                'ref_daily'=> 'numeric|nullable',
                'hel_sal'=> 'numeric|nullable',
                'hel_mov'=> 'numeric|nullable',
                'ref_wa_sal'=> 'numeric|nullable',
                'ref_wa_mov'=> 'numeric|nullable',
                'obs_sal'=> 'numeric|nullable',
                'obs_mov'=> 'numeric|nullable',
                'doc_sal'=> 'numeric|nullable',
                'doc_mov'=> 'numeric|nullable',
                'toll'=> 'numeric'
            ]);
        $sum=0;            
        $exodologio= exodologia::findOrFail($id);  
        $exodologio->ref_sal=request('ref_sal');
        $sum+=round(floatval(request('ref_sal')),2);
        $exodologio->ref_mov=request('ref_mov');
        $sum+=round(floatval(request('ref_mov')),2);
        $exodologio->hel_sal=request('hel_sal');
        $sum+=round(floatval(request('hel_sal')),2);
        if(config('settings.imergargiaReferee')){
            $exodologio->ref_daily=request('ref_daily');
            $sum+=round(floatval(request('ref_daily')),2);
        }
        if(config('settings.distanceHelper')){
            $exodologio->hel_mov=request('hel_mov');
            $sum+=round(floatval(request('hel_mov')),2);
        }
        if(config('settings.imergargiaHelpers')){
            $exodologio->hel_daily=request('hel_daily');
            $sum+=round(floatval(request('hel_daily')),2);
        }
        if(config('settings.exodologioRefObserver')){
            $exodologio->ref_wa_sal=request('ref_wa_sal');
            $sum+=round(floatval(request('ref_wa_sal')),2);
        }
        if(config('settings.distanceRefObserver')){
            $exodologio->ref_wa_mov=request('ref_wa_mov');
            $sum+=round(floatval(request('ref_wa_mov')),2);
        }
        if(config('settings.exodologioObserver')){
            $exodologio->obs_sal=request('obs_sal');
            $sum+=round(floatval(request('obs_sal')),2);
        }
        if(config('settings.distanceObserver')){
            $exodologio->obs_mov=request('obs_mov');
            $sum+=round(floatval(request('obs_mov')),2);
        }
        if(config('settings.exodologioDoctor')){
            $exodologio->doc_sal=request('doc_sal');
            $sum+=round(floatval(request('doc_sal')),2);
        }
        if(config('settings.distanceDoctor')){
            $exodologio->doc_mov=request('doc_mov');
            $sum+=round(floatval(request('doc_mov')),2);
        }
        if(config('settings.toll')){
            $exodologio->toll=request('toll');
            $sum+=round(floatval(request('toll')),2);
        }
        if(config('settings.extraPage')){
            if (request('extraPage'))
                $exodologio->extrapage=1;
            else
                $exodologio->extrapage=0;
            $exodologio->date=request('date');
            $exodologio->protokollo=request('protokollo');
            $exodologio->pros=request('pros');
            $exodologio->thema=request('thema');
            $exodologio->keimeno=request('keimeno');
        }
        $exodologio->comments=request('comments');
        $exodologio->sum=$sum;
        $exodologio->printable=0;
        $exodologio->ref_printed=0;
        $exodologio->save();
        /*History Log record*/
        //event(new refereesUpdate($referees));

        return redirect()->back()->withFlashSuccess('Επιτυχής Αποθήκευση');

    }

    public function print_per_date(Request $request){
        $date_from= request('date_from');
        $date_to= request('date_to');
        if (is_null($date_to)){
            $date_to=$date_from;
        }elseif(is_null($date_from)){
            $date_from=$date_to;
        }elseif(is_null($date_from) && is_null($date_to)){
            $date_from= Carbon::now();
            $date_to= Carbon::now();
        }else{
            $format = 'd/m/Y';
            $date_from = Carbon::createFromFormat($format, $date_from);
            $date_to = Carbon::createFromFormat($format, $date_to); 
        }

        session()->put('date_from', $date_from);
        session()->put('date_to', $date_to);
        
        $date_from= Carbon::parse($date_from)->format('Y/m/d 00:00');
        $date_to= Carbon::parse($date_to)->format('Y/m/d 23:59');
        $matches= matches::selectRaw('matches.aa_game as m_id, matches.*, team1.onoma_web as ghp, team2.onoma_web as fil, fields.eps_name as arena, group1.title as category, group1.category as cat, exodologia.printable as printable, exodologia.ref_printed as ref_printed')
                ->join('teams as team1', 'team1.team_id','=', 'matches.team1')
                ->join('teams as team2', 'team2.team_id','=', 'matches.team2')
                ->join('exodologia', 'exodologia.match_id','=', 'matches.aa_game')
                ->join('group1', 'group1.aa_group' ,'=','matches.group1')
                ->join('fields', 'fields.aa_gipedou','=','matches.court')
                ->whereBetween('matches.date_time',array($date_from, $date_to))
                ->orderby('matches.date_time', 'desc');
                if (!config('settings.exodologiaKids'))
                    $matches->where('group1.category','<','50');
                $matches->get();
        return Datatables::of($matches)
        ->addColumn('match', function($matches){
                return $matches->ghp.' - '.$matches->fil;
            })
        ->addColumn('check', function($matches){
                return '<input type="checkbox" name="selected_matches[]" value="'.$matches->m_id.'">';   
            }) 
        ->addColumn('date', function($matches){
                return Carbon::parse($matches->date_time)->format('d/m/Y H:i');
            })
        ->addColumn('actions',function($matches){
                return view('backend.prints.exodologia.partials.actions',['id'=>$matches->m_id, 'editable'=>false]);
        })
         ->addColumn('printable', function($matches){
                $res='';
                if ($matches->printable==1){
                    $res='<i class="fa fa-check-circle" style="color:green; font-size: 1.5em"></i>';
                }else{
                    $res='<i class="fa fa-times-circle" style="color:red; font-size: 1.5em"></i>';
                }
                return $res;
            })
        ->addColumn('ref_printed', function($matches){
                $res='';
                if ($matches->ref_printed==1){
                    $res='<i class="fa fa-check-circle" style="color:green; font-size: 1.5em"></i>';
                }else{
                    $res='<i class="fa fa-times-circle" style="color:red; font-size: 1.5em"></i>';
                }
                return $res;
            })
        ->rawColumns(['actions', 'check', 'printable', 'ref_printed'])
        ->make(true);
     }

    public function exodologio($id){
            $matches= matches::selectRaw('matches.aa_game as match_id, matches.match_day, matches.date_time, matches.group1, matches.team1 as team1_id, matches.team2 as team2_id, matches.score_team_1 as score1, matches.score_team_2 as score2, group1.omilos, group1.title  AS omilos, teams1.onoma_web AS team1, teams2.onoma_web AS team2,  referees_ref.Lastname AS ref_last_name, referees_ref.Firstname AS ref_firstname, matches.referee as ref_id, matches.team1 as t1, matches.team2 as t2, referees_h1.Lastname AS h1_last_name, referees_h1.Firstname AS h1_firstname, matches.helper1 as h1_id, season.period as season_name, referees_h2.Lastname AS h2_last_name, referees_h2.Firstname AS h2_firstname, matches.helper2 as h2_id,matches.paratiritis as par_id, matches.doctor as doc_id, doctors.docLastName as doc_last, doctors.docFirstName as doc_first, paratirites.waLastName as par_last, paratirites.waFirstName as par_first, ref_paratirites.waLastName as ref_par_last, ref_paratirites.waFirstName as ref_par_first, fields.sort_name AS field, matches.published as pub, matches.notified as notif, champs.*, fields.*, season.period as season, exodologia.*')
                ->join('teams as teams1', 'teams1.team_id','=', 'matches.team1')
                ->join('teams as teams2', 'teams2.team_id','=', 'matches.team2')
                ->join('group1', 'group1.aa_group' ,'=','matches.group1')
                ->join('champs', 'champs.champ_id','=','group1.category')
                ->join('exodologia', 'exodologia.match_id','=', 'matches.aa_game')
                ->join('season', 'season.season_id','=', 'group1.aa_period')
                ->join('fields', 'fields.aa_gipedou','=','matches.court')
                ->join('referees as referees_ref', 'referees_ref.refaa', '=', 'matches.referee')
                ->join('referees as referees_h1', 'referees_h1.refaa', '=', 'matches.helper1')
                ->join('referees as referees_h2', 'referees_h2.refaa', '=', 'matches.helper2')
                ->join('doctors', 'doctors.doc_id','=','matches.doctor')
                ->join('paratirites', 'paratirites.wa_id','=','matches.paratiritis')    
                ->join('ref_paratirites', 'ref_paratirites.wa_id','=','matches.ref_paratiritis')                
                ->where('matches.aa_game','=', $id)
                ->orderby('matches.date_time', 'desc')
                ->get();
            foreach ($matches as $match) {
                $team1_champ=champs::selectRaw('champs.champ_id as champ_id')
                               ->join('group1', 'group1.category', '=', 'champs.champ_id')
                               ->join('season', 'season.season_id', '=', 'group1.aa_period')
                               ->join('teamspergroup', 'teamspergroup.group', '=','group1.aa_group')
                               ->where('teamspergroup.team', '=', $match->team1_id)
                               ->where('season.running', '=', 1)
                               ->first();  
                $team2_champ=champs::selectRaw('champs.champ_id as champ_id')
                               ->join('group1', 'group1.category', '=', 'champs.champ_id')
                               ->join('season', 'season.season_id', '=', 'group1.aa_period')
                               ->join('teamspergroup', 'teamspergroup.group', '=','group1.aa_group')
                               ->where('teamspergroup.team', '=', $match->team2_id)
                               ->where('season.running', '=', 1)
                               ->first(); 
                $team1_champ=$team1_champ->champ_id;                               
                $team2_champ=$team2_champ->champ_id;
            }
                  

        return view('backend.prints.exodologia.pdf.print'.config('settings.eps'), compact('matches', 'team1_champ', 'team2_champ'));
    }
    public function print($id){

           
        $pdf = PDF::loadHTML($this->exodologio($id)->render());
        return $pdf->stream('exodologio.pdf');
    }
    // Εκτύπωση Εξοδολογίου από Διαιτητή ενημερώνει τοref_printed
    public function ref_print($id){
        $exodologio=exodologia::selectRaw('id as ex_id')
                    ->join('matches', 'matches.aa_game', '=', 'exodologia.match_id')
                    ->where('matches.aa_game','=', $id)
                    ->get();
        foreach ($exodologio as $ex){
            $exodologio= exodologia::findOrFail($ex->ex_id);  
            $exodologio->ref_printed=1;
            $exodologio->save();
        }
           
        $pdf = PDF::loadHTML($this->exodologio($id)->render());
        return $pdf->stream('exodologio.pdf');
    }
    public function print_selected()
    {
        $view='';
        $matches = Input::get('selected_matches');
        foreach ($matches as $match){
            
             $view.=$this->exodologio($match)->render();
               
        }
        $pdf = PDF::loadHTML($view);
        return $pdf->stream('exodologia.pdf');
    }
    public function my_exodologia(){
        if (config('settings.referee'))
            return view('backend.prints.exodologia.next');
        else
            return redirect()->back()->withFlashDanger('Δεν έχετε δικαιώμα να εκτυπώσετε εξοδολόγια');
    }
    public function my_last_exodologia(){
        if (config('settings.referee'))
            return view('backend.prints.exodologia.previous');
        else
            return redirect()->back()->withFlashDanger('Δεν έχετε δικαιώμα να εκτυπώσετε εξοδολόγια');
    }
    public function next_program(){
            $user=request('referee');
            $time=request('time');
            $symbol= ($time=='before')?'<':'>=';
            $referees= Referees::selectRaw('refaa as id')
                                ->join('users', 'users.mobile','=','referees.tel')
                                ->where('users.id','=',$user)->get();
            foreach($referees as $referee)
            $id= $referee->id;
            $matches= matches::selectRaw('matches.aa_game as match_id, matches.*, team1.onoma_web as ghp, team2.onoma_web as fil, fields.eps_name as arena, group1.title as category, group1.category as cat')
                ->join('teams as team1', 'team1.team_id','=', 'matches.team1')
                ->join('teams as team2', 'team2.team_id','=', 'matches.team2')
                ->join('exodologia', 'exodologia.match_id','=', 'matches.aa_game')
                ->join('group1', 'group1.aa_group' ,'=','matches.group1')
                ->join('season', 'season.season_id','=', 'group1.aa_period')
                ->join('fields', 'fields.aa_gipedou','=','matches.court')
                ->where('season.season_id','=',session('season'))
                ->where(function($query) use ($id){
                    $query->where('matches.referee','=', $id)
                          ->orWhere('matches.helper1','=', $id)
                          ->orWhere('matches.helper2','=', $id);
                })
                ->where('exodologia.printable','=', '1')
                ->whereDate('matches.date_time',$symbol, Carbon::today()->toDateString())
                ->orderby('matches.date_time', 'desc')->get();
        return Datatables::of($matches)
        ->addColumn('actions',function($matches){
                $grades=($matches->ref_grades>0)?true:false;
                return view('backend.prints.exodologia.partials.actions',['id'=>$matches->match_id, 'editable'=>false, 'grades'=>$grades]);
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

    public function show_to_publish_per_date(){

        return view('backend.prints.exodologia.publish.date');
    }
    public function publish()
    {
        $matches = Input::get('selected_matches');
        foreach ($matches as $match){
            $exodologio=exodologia::selectRaw('id as ex_id')
                        ->join('matches', 'matches.aa_game', '=', 'exodologia.match_id')
                        ->where('matches.aa_game','=', $match)
                        ->get();
            foreach ($exodologio as $ex){
                $exodologio= exodologia::findOrFail($ex->ex_id);  
                $exodologio->printable=1;
                $exodologio->save();
            }
            
        }
        return redirect()->back()->withFlashSuccess('Επιτυχής Δημοσίευση');
    }

        /**
     * Remove the specified resource from storage.
     *
     * @param  \App\referees  $referees
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $exodologia= exodologia::where('match_id','=',$id)->delete();


       return redirect()->back()->withFlashSuccess('Επιτυχής Διαγραφή');
    }
}


