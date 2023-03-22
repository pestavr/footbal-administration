{{ Html::style('//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css') }}
<?php ini_set("pcre.backtrack_limit","20000000"); ?>
        <div class="box box-success">
        <div class="box-header with-border">
            

            <div class="box-tools pull-right">
                
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->
       
        @foreach ($matches as $match)
        <div class="box-body">
            <div class="with-border">
                <div class="page">
                  <div id="printable">
                    <table class="table" style="width: 100%" >
                        <tr>
                          <td>
                            <table class="table" style="width: 100%">
                              <tr>
                                <td colspan="2">
                                  <table class="table" style="width: 100%">
                                    <tr>
                                      <td style="vertical-align:top;">
                                        <center><img src="{{ asset(config('settings.logo')) }}" class="img-responsive" alt=""></center>
                                        <center> Έτος Ίδρυσης {{ \App\Models\Backend\eps::getAll()->etos_idrisis }}</center>
                                      </td>
                                      <td style="vertical-align: top">
                                        <center><h2>{{ \App\Models\Backend\eps::getAll()->name }}</h2><h6>{{ \App\Models\Backend\eps::getAll()->address }}, ΤΚ {{ \App\Models\Backend\eps::getAll()->tk }}, {{ \App\Models\Backend\eps::getAll()->city }} - τηλ {{ \App\Models\Backend\eps::getAll()->tel }}</h6><h6>site: {{ \App\Models\Backend\eps::getAll()->site_address }}- email: {{ \App\Models\Backend\eps::getAll()->email }}</h6></center>
                                      </td>
                                    </tr>
                                </table>
                              </td>
                            </tr>
                              <tr>
                                <td colspan="2">
                                    <center><h2>ΕΞΟΔΟΛΟΓΙΟ ΔΙΑΙΤΗΣΙΑΣ</h3></center>
                                      <br/>
                                      <?php  ?>
                                      <center><h4>Κωδικός Αναμέτρησης: #{{str_repeat('0',(5-strlen($match->match_id))).$match->match_id}}#</h4></center>
                                      <center><h5>{{$match->season}}</h5></center>
                                      <center><h5>{{$match->omilos}}- {{$match->match_day}}η Αγωνιστική</h5></center>
                                      <br/>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <center><h4>Γηπεδούχος</h4></center>
                                </td>
                                <td>
                                  <center><h4>Φιλοξενούμενος</h4></center>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <center><h3>{{$match->team1}}</h3></center>
                                </td>
                                <td>
                                  <center><h3>{{$match->team2}}</h3></center>
                                  
                                </td>
                              </tr> 
                                                                                           
                              <tr>
                                <td colspan="2" >
                                  <table class="table" style="width:100%;">
                                        <tr>
                                          <td >Ημερομηνία:<br/>&nbsp;</td>
                                          <td class="font-weight-bold">{{date('d-m-Y', strtotime($match->date_time)) }}<br/>&nbsp;</td>
                                          <td>Ώρα:<br/>&nbsp;</td>
                                          <td class="font-weight-bold">{{date('H:i', strtotime($match->date_time))}}<br/>&nbsp;</td>
                                          <td>Γήπεδο:<br/>&nbsp;</td>
                                          <td class="font-weight-bold">{{$match->field}}<br/>&nbsp;</td>    
                                        </tr>
                                        
                                        
                                        <tr> 
                                          <td>Διαιτητής: <br/>&nbsp;</td>
                                          <td class="font-weight-bold">{{$match->ref_last_name}} {{$match->ref_firstname}}<br/>&nbsp;</td>
                                          <td>1ος Βοηθός: <br/>&nbsp;</td>
                                          <td class="font-weight-bold">{{ $match->h1_last_name}} {{$match->h1_firstname}}<br/>&nbsp;</td>
                                          <td>2ος Βοηθός: <br/>&nbsp;</td>
                                          <td class="font-weight-bold">{{$match->h2_last_name}} {{$match->h2_firstname}}<br/>&nbsp;</td>
                                        </tr>
                                        <tr> 
                                          <td>Παρατηρητής: <br/>&nbsp;</td>
                                          <td class="font-weight-bold">{{$match->par_last}} {{$match->par_first}}<br/>&nbsp;</td>
                                          <td>Παρ. Διαιτησίας: <br/>&nbsp;</td>
                                          <td class="font-weight-bold">{{ $match->ref_par_last}} {{$match->ref_par_first}}<br/>&nbsp;</td>
                                          <td></td>
                                          <td class="font-weight-bold"></td>
                                        </tr>
                                  </table>
                                </td>
                              </tr>
                              <tr>
                                  <td colspan="2">
                                      <center><u>Παρατηρήσεις Διοργανώτριας</u></center><br/>&nbsp;
                                      {{ $match->comments}}
                                  </td>
                              </tr>
                              @if (config('settings.exodologioShowOfficialsPenalties'))
                               <tr>
                                  <td colspan="2">
                                      <center><u>Απαγορεύεται η είσοδος στους παρακάτω αξιωματούχους:</u></center><br/>&nbsp;
                                      <?php $penalties=collect(json_decode($match->penalties));?>
                                            @foreach($penalties as $pen)
                                                {{$pen->name}} ({{$pen->title}}- {{$pen->team_name}})<br/>
                                            @endforeach
                                             
                                            
                                  </td>
                              </tr>
                              @endif
                              <tr>
                                <td colspan="2" >
                                  <table class="table" style="width:100%">
                                    <tr>
                                      <td colspan="2">
                                        <b><u>Αποζημίωση Διαιτησίας και Μετακίνηση  </u></b>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td style="text-align: right; width:50%;">
                                        Αμοιβή (Διαιτητής- Α' Βοηθός- Β' Βοηθός):
                                      </td>
                                      <td style="text-align: center; width:50%;">
                                         {{ $match->ref_sal}}€ + {{ round(floatval($match->hel_sal)/2,2) }}€ + {{ round(floatval($match->hel_sal)/2,2) }}€ 
                                     
                                      </td>
                                    </tr>
                                    <tr>
                                      <td style="text-align: right;width:50%;">
                                        Έξοδα Μετακίνησης(Διαιτητής- Βοηθoί):
                                      </td>
                                      <td style="text-align: center; width:50%;">
                                         ({{ $match->ref_mov }}€ - {{ $match->hel_mov }}€) 
                                        
                                      </td>
                                    </tr>
                                    <tr>
                                      <td style="text-align: right">
                                        Ημεραργίες Διαιτητών (Διαιτητής- Βοηθoί):
                                      </td>
                                      <td style="text-align: center; width:50%;">
                                         {{ $match->ref_daily}}€ - {{ $match->hel_daily}}€
                                      </td>
                                    </tr>
                                    
                                    <tr>
                                      <td style="text-align: right">
                                        Παρατηρητής Αναμέτρησης(Έξοδα Μετακίνησης):
                                      </td>
                                      <td style="text-align: center; width:50%;">
                                         {{ $match->obs_sal}}€
                                      </td>
                                    </tr>
                                    
                                    <tr>
                                      <td style="text-align: right">
                                        Παρατηρητής Διαιτησίας (αμοιβή + Εξοδ. μετακίνησης):
                                      </td>
                                      <td style="text-align: center; width:50%;">
                                         {{ $match->ref_wa_sal}}€ + {{ $match->ref_wa_mov}}€
                                      </td>
                                    </tr>
                                    <tr>
                                      <td style="text-align: right">
                                        Ιατρός Αναμέτρησης (Έξοδα Μετακίνησης):
                                      </td>
                                      <td style="text-align: center; width:50%;">
                                         {{ $match->doc_sal }}€
                                      </td>
                                    </tr>
                                    <tr>
                                      <td style="text-align: right">
                                        Έξοδα Εκπαίδευσης - Ανάπτυξης Διαιτησίας:
                                      </td>
                                      <td style="text-align: center; width:50%;">
                                        <?php 
                                          if(($match->champ_id==1) || ($match->champ_id==2)){
                                            $ekp=0;
                                          }elseif(($match->champ_id>2) && ($match->champ_id<50)){
                                            $ekp=0;
                                          }else{
                                            $ekp=0;
                                          }
                                        ?>
                                         {{ $ekp }}€
                                      </td>
                                    </tr>
                                   
                                    <tr>
                                      <td style="text-align: right">
                                        Σύνολο:
                                      </td>
                                      <td style="text-align: center; width:50%;">
                                         <?php $syn=round(floatval($match->sum),2)+$ekp; ?>
                                         {{$syn}}
                                      </td>
                                    </tr>
                                  </table>
                                </td>
                              </tr>
                              <tr>
                                <td style="font-size:11px;">
                                  <center>Εισέπραξα το παραπάνω ποσό</center>
                                  <center>Ο διαιτητής</center>
                                  <br/>
                                  <br/>
                                  <center>Υπογραφή Διαιτητή</center>
                                  <br/>
                                </td>
                                <td style="font-size:11px;">
                                  <center>Επιτροπή Διαιτησίας</center>
                                  <center>Αρμόδιος για τον Ορισμό</center>
                                  <br/>
                                  <br/>
                                  <center>Κυριακάκης Στέλιος</center>
                                  <br/>
                                </td>
                              </tr>                          
                            </table>
                        </td>
                      </tr>
                </table>    
           </div>                                                
        </div>
    </div><!--box-->
     @if (config('settings.extraPage'))
        @if ($match->extrapage==1)
          <pagebreak >
            <div class="with-border">
              <div class="page">
                <div id="printable">
                  <table class="table" style="width: 100%">
                    <tr>
                      <td>
                        <center><img src="{{ asset(config('settings.logo')) }}" class="img-responsive" alt=""></center>
                        <br/>
                        <center><h6>Δ/νση: {{ \App\Models\Backend\eps::getAll()->name }}</h6><h6>{{ \App\Models\Backend\eps::getAll()->address }}</h6> <h6>ΤΚ: {{ \App\Models\Backend\eps::getAll()->tk }}- {{ \App\Models\Backend\eps::getAll()->city }}</h6> <h6>τηλ: {{ \App\Models\Backend\eps::getAll()->tel }}</h6><h6>site: {{ \App\Models\Backend\eps::getAll()->site_address }}- email: {{ \App\Models\Backend\eps::getAll()->email }}</h6></center>
                      </td>
                      <td>
                        <center><h6>{{ \App\Models\Backend\eps::getAll()->city }}, {{$match->date}}</h6></center>
                        <center><h6>Αρ. Πρωτ.: {{$match->protokollo}}</h6></center>
                        <br/>
                        <br/>
                        <br/>
                        <br/>
                        <center>ΠΡΟΣ: {{$match->pros}}</center>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2">
                        <br/>
                        <br/>
                        <br/>
                        <br/>
                        <center> <u>Θέμα: {{$match->thema}}</u></center>
                        
                      </td>
                    </tr>
                     <tr>
                      <td colspan="2">
                        <br/>
                        <br/>
                        {{$match->keimeno}}
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2">
                        <br/>
                        <br/>
                        <center>
                          Με αθλητικούς χαιρετισμούς<br/><br/>
                          Για την Ε.Ε.
                        </center>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <center>
                          Ο Πρόεδρος
                        </center>
                        <br/>
                        <br/>
                        <br/>
                        <center>
                          Άρης Κουλούρης
                        </center>
                      </td>
                      <td>
                        <center>
                          Ο Γεν. Γραμματέας
                        </center>
                        <br/>
                        <br/>
                        <br/>
                        <center>
                          Ηλίας Παρασκευόπουλος
                        </center>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2">
                        <br/>
                        <br/>
                        <br/>
                        <center>
                          <span style="font-size: 10px;">{{\App\Models\Backend\eps::getAll()->address }}, ΤΚ {{ \App\Models\Backend\eps::getAll()->tk }}, {{ \App\Models\Backend\eps::getAll()->city }} - T: {{ \App\Models\Backend\eps::getAll()->tel }}- site: {{ \App\Models\Backend\eps::getAll()->site_address }}- email: {{ \App\Models\Backend\eps::getAll()->email }}</span>
                        </center>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2">
                        <center>
                          <hr style="border-top: 5px solid red"/>
                        </center>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2">
                        <center>
                          
                        </center>
                      </td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
        @endif
      @endif  
    @endforeach
</div>
