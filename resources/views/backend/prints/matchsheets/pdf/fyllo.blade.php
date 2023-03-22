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
                                <td style="vertical-align:top;">
                                  <center><img src="{{ asset("img/logo/logo.epsa.png") }}" class="img-responsive" alt=""></center>
                                </td>
                                <td style="vertical-align: top">
                                  <center><h2>ΕΝΩΣΗ ΠΟΔΟΣΦΑΙΡΙΚΩΝ ΣΩΜΑΤΕΙΩΝ ΑΧΑΪΑΣ</h2><h6>Κορίνθου και Βούρβαχη 1, ΤΚ 26221, Πάτρα - τηλ 2610-273634</h6><h6>site: www.epsachaias.gr- email: epsaxaias@yahoo.gr</h6></center>
                                </td>
                              </tr>
                              <tr>
                                <td colspan="2">
                                    <center><h2>ΦΥΛΛΟ ΑΓΩΝΑ</h3></center>
                                    <center><h3>{{ $match->season}}</h4></center>
                                    <center><h4>Κωδικός: #{{$match->id}}#- {{ $match->omilos}}- {{$match->match_day}}η Αγωνιστική</h5></center>
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
                                        <tr>
                                          <td>Ιατρός</td>
                                          <td class="font-weight-bold">{{$match->doc_last}} {{$match->doc_first}}</td>
                                          <td>Παρατηρητής</td>
                                          <td class="font-weight-bold">{{$match->par_last}} {{$match->par_first}}</td>
                                        </tr>
                                  </table>
                                </td>
                              </tr>
                            </table>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <table class="table" style="width:100%">
                            <tr>
                              <td width="350" align="center">Γηπεδούχος</td>
                              <td align="center" width="100">-</td>
                              <td width="350" align="center">Φιλοξενούμενος</td>
                            </tr>
                            <tr>
                              <td width="350" align="center" >{{$match->team1}}</td>
                              <td align="center" width="10">-</td>
                              <td width="350" align="center">{{$match->team2}}</td>
                            </tr>
                            <tr>
                              <td style="vertical-align: top">
                                  <table class="table-bordered" style="width:100%">
                                    <tr><th>Όνοματεπώνυμο</th><th>Αρ. Δελτίου</th><th>Φαν.</th><th>Γκολ</th><th></th></tr>
                                    @foreach ($team1 as $player1)
                                        <tr>
                                          <td>
                                          {{$player1->Surname}} {{$player1->Name}}, {{$player1->BirthYear}}
                                          </td>
                                          <td>{{$player1->player_id}}</td>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                        </tr>
                                    @endforeach
                                    <tr><td>Προπονητής</td><td colspan="4"></td></tr>
                                    <tr><td>Εκπρόσωπος</td><td colspan="4"></td></tr>
                                  </table>    
                                </td>
                                <td></td>
                                <td style="vertical-align: top">
                                  <table class="table-bordered" style="width:100%">
                                    <tr><th>Όνοματεπώνυμο</th><th>Αρ. Δελτίου</th><th>Φαν.</th><th>Γκολ</th><th></th></tr>
                                    @foreach ($team2 as $player2)
                                        <tr>
                                          <td>
                                            {{$player2->Surname}} {{$player2->Name}}, {{$player2->BirthYear}}
                                          </td>
                                          <td>{{$player2->player_id}}</td>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                        </tr>
                                    @endforeach
                                    <tr><td>Προπονητής</td><td colspan="4"></td></tr>
                                    <tr><td>Εκπρόσωπος</td><td colspan="4"></td></tr>
                                  </table> 
                                </td>
                              </tr>
                              <tr>
                                <td colspan="3">
                                  <center><h4>Αποτέλεσμα</h4></center>
                                  <center>
                                    <table class="table-bordered" style="width: 80%">
                                    <tr>
                                      <td><center><h5>{{$match->team1}}</h5></center></td>
                                      <td></td>
                                      <td><center><h5>{{$match->team2}}</h5></center></td>
                                    </tr>
                                    <tr>
                                      <td></td>
                                      <td><center>Κανονικός Αγώνας</center></td>
                                      <td></td>
                                    </tr>
                                    <tr>
                                      <td></td>
                                      <td><center>Παράταση</center></td>
                                      <td></td>
                                    </tr>
                                    <tr>
                                      <td></td>
                                      <td><center>Πέναλτυ</center></td>
                                      <td></td>
                                    </tr>
                                    <tr>
                                      <td></td>
                                      <td><center>Σκορ</center></td>
                                      <td></td>
                                    </tr>
                                  </table> 
                                </center>
                                </td>
                              </tr>
                              <tr>
                                <td colspan="3">
                                  <center><h4>Ενστάσεις</h4></center>
                                  <table class="table" style="width: 100%">
                                    <tr><td style="border-bottom: dotted;">&nbsp;</td></tr>
                                    <tr><td style="border-bottom: dotted;">&nbsp;</td></tr>
                                    <tr><td style="border-bottom: dotted;">&nbsp;</td></tr>
                                  </table>
                                </td>
                              </tr>
                          
                        
                        <tr>  
                          <td colspan="3">
                            <table class="table-bordered" style="width:100%">
                              <tr><td colspan="2" width="380">Ο Διαιτητής</td><td colspan="2" width="380">Οι αρχηγοί των ομάδων</td></tr>
                              <tr height="40"><td colspan="8"><br/><br/><br/><br/></td></tr>
                              <tr><td colspan="2" style="font-size:11px;">(υπογραφή διαιτητή)</td><td style="font-size:11px;">(γηπεδούχος)</td><td style="font-size:11px;">(φιλοξενούμενος)</td></tr>
                              <tr height="10"></tr>
                              
                            </table>
                          </td>
                        </tr>
                </table>    
                </table>     
           </div>                            
                        

                      
                    
            </div>
    </div><!--box-->
    @endforeach
</div>
