{{ Html::style('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css') }}
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
                                    <center><h2>ΕΠΙΤΡΟΠΗ ΔΙΑΙΤΗΣΙΑΣ</h3></center>
                                      <br/>
                                      <center><h4>Κωδικός Αναμέτρησης: #{{$match->match_id}}#</h4></center>
                                      <br/>
                                </td>
                              </tr>
                              <tr>
                                <td colspan="2">
                                  <br/>&nbsp;<br/>&nbsp;<br/>
                                  Σας γνωρίζουμε ότι ορισθήκατε διαιτητής στην παρακάτω αναμέτρηση:
                                  <br/>&nbsp;
                                </td>
                              </tr>
                              <tr>
                                <td colspan="2">
                                  <center><h4>{{ $match->season}}</h4></center>
                                </td>
                              </tr>
                              <tr>
                                <td colspan="2">
                                  <center><h4>{{ $match->omilos}}- {{$match->match_day}}η Αγωνιστική</h4></center>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <br/>&nbsp;
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
                                  <br/>&nbsp;
                                </td>
                              </tr>
                              <tr>
                                <td colspan="2" >
                                  <table class="table" style="width:100%">
                                        <tr>
                                          <td >Ημερομηνία</td>
                                          <td class="font-weight-bold">{{date('d-m-Y', strtotime($match->date_time)) }}</td>
                                          <td>Ώρα</td>
                                          <td class="font-weight-bold">{{date('H:i', strtotime($match->date_time))}}</td>
                                        </tr>
                                        <tr>  
                                          <td>Γήπεδο</td>
                                          <td class="font-weight-bold">{{$match->field}}</td>                       
                                          <td>Διαιτητής</td>
                                          <td class="font-weight-bold">{{$match->ref_last_name}} {{$match->ref_firstname}}</td>
                                        </tr>
                                        <tr>
                                          <td>1ος Βοηθός</td>
                                          <td class="font-weight-bold">{{ $match->h1_last_name}} {{$match->h1_firstname}}</td>
                                          <td>2ος Βοηθός</td>
                                          <td class="font-weight-bold">{{$match->h2_last_name}} {{$match->h2_firstname}}</td>
                                        </tr>
                                  </table>
                                </td>
                              </tr>
                              <tr>
                                <td colspan="2" >
                                  <table class="table" style="width:100%">
                                    <tr>
                                      <td colspan="2">
                                        <b><u>Αποζημίωση Διαιτησίας και Μετάκινησης </u></b>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td style="text-align: right; width:50%;">
                                        Διαιτητής (αμοιβή):
                                      </td>
                                      <td style="text-align: center; width:50%;">
                                        @if($match->champ_id==config('default.cup'))
                                          {{ round(floatval($match->ref_sal)/2,2)}}€
                                        @else
                                         {{ $match->ref_sal }}€
                                        @endif
                                      </td>
                                    </tr>
                                    <tr>
                                      <td style="text-align: right;width:50%;">
                                        Α και Β Βοηθός (αμοιβή):
                                      </td>
                                      <td style="text-align: center; width:50%;">
                                        @if($match->champ_id==config('default.cup'))
                                          {{ round(floatval($match->hel_sal)/2,2)}}€
                                        @else
                                         {{ $match->hel_sal }}€
                                        @endif
                                      </td>
                                    </tr>
                                    @if ($match->hel_mov!='0')
                                    <tr>
                                      <td style="text-align: right">
                                        Α και Β Βοηθός (Μετακίνηση):
                                      </td>
                                      <td style="text-align: center; width:50%;">
                                        @if($match->champ_id==config('default.cup'))
                                          {{ round(floatval($match->hel_mov)/2,2)}}€
                                        @else
                                         {{ $match->hel_mov }}€
                                        @endif
                                      </td>
                                    </tr>
                                    @endif
                                    <tr>
                                      <td style="text-align: right">
                                        Αποζημίωση για την Μετακίνηση:
                                      </td>
                                      <td style="text-align: center; width:50%;">
                                        @if($match->champ_id==config('default.cup'))
                                          {{ round(floatval($match->ref_mov)/2,2)}}€
                                        @else
                                         {{ $match->ref_mov }}€
                                        @endif
                                      </td>
                                    </tr>
                                    <tr>
                                      <td style="text-align: right">
                                        Διόδια:
                                      </td>
                                      <td style="text-align: center; width:50%;">
                                        @if($match->champ_id==config('default.cup'))
                                          {{ round(floatval($match->toll)/2,2)}}€
                                        @else
                                         {{ $match->toll }}€
                                        @endif
                                      </td>
                                    </tr>
                                    <tr>
                                      <td style="text-align: right">
                                        Παρατηρητής Διαιτησίας:
                                      </td>
                                      <td style="text-align: center; width:50%;">
                                         @if($match->champ_id==config('default.cup'))
                                          {{ round(floatval($match->ref_wa_sal)/2,2)}}€
                                        @else
                                         {{ $match->ref_wa_sal }}€
                                        @endif
                                      </td>
                                    </tr>
                                    <tr>
                                      <td style="text-align: right">
                                        Παρατηρητής:
                                      </td>
                                      <td style="text-align: center; width:50%;">
                                         @if($match->champ_id==config('default.cup'))
                                          {{ round(floatval($match->obs_sal)/2,2)}}€
                                        @else
                                         {{ $match->obs_sal }}€
                                        @endif
                                      </td>
                                    </tr>
                                     <tr>
                                      <td style="text-align: right">
                                        Έξοδα Διοργάνωσης Αγώνων:
                                      </td>
                                      <td style="text-align: center; width:50%;">
                                        <?php 
                                          if(($match->champ_id==1) || ($match->champ_id==2)){
                                            $ekp=10;
                                          }elseif(($match->champ_id==3)){
                                            $ekp=8;
                                          }elseif(($match->champ_id==4)){
                                            $ekp=6.5;
                                          }else{
                                            if ($team1_champ==4 || $team2_champ==4){
                                              $ekp=6.5;
                                            }elseif($team1_champ==3 || $team2_champ==3){
                                              $ekp=8;
                                            }else{
                                              $ekp=10;
                                            }
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
                                        <?php $sum=round(floatval($match->sum),2)+$ekp?>
                                         @if($match->champ_id==config('default.cup'))
                                          {{ round($sum/2,2)}}€
                                        @else
                                         {{ $sum }}€
                                        @endif
                                      </td>
                                    </tr>
                                  </table>
                                </td>
                              </tr>
                              <tr>
                                <td colspan="2">
                                  Παρατηρησεις: {{ $match->comments}}
                                </td>
                              </tr>
                              <tr>
                                <td colspan="2">
                                  <center>ΠΑΤΡΑ</center>
                                  <br/>
                                  <center>ΓΙΑ ΤΗΝ Ε.Δ.Δ.</center>
                                  <br/>
                                  <center>ΕΙΣΠΡΑΞΑΜΕ ΤΟ ΠΑΡΑΠΑΝΩ ΠΟΣΟ</center>
                                  <br/>
                                </td>
                              </tr>
                              <tr>  
                                <td colspan="2">
                                  <table class="table" style="width:100%">
                                    <tr><td colspan="2" width="380"><center>Ο Διαιτητής</center></td><td colspan="2" width="380"><center>Οι Βοηθοί</center></td></tr>
                                    <tr height="40"><td colspan="8"><br/><br/><br/><br/></td></tr>
                                    <tr><td colspan="2" style="font-size:11px;">(υπογραφή διαιτητή)</td><td style="font-size:11px;">(υπογραφή Α Βοηθού)</td><td style="font-size:11px;">(υπογραφή Β Βοηθού)</td></tr>
                                    <tr height="10"></tr>
                                    
                                  </table>
                                </td>
                              </tr>
                            </table>
                        </td>
                      </tr>
                                         
                        
                        
                </table>    
                   
           </div>                                                
        </div>
        <!--<pagebreak >
                        <div class="page">
                  <div id="printable">
                    <table class="table" style="width: 100%" >
                        <tr>
                          <td>
                            <table class="table" style="width: 100%">
                              <tr>
                                <td style="vertical-align:top;">
                                  <center><img src="{{ asset("img/logo/logo.epsa.png") }}" class="img-responsive" alt=""></center>
                                </td>
                                <td style="vertical-align: top">
                                  <center><h2>ΕΝΩΣΗ ΠΟΔΟΣΦΑΙΡΙΚΩΝ ΣΩΜΑΤΕΙΩΝ ΑΧΑΪΑΣ</h2><h6>Κορίνθου και Βούρβαχη 1, ΤΚ 26221, Πάτρα - τηλ 2610-273634</h6><h6>site: www.epsachaias.gr- email: epsaxaias@yahoo.gr</h6></center>
                                </td>
                              </tr>
                              <tr>
                                <td colspan="2">
                                    <center><h2>ΕΠΙΤΡΟΠΗ ΔΙΑΙΤΗΣΙΑΣ</h3></center>
                                      <br/>
                                      <center><h4>Κωδικός Αναμέτρησης: #{{$match->match_id}}#</h4></center>
                                      <br/>
                                </td>
                              </tr>
                              <tr>
                                <td colspan="2">
                                  <?php $pos= 1+((floatval($match->ref_sal)+floatval($match->hel_sal))/10); ?>
                                    <center><h2>ΑΠΟΔΕΙΞΗ ΕΙΣΠΡΑΞΗΣ ΕΥΡΩ: <span style="font-size:30px;letter-spacing:normal;background:#AAA">{{ $pos }}</span></h3></center>
                                      <br/>
                                     
                                </td>
                              </tr>
                              <tr>
                                <td colspan="2">
                                  <br/>&nbsp;<br/>&nbsp;<br/>
                                  Ο Κάτωθι υπογεγραμμένος ταμίας της Ε.Π.Σ. Αχαΐας έλαβα από τον διαιτητή <strong>{{$match->ref_last_name}} {{$match->ref_firstname}}</strong> το ποσό:
                                
                                </td>
                              </tr>
                              <tr>
                                <td colspan="2">
                        
                                  <center><h2><span style="font-size:30px;letter-spacing:normal;background:#AAA">{{ $pos }}€</span></h3></center>
                        
                                </td>
                              </tr>
                              <tr>
                                <td colspan="2">
                                  για ποσοστό της αναμέτρησης <strong>{{$match->team1}}- {{$match->team2}}</strong>
                                </td>
                              </tr>
                              <tr>
                                <td colspan="2">
                                  της κατηγορίας <strong>{{ $match->omilos}}</strong> που διεξήχθει στις <strong>{{date('d-m-Y', strtotime($match->date_time)) }}</strong>
                                   <br/>&nbsp;<br/>&nbsp;<br/>
                                </td>
                              </tr>
                              
                              <tr>
                                <td colspan="2">
                                  <center>ΠΑΤΡΑ, {{date('d-m-Y', strtotime($match->date_time)) }}</center>
                                  <br/>
                                  <br/>
                                  <center>Ο ταμίας της Ε.Π.Σ. Αχαΐας</center>
                                  <br/>
                                </td>
                              </tr>
                            </table>
                        </td>
                      </tr>
                       <tr>
                          <td>
                            <table class="table" style="width: 100%">
                              <tr>
                                <td style="vertical-align:top;">
                                  <center><img src="{{ asset("img/logo/logo.epsa.png") }}" class="img-responsive" alt=""></center>
                                </td>
                                <td style="vertical-align: top">
                                  <center><h2>ΕΝΩΣΗ ΠΟΔΟΣΦΑΙΡΙΚΩΝ ΣΩΜΑΤΕΙΩΝ ΑΧΑΪΑΣ</h2><h6>Κορίνθου και Βούρβαχη 1, ΤΚ 26221, Πάτρα - τηλ 2610-273634</h6><h6>site: www.epsachaias.gr- email: epsaxaias@yahoo.gr</h6></center>
                                </td>
                              </tr>
                              <tr>
                                <td colspan="2">
                                    <center><h2>ΕΠΙΤΡΟΠΗ ΔΙΑΙΤΗΣΙΑΣ</h3></center>
                                      <br/>
                                      <center><h4>Κωδικός Αναμέτρησης: #{{$match->match_id}}#</h4></center>
                                      <br/>
                                </td>
                              </tr>
                              <tr>
                                <td colspan="2">
                                  <?php $pos= 1+((floatval($match->ref_sal)+floatval($match->hel_sal))/10); ?>
                                    <center><h2>ΑΠΟΔΕΙΞΗ ΕΙΣΠΡΑΞΗΣ ΕΥΡΩ: <span style="font-size:30px;letter-spacing:normal;background:#AAA">{{ $pos }}</span></h3></center>
                                      <br/>
                                     
                                </td>
                              </tr>
                              <tr>
                                <td colspan="2">
                                  <br/>&nbsp;<br/>&nbsp;<br/>
                                  Ο Κάτωθι υπογεγραμμένος ταμίας της Ε.Π.Σ. Αχαΐας έλαβα από τον διαιτητή <strong>{{$match->ref_last_name}} {{$match->ref_firstname}}</strong> το ποσό:
                                
                                </td>
                              </tr>
                              <tr>
                                <td colspan="2">
                        
                                  <center><h2><span style="font-size:30px;letter-spacing:normal;background:#AAA">{{ $pos }}€</span></h3></center>
                        
                                </td>
                              </tr>
                              <tr>
                                <td colspan="2">
                                  για ποσοστό της αναμέτρησης <strong>{{$match->team1}}- {{$match->team2}}</strong>
                                </td>
                              </tr>
                              <tr>
                                <td colspan="2">
                                  της κατηγορίας <strong>{{ $match->omilos}}</strong> που διεξήχθει στις <strong>{{date('d-m-Y', strtotime($match->date_time)) }}</strong>
                                   <br/>&nbsp;<br/>&nbsp;<br/>
                                </td>
                              </tr>
                              
                              <tr>
                                <td colspan="2">
                                  <center>ΠΑΤΡΑ, {{date('d-m-Y', strtotime($match->date_time)) }}</center>
                                  <br/>
                                  <br/>
                                  <center>Ο ταμίας της Ε.Π.Σ. Αχαΐας</center>
                                  <br/>
                                </td>
                              </tr>
                            </table>
                        </td>
                      </tr>                  
                        
                        
                </table>    
                   
           </div>                                                
        </div> -->
    </div><!--box-->
    @endforeach
</div>
