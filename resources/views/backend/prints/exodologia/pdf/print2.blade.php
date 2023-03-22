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
                                    <center><h2>ΦΥΛΛΟ ΑΓΩΝΑ</h3></center>
                                      <br/>
                                      <center><h4>Κωδικός Αναμέτρησης: #{{$match->match_id}}#</h4></center>
                                      <center><h5>{{$match->season}}</h5></center>
                                      <center><h5>{{$match->omilos}}- {{$match->match_day}}η Αγωνιστική</h5></center>
                                      <br/>
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
                                <td>
                                   <br/>&nbsp;
                                   <br/>&nbsp;
                                   <br/>
                                   <center>(αριθμητικώς και ολογράφως)</center>
                                </td>
                                <td>
                                   <br/>&nbsp;
                                   <br/>&nbsp;
                                   <br/>
                                   <center>(αριθμητικώς και ολογράφως)</center>
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
                                          <td colspan="3">
                                              Ώρα έναρξης:
                                              <br/>&nbsp;<br/>&nbsp;
                                              Καθυστερήσεις Α' Ημιχρόνου:
                                          </td>
                                          <td colspan="3">
                                              Ώρα λήξης:
                                              <br/>&nbsp;<br/>&nbsp;
                                              Καθυστερήσεις Β' Ημιχρόνου:
                                          </td>
                                        </tr>
                                        <tr>
                                          <td colspan="6">
                                              <center>(αναφέρετε την ακριβή ώρα έναρξης και λήξης της αναμέτρησης καθώς και τις καθυστερήσεις)</center><br/>&nbsp;
                                          </td>
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
                                          <td>Α' Βοηθειών: <br/>&nbsp;</td>
                                          <td class="font-weight-bold">{{ $match->doc_last}} {{$match->doc_first}}<br/>&nbsp;</td>
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
                                        <b><u>Εξοδολόγιο Αναμέτρησης </u></b>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td style="text-align: right; width:50%;">
                                        Διαιτητής (αμοιβή + ημεραργία):
                                      </td>
                                      <td style="text-align: center; width:50%;">
                                         {{ $match->ref_sal}}€ + {{ $match->ref_daily }} = {{floatval($match->ref_sal)+ floatval($match->ref_daily)}}
                                     
                                      </td>
                                    </tr>
                                    <tr>
                                      <td style="text-align: right;width:50%;">
                                        Α και Β Βοηθός (αμοιβή + ημεραργία) x 2:
                                      </td>
                                      <td style="text-align: center; width:50%;">
                                         ({{ round(floatval($match->hel_sal)/2,2) }}€ + {{ round(floatval($match->hel_daily)/2,2) }}) x 2 = {{ floatval($match->hel_sal)+ floatval($match->hel_daily) }}
                                        
                                      </td>
                                    </tr>
                                    @if ($match->hel_mov!='0')
                                    <tr>
                                      <td style="text-align: right">
                                        Α και Β Βοηθός (Μετακίνηση):
                                      </td>
                                      <td style="text-align: center; width:50%;">
                                         {{ $match->hel_mov}}€
                                      </td>
                                    </tr>
                                    @endif
                                    <tr>
                                      <td style="text-align: right">
                                        Αποζημίωση για την Μετακίνηση:
                                      </td>
                                      <td style="text-align: center; width:50%;">
                                         {{ $match->ref_mov}}€
                                      </td>
                                    </tr>
                                    @if ($match->toll!='0')
                                    <tr>
                                      <td style="text-align: right">
                                        Διόδια:
                                      </td>
                                      <td style="text-align: center; width:50%;">
                                         {{ $match->toll}}€
                                      </td>
                                    </tr>
                                    @endif
                                    @if(config('settings.exodologioRefObserver'))
                                    <tr>
                                      <td style="text-align: right">
                                        Παρατηρητής Διαιτησίας:
                                      </td>
                                      <td style="text-align: center; width:50%;">
                                         {{ $match->ref_wa_sal }}€
                                      </td>
                                    </tr>
                                    @endif
                                    <tr>
                                      <td style="text-align: right">
                                        Σύνολο:
                                      </td>
                                      <td style="text-align: center; width:50%;">
                                         {{$match->sum}}
                                      </td>
                                    </tr>
                                  </table>
                                </td>
                              </tr>
                              <tr>
                                <td colspan="2" style="font-size:11px;">
                                  <center>Έλαβα αυτό το ποσό</center>
                                  <br/>
                                  <br/>
                                  <center>Υπογραφή Διαιτητή</center>
                                  <br/>
                                </td>
                              </tr>
                              <tr>  
                                <td colspan="2">
                                  <table class="table" style="width:100%">
                                    <tr><td colspan="2" width="380"><center>Ο Διαιτητής</center></td>
                                        <td colspan="2" width="380"><center>Οι Αρχηγοί των Ομάδων</center></td>
                                    </tr>
                                    <tr height="40">
                                      <td colspan="4"><br/><br/></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" style="font-size:11px;"><center>(υπογραφή διαιτητή)</center></td>
                                      <td style="font-size:11px;"><center>(γηπεδούχος)</center></td>
                                      <td style="font-size:11px;"><center>(φιλοξενούμενος)</center></td>
                                    </tr>
                                    <tr height="10"></tr>
                                  </table>
                                </td>
                              </tr>
                              <tr>  
                                <td colspan="2">
                                  <table class="table" style="width:100%">
                                    <tr>
                                      <td colspan="2" width="380"><center>Οι Βοηθοί</center></td>
                                      <td width="190"><center>Παρατηρητής</center></td>
                                      <td width="190"><center>Υπ. Α' Βοηθειών</center></td>
                                    </tr>
                                    <tr height="40">
                                      <td colspan="4"><br/><br/></td>
                                    </tr>
                                    <tr>
                                      <td style="font-size:11px;"><center>(υπογραφή Α Βοηθού)</center></td>
                                      <td style="font-size:11px;"><center>(υπογραφή Β Βοηθού)</center></td>
                                      <td style="font-size:11px;"><center>(υπογραφή)</center></td>
                                      <td style="font-size:11px;"><center>(υπογραφή)</center></td>
                                    </tr>
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
    </div><!--box-->
    @endforeach
</div>
