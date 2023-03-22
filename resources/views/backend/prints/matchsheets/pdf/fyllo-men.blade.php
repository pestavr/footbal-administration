<?php error_reporting(0);  
ini_set("pcre.backtrack_limit","20000000");
?>
{{ Html::style('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css') }}
   <style>
   td{
    font-size: 13px;
   }
 </style>
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
                    <table class="table-bordered" style="width: 100%" >
                        <tr>
                          <td colspan="3">
                            <table class="table-bordered" style="width: 100%">
                              <tr>
                                <td colspan="3" style="vertical-align:top;">
                                  <table class="table" style="width: 100%">
                                    <tr>
                                      <td class="col-md-2">
                                        <center><img src="{{ asset("img/logo/logo.epsa.png") }}" class="img-responsive" alt=""></center>
                                      </td>
                                      <td class="col-md-10" style="vertical-align: top">
                                        <center><h3>ΕΝΩΣΗ ΠΟΔΟΣΦΑΙΡΙΚΩΝ ΣΩΜΑΤΕΙΩΝ ΑΧΑΪΑΣ</h3><h6>Κορίνθου και Βούρβαχη 1, ΤΚ 26221, Πάτρα - τηλ 2610-273634</h6><h6>site: www.epsachaias.gr- email: epsaxaias@yahoo.gr</h6></center>
                                      </td>
                                    </tr>
                                  </table>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                    <h6>{{ $match->season}}</h6>
                                </td>
                                <td>
                                    <center><h3>ΦΥΛΛΟ ΑΓΩΝΑ</h3></center>
                                </td>
                                <td>
                                  <h6>ΚΑΤΗΓΟΡΙΑ: {{ $match->omilos}}</h6> 
                                </td>
                              </tr>
                              <tr>
                                <td colspan="2">
                                  Αγώνας της <b>{{date('d-m-Y', strtotime($match->date_time)) }}</b> στο γήπεδο <b>{{$match->field}}</b> 
                                </td>
                                <td>
                                  Κωδικός: #{{$match->id}}# 
                                </td>
                              </tr>
                                <tr style="line-height: 1.5">
                                  <td colspan="3" style="font-size: 11px">
                                  Ώρα που πρέπει να αρχίσει <b>{{date('H:i', strtotime($match->date_time)) }}</b> Ώρα που άρχισε<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>Διάρκεια Αγώνα:<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u> Ώρα που έληξε: <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></span>
                                  </td>
                                </tr>
                                <tr>
                                  <td colspan="3">
                                  Διαιτητής: {{$match->ref_last_name}} {{$match->ref_firstname}}
                                  </td>
                                </tr>
                                <tr>
                                  <td colspan="3">
                                  Α' Βοηθός Διαιτητή: {{ $match->h1_last_name}} {{$match->h1_firstname}}
                                  </td>
                                </tr>
                                <tr>
                                  <td colspan="2">
                                    Β' Βοηθός Διαιτητή: {{ $match->h2_last_name}} {{$match->h2_firstname}}
                                  </td>
                                  <td>
                                    Αγωνιστική: {{$match->match_day}}η Αγωνιστική
                                  </td>
                                </tr>
                                <tr>
                                  <td colspan="2">
                                    Παρατηρητής:  {{$match->par_last}} {{$match->par_first}}
                                  </td>
                                  <td style="padding-left: 70px">
                                    Υπογραφή:
                                  </td>
                                </tr>
                                <tr>
                                  <td colspan="2">
                                  Γιατρός ή Υπεύθυνος Α' Βοηθειών: {{$match->doc_last}} {{$match->doc_first}}
                                  </td>
                                  <td style="padding-left: 70px">
                                    Υπογραφή:
                                  </td>
                                </tr>
                                <tr>
                                  <td colspan="3">
                                    <center><h4>ΔΙΑΓΩΝΙΖΟΜΕΝΕΣ ΟΜΑΔΕΣ</h4></center>
                                  </td>
                                </tr>
                                <tr>
                                  <td>
                                    <center>Γηπεδούχος</center>
                                  </td>
                                  <td>
                                    <center>-</center>
                                  </td>
                                  <td>
                                    <center>Φιλοξενούμενος</center>
                                  </td>
                                </tr>
                                <tr>
                                  <td>
                                    <center>{{$match->team1}}</center>
                                  </td>
                                  <td>
                                    <center>-</center>
                                  </td>
                                  <td>
                                    <center>{{$match->team2}}</center>
                                  </td>
                                </tr>
                              </tr>
                            </table>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="3">
                            <table class="table-bordered" style="width: 100%">
                              <tr>
                                <td>
                                  <table class="table-bordered" style="width: 100%">
                                    <tr>
                                      <th style="font-size: 07px">
                                        Αριθ. <br/> Φανέλας
                                      </th>
                                      <th >
                                        ΤΑΚΤΙΚΟΙ ΠΟΔΟΣΦΑΙΡΙΣΤΕΣ
                                      </th>
                                      <th style="font-size: 07px">
                                        ΑΡΙΘΜΟΣ ΔΕΛΤΙΟΥ ΕΠΟ
                                      </th>
                                      <th style="font-size: 07px">
                                        ΕΤΟΣ ΓΕΝΝΗΣΗΣ
                                      </th>
                                      <th style="font-size: 07px">
                                        Αριθ. <br/>Φανέλας
                                      </th>
                                      <th >
                                        ΤΑΚΤΙΚΟΙ ΠΟΔΟΣΦΑΙΡΙΣΤΕΣ
                                      </th>
                                      <th style="font-size: 07px">
                                        ΑΡΙΘΜΟΣ ΔΕΛΤΙΟΥ ΕΠΟ
                                      </th>
                                      <th style="font-size: 07px">
                                        ΕΤΟΣ ΓΕΝΝΗΣΗΣ
                                      </th>
                                    </tr>
                                    @for ($i=1;$i<=11;$i++)
                                    <tr style="line-height: 1.4">
                                      <td>
                                        <center>{{ $i }}</center>
                                      </td>
                                      <td>
                                      </td>
                                      <td>
                                      </td>
                                      <td>
                                      </td>
                                      <td>
                                        <center>{{ $i }}</center>
                                      </td>
                                      <td>
                                      </td>
                                      <td>
                                      </td>
                                      <td>
                                      </td>
                                    </tr>
                                    @endfor
                                    <tr style="line-height: 1.4">
                                      <th >
                                       
                                      </th>
                                      <th >
                                        ΑΝΑΠΛΗΡΩΜΑΤΙΚΟΙ ΠΟΔΟΣΦΑΙΡΙΣΤΕΣ
                                      </th>
                                      <th >
                                        
                                      </th>
                                      <th >
                                        
                                      </th>
                                      <th >
                                        
                                      </th>
                                      <th >
                                        ΑΝΑΠΛΗΡΩΜΑΤΙΚΟΙ ΠΟΔΟΣΦΑΙΡΙΣΤΕΣ
                                      </th>
                                      <th >
                                        
                                      </th>
                                      <th >
                                        
                                      </th>
                                    </tr>
                                    @for ($i=12;$i<=20;$i++)
                                    <tr>
                                      <td style="line-height: 1.4">
                                        <center>{{ $i }}</center>
                                      </td>
                                      <td>
                                      </td>
                                      <td>
                                      </td>
                                      <td>
                                      </td>
                                      <td>
                                        <center>{{ $i }}</center>
                                      </td>
                                      <td>
                                      </td>
                                      <td>
                                      </td>
                                      <td>
                                      </td>
                                    </tr>
                                    @endfor
                                  </table>
                                </td>
                               
                              </tr>

                            </table>
                          </td>
                      </tr>
                      <tr>
                        <th colspan="3">
                          <center>ΑΡΙΘΜΟΣ ΦΑΝΕΛΑΣ ΤΟΥ ΑΡΧΗΓΟΥ ΚΑΘΕ ΟΜΑΔΑΣ ΠΡΕΠΕΙ ΝΑ ΣΗΜΕΙΩΘΕΙ ΜΕ ΚΥΚΛΟ</center>
                        </th>
                      </tr>
                      <tr>
                        <td ><center><table class="table-bordered" style="width: 80%"><tr><td style="border: 2px"> &nbsp;<br/>&nbsp;</td></tr></table></center>
                      </td>
                        <td>
                          <center>ΩΡΑ ΠΑΡΑΔΟΣΗΣ ΔΕΛΤΙΩΝ:</center>
                        </td>
                        <td ><center><table class="table-bordered" style="width: 80%"><tr><td style="border: 2px"> &nbsp;<br/>&nbsp;</td></tr></table></td></center>
                      </tr>
                      <tr>
                        <td colspan="3">
                          <table class="table-bordered" style="width: 100%">
                              <tr>
                                <td style="font-size: 07px; border-bottom: none; ">
                                  Για την ακρίβεια της αναγραφής των παραπάνω στοιχείων άρθρο 15 του Κ.Α.Π.
                                </td>
                                <td style="font-size: 07px; border-bottom: none;">
                                  Για την ακρίβεια της αναγραφής των παραπάνω στοιχείων άρθρο 15 του Κ.Α.Π.
                                </td>
                              </tr>
                              <tr>
                                <td style="padding-top: 10px; border-top: none;">
                                  Ο ΑΡΧΗΓΟΣ ΤΗΣ ΓΗΠΕΔΟΥΧΟΥ ΟΜΑΔΑΣ..........................
                                </td>
                                <td style="padding-top: 10px; border-top: none;">
                                  Ο ΑΡΧΗΓΟΣ ΤΗΣ ΦΙΛΟΞΕΝΟΥΜΕΝΗΣ ΟΜΑΔΑΣ..........................
                                </td>
                              </tr>
                          </table>
                        </td>
                      </tr>
                       <tr>
                        <td colspan="3" style="font-size: 10px;">
                          Έγινε έλεγχος των δελτίων ιδίοτητας- υγείας πριν από την έναρξη του αγώνα από τον Διαιτητή και τους αρχηγούς των ομάδων άρθρο 15 & 18 του Κ.Α.Π.. Οι διαπιστώσεις του Διαιτητή και οι παρατηρήσεις των αρχηγών των ομάδων σημειώνονται στη σελίδα 2
                        </td>
                      </tr>
                      <tr>
                          <td colspan="3">
                            <table class="table-bordered" style="width: 100%">
                              <tr>
                                <td>
                                  <table class="table-bordered" style="width: 100%">
                                    <tr>
                                      <th colspan="3">
                                        <center>ΑΠΟΤΕΛΕΣΜΑ ΑΓΩΝΑ</center>
                                      </th>
                                    </tr>
                                    <tr>
                                      <td rowspan="2" style="font-size: 07px;">
                                        <center>
                                        <u>ΠΡΟΣΟΧΗ:</u><br/>
                                        ΣΚΟΡΕΡΣ & ΛΕΠΤΟ ΣΤΗΝ ΤΕΛΕΥΤΑΙΑ ΣΕΛΙΔΑ
                                        </center>
                                      </td>
                                      <td colspan="2">
                                        <center>ΤΕΡΜΑΤΑ</center>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <center>ΓΗΠΕΔΟΥΧΟΣ</center>
                                      </td>
                                      <td>
                                        <center>ΦΙΛΟΞΕΝΟΥΜΕΝΟΣ</center>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        1. ΚΑΝΟΝΙΚΟΣ ΑΓΩΝΑΣ
                                      </td>
                                      <td>
                                      </td>
                                      <td>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        2. ΠΑΡΑΤΑΣΗ
                                      </td>
                                      <td>
                                      </td>
                                      <td>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        3. ΠΕΝΑΛΤΥ
                                      </td>
                                      <td>
                                      </td>
                                      <td>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        4. ΤΕΛΙΚΟ ΑΠΟΤΕΛΕΣΜΑ
                                      </td>
                                      <td>
                                      </td>
                                      <td>
                                      </td>
                                    </tr>
                                </table>
                                </td>
                                <td>
                                  <table class="table  borderless" style="width:100%">
                                    <tr>
                                      <th colspan="2">
                                        <center>ΥΠΟΓΡΑΦΕΣ</center>
                                      </th>
                                    </tr>
                                    <tr>
                                      <td colspan="2">
                                        Ο Διαιτητής: .................................
                                      </td>
                                    </tr>
                                    <tr>
                                      <td colspan="2">
                                        <center>Οι βοηθοί Διαιτητή</center>
                                      </td>
                                    </tr>
                                    <tr>
                                       <td>
                                        Α'
                                       </td>
                                       <td>
                                        Β'
                                       </td>
                                    <tr>
                                      <tr>
                                      <td colspan="2">
                                        <center>Οι Αρχηγοί των Ομάδων</center>
                                      </td>
                                    </tr>
                                    <tr>
                                       <td>
                                         <center>ΓΗΠΕΔΟΥΧΟΥ</center>
                                       </td>
                                       <td>
                                          <center>ΦΙΛΟΞΕΝΟΥΜΕΝΗΣ</center>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td>
                                         <center>.................</center>
                                       </td>
                                       <td>
                                          <center>.................</center>
                                       </td>
                                    </tr>                              
                                </table>
                               </td>
                              </tr>
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
    <div align="center"><b>σελ. 1/4</b></div>
    <pagebreak >
    <div class="with-border">
                <div class="page">
                  <div id="printable">
                    <table class="table-bordered" style="width: 100%" >
                        <tr>
                          <td colspan="3">
                            <table class="table-bordered" style="width: 100%" >
                              <tr>
                                <td>
                                  α)
                                </td>
                                <th colspan="5"> 
                                  ΔΙΑΠΙΣΤΩΣΕΙΣ ΤΟΥ ΔΙΑΙΤΗΤΗ ΑΝΑΦΟΡΙΚΑ ΜΕ ΤΑ ΔΕΛΤΙΑ ΑΘΛ. ΙΔΙΟΤΗΤΑΣ- ΥΓΕΙΑΣ
                                </th>
                              </tr>
                              <tr>
                                <td>
                                  A/A
                                </td>
                                <td>
                                    ΟΝΟΜΑΤΕΠΩΝΥΜΟ
                                </td>
                                <td>
                                    ΠΑΤΡΩΝΥΜΟ
                                </td>
                                <td>
                                    Δ/ΝΣΗ ΚΑΤΟΙΚΙΑΣ
                                </td>
                                <td>
                                    ΕΤΟΣ ΓΕΝΝΗΣΗΣ
                                </td>
                                <td>
                                    ΥΠΟΓΡΑΦΗ
                                </td>
                              </tr>
                              @for ($i=1;$i<=3;$i++)
                                <tr>
                                  <td>
                                    &nbsp;
                                  </td>
                                  <td>
                                  </td>
                                  <td>
                                  </td>
                                  <td>
                                  </td>
                                  <td>
                                  </td>
                                  <td>
                                  </td>
                                </tr>
                              @endfor
                            </table>
                          </td>
                        </tr>
                        <tr>
                          <th colspan="3">
                            β) ΠΑΡΑΤΗΡΗΣΕΙΣ ΤΩΝ ΑΡΧΗΓΩΝ ΤΩΝ ΔΙΑΓΩΝΙΖΟΜΕΝΩΝ ΟΜΑΔΩΝ
                          </th>
                        </tr>
                        @for ($i=1;$i<=5;$i++)
                          <tr>
                            <td colspan="3">
                              &nbsp;
                            </td>
                          </tr>
                        @endfor
                        <tr>
                          <th colspan="3">
                            γ) ΠΑΡΑΤΗΡΗΣΕΙΣ ΤΟΥ ΔΙΑΙΤΗΤΗ ΕΠΙ ΤΩΝ ΕΝΣΤΑΣΕΩΝ (άρθρο 23, παρ. 4 Κ.Α.Π.)
                          </th>
                        </tr>
                        @for ($i=1;$i<=5;$i++)
                          <tr>
                            <td colspan="3">
                              &nbsp;
                            </td>
                          </tr>
                        @endfor
                        <tr>
                          <th colspan="3">
                            ΣΥΝΕΧΕΙΑ ΠΑΡΑΤΗΡΗΣΕΩΝ ΔΙΑΙΤΗΤΗ: (από τη σελ. 4)
                          </th>
                        </tr>
                        @for ($i=1;$i<=20;$i++)
                          <tr>
                            <td colspan="3">
                              &nbsp;
                            </td>
                          </tr>
                        @endfor
                        <tr>
                          <th colspan="3">
                            1. ΑΛΛΑ ΑΠΑΡΑΙΤΗΤΑ ΣΤΟΙΧΕΙΑ ΑΝΑΦΟΡΙΚΑ ΜΕ ΤΙΣ ΕΝΣΤΑΣΕΙΣ ΠΛΑΣΤΟΠΡΟΣΩΠΕΙΑΣ (Άρθρο 23 παρ. 1στ και 2α του Κ.Α.Π.)
                          </th>
                        </tr>
                        @for ($i=1;$i<=5;$i++)
                          <tr>
                            <td colspan="3">
                              &nbsp;
                            </td>
                          </tr>
                        @endfor
                        <tr>
                          <th colspan="3">
                            Βεβαιούται ότι παραδόθηκε έκθεση παρατηρητή η οποία επισυνάπτεται: Ο παρατηρητής
                          </th>
                        </tr>
                        <tr>
                          <td colspan="3">
                            <table class="table" style="width: 100%" >
                              <tr>
                                <td>
                                  Οι αρχηγοί των ομάδων <br/><br/>
                                  ΓΗΠΕΔΟΥΧΟΥ:........................<br/><br/>
                                  ΦΙΛΟΞΕΝΟΥΜΕΝΟΥ:..........................

                                </td>
                                <td>
                                  Ο Διαιτητής<br/><br/>
                                  <br/><br/>
                                  ............................
                                </td>
                                <td>
                                  Οι Βοηθοί Διαιτητή<br/><br/>
                                Α'...........................<br/><br/>
                                Β'...........................
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>
                <div align="center"><b>σελ. 2/4</b></div>
  <pagebreak >
    <div class="with-border">
                <div class="page">
                  <div id="printable">
                    <table class="table-bordered" style="width: 100%" >
                        <tr>
                          <th colspan="3">
                            <center>ΕΝΣΤΑΣΕΙΣ ΠΟΥ ΚΑΤΑΧΩΡΟΥΝΤΑΙ ΣΤΟ ΦΥΛΛΟ ΑΓΩΝΑ</center>
                          </th>
                        </tr>
                        <tr>
                          <td colspan="2" style="width: 75%">
                            <table class="table-bordered" style="width: 100%" >
                              <tr>
                                <td style="font-size: 8px;">
                                  ΕΝΣΤΑΣΕΙΣ ΓΙΑ ΑΝΤΙΚΑΝΟΝΙΚΟΤΗΤΑ ΤΟΥ ΓΗΠΕΔΟΥ (Μη τήρηση των διατάξεων του άρθρου 9 του Κ.Α.Π.)<br/>
                                  ΠΡΟΣΟΧΗ: Υποβάλλεται πριν απο την έναρξη του αγώνα (άρθρο 23 παρ. 1α και 2α του Κ.Α.Π.)
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  Ο Αρχηγός της ομάδας
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  &nbsp;
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  &nbsp;
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  &nbsp;
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  &nbsp;
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  Ο Ενιστάμενος Αρχηγός
                                </td>
                              </tr>
                            </table>
                          </td>
                          <td style="width: 25%">
                            <table class="table-bordered" style="width: 100%" >
                              <tr>
                                <th>
                                  <center>ΕΛΑΒΑΝ ΓΝΩΣΗ</center>
                                </th>
                              </tr>
                              <tr>
                                <td style="font-size: 10px;">
                                  <center>Ο Αρχηγός της αντίπαλης Ομάδας<br/>&nbsp;</center>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <center>Ο Διαιτητής<br/>&nbsp;</center>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <center>Οι Βοηθοί Διαιτητή</center>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  Α'
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  Β'
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="2" style="width: 75%">
                            <table class="table-bordered" style="width: 100%" >
                              <tr>
                                <td style="font-size: 8px;">
                                  ΕΝΣΤΑΣΗ ΠΑΡΑΒΑΣΗ των διατάξεων του άρθρου 12 του Κ.Α.Π. (σχετικά με τον ορισμό διαιτητών ή βοηθών ή την αντικατάσταση των ορισθέντων)<br/>
                                  ΠΡΟΣΟΧΗ: Υποβάλλεται πριν απο την έναρξη του αγώνα (άρθρο 23 παρ. 1α και 2α του Κ.Α.Π.)
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  Ο Αρχηγός της ομάδας
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  &nbsp;
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  &nbsp;
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  &nbsp;
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  &nbsp;
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  Ο Ενιστάμενος Αρχηγός
                                </td>
                              </tr>
                            </table>
                          </td>
                          <td style="width: 25%">
                            <table class="table-bordered" style="width: 100%" >
                              <tr>
                                <th>
                                  <center>ΕΛΑΒΑΝ ΓΝΩΣΗ</center>
                                </th>
                              </tr>
                              <tr>
                                <td style="font-size: 10px;">
                                  <center>Ο Αρχηγός της αντίπαλης Ομάδας<br/>&nbsp;</center>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <center>Ο Διαιτητής<br/>&nbsp;</center>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <center>Οι Βοηθοί Διαιτητή</center>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  Α'
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  Β'
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="2" style="width: 75%">
                            <table class="table-bordered" style="width: 100%" >
                              <tr>
                                <td style="font-size: 8px;">
                                  ΕΝΣΤΑΣΗ ΓΙΑ ΠΛΑΣΤΟΠΡΟΣΩΠΕΙΑ ΠΟΔΟΣΦΑΙΡΙΣΤΗ ΠΡΟΣΟΧΗ: Υποβάλλεται μέχρι την υπογραφή του Φ.Α. και με την προϋπόθεση ότι ο διαιτητής θα έχει ειδοποιηθεί σχετικά- μέσα από τον αγωνιστικό χώρο- από τον αρχηγό της ενιστάμενης ομάδας μέχρι την λήξη της δι'αρκειας του αγώνα και την τυχόν παρατηρήσεώς του(άρθρου 23 παρ. 1στ και 2α του Κ.Α.Π.)<br/>
                                  
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  Ο Αρχηγός της ομάδας
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  &nbsp;
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  &nbsp;
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  &nbsp;
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  &nbsp;
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  Ο Ενιστάμενος Αρχηγός
                                </td>
                              </tr>
                            </table>
                          </td>
                          <td style="width: 25%">
                            <table class="table-bordered" style="width: 100%" >
                              <tr>
                                <th>
                                  <center>ΕΛΑΒΑΝ ΓΝΩΣΗ</center>
                                </th>
                              </tr>
                              <tr>
                                <td style="font-size: 10px;">
                                  <center>Ο Αρχηγός της αντίπαλης Ομάδας<br/>&nbsp;</center>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <center>Ο Διαιτητής<br/>&nbsp;</center>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <center>Οι Βοηθοί Διαιτητή</center>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  Α'
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  Β'
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="2" style="width: 75%">
                            <table class="table-bordered" style="width: 100%" >
                              <tr>
                                <td style="font-size: 8px;">
                                  ΕΝΣΤΑΣΕΙΣ ΑΝΤΙΚΑΝΟΝΙΚΗΣ ΣΥΜΜΕΤΟΧΗΣ που αφορά ποδοσφαιριστή που αγωνίστηκε ως αναπληρωματικός χωρίς να έχει αναγραφεί στο Φ.Α. πριν από την έναρξη του αγώνα και ποδοσφαιριστή που ξανασυμμετείχε σε αγώνα ενώ είχε αντικατασταθεί ή αποβληθεί από αυτόν (άρθρο 23 παρ. 1ε και 2.II του Κ.Α.Π.)
                                 
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  Ο Αρχηγός της ομάδας
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  &nbsp;
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  &nbsp;
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  &nbsp;
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  &nbsp;
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  Ο Ενιστάμενος Αρχηγός
                                </td>
                              </tr>
                            </table>
                          </td>
                          <td style="width: 25%">
                            <table class="table-bordered" style="width: 100%" >
                              <tr>
                                <th>
                                  <center>ΕΛΑΒΑΝ ΓΝΩΣΗ</center>
                                </th>
                              </tr>
                              <tr>
                                <td style="font-size: 10px;">
                                  <center>Ο Αρχηγός της αντίπαλης Ομάδας<br/>&nbsp;</center>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <center>Ο Διαιτητής<br/>&nbsp;</center>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <center>Οι Βοηθοί Διαιτητή</center>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  Α'
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  Β'
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                        <tr>
                          <th colspan="3">
                            <center>ΠΡΟΣΩΠΑ ΠΟΥ ΔΙΚΑΙΟΥΝΤΑΙ ΝΑ ΠΑΡΑΜΕΙΝΟΥΝ ΣΤΟΝ ΑΓΩΝΙΣΤΙΚΟ ΧΩΡΟ (άρθρο 13 παρ. 8 του Κ.Α.Π.)</center>
                          </th>
                        </tr>
                        <tr>
                          <td colspan="3">
                            <table class="table-bordered" style="width: 100%" >
                              <tr>
                                <th>
                                  <center>Α/Α</center>
                                </th>
                                <th>
                                  <center>ΙΔΙΟΤΗΤΑ</center>
                                </th>
                                <th>
                                  <center>ΓΗΠΕΔΟΥΧΟΣ ΟΜΑΔΑ</center>
                                </th>
                                <th>
                                  <center>ΦΙΛΟΞΕΝΟΥΜΕΝΗ ΟΜΑΔΑ</center>
                                </th>
                              </tr>
                              <tr>
                                <th>
                                 1.
                                </th>
                                <th>
                                  Γιατρός κάθε ομάδας<br/>&nbsp;
                                </th>
                                <th>
                                  
                                </th>
                                <th>
                                  
                                </th>
                              </tr>
                              <tr>
                                <th>
                                 2.
                                </th>
                                <th>
                                  Εκπρόσωπος κάθε ομάδας<br/>&nbsp;
                                </th>
                                <th>
                                  
                                </th>
                                <th>
                                  
                                </th>
                              </tr>
                              <tr>
                                <th>
                                 3.
                                </th>
                                <th>
                                  Φυσικοθεραπευτής κάθε ομάδας<br/>&nbsp;
                                </th>
                                <th>
                                  
                                </th>
                                <th>
                                  
                                </th>
                              </tr>
                              <tr>
                                <th>
                                 4.
                                </th>
                                <th>
                                  Προπονητής κάθε ομάδας<br/>&nbsp;
                                </th>
                                <th>
                                  
                                </th>
                                <th>
                                  
                                </th>
                              </tr>
                              <tr>
                                <th>
                                 5.
                                </th>
                                <th>
                                  Βοηθός Προπονητή κάθε ομάδας<br/>&nbsp;
                                </th>
                                <th>
                                  
                                </th>
                                <th>
                                  
                                </th>
                              </tr>
                              <tr>
                                <th>
                                 6.
                                </th>
                                <th>
                                  Τραυματιοφορέας<br/>&nbsp;
                                </th>
                                <th>
                                  
                                </th>
                                <th>
                                  
                                </th>
                              </tr>
                            </table>
                          </td>
                        </tr>
                        <tr>
                          <th colspan="3">
                            <center>ΕΞΑΙΤΙΑΣ ΠΟΙΝΗΣ ΑΠΑΓΟΡΕΥΕΤΑΙ Η ΕΙΣΟΔΟΣ ΣΤΟΝ ΑΓΩΝΙΣΤΙΚΟ ΧΩΡΟ (άρθρο 11,12 Πειθαρχικού Κώδικα)</center>
                          </th>
                        </tr>
                        <tr>
                          <td colspan="3">
                            <table class="table-bordered" style="width: 100%" >
                              <tr>
                                <th>
                                  <center>ΤΗΣ ΓΗΠΕΔΟΥΧΟΥ ΟΜΑΔΑΣ</center>
                                </th>
                                <th>
                                  <center>ΤΗΣ ΦΙΛΟΞΕΝΟΥΜΕΝΗΣ ΟΜΑΔΑΣ</center>
                                </th>
                              </tr>
                              <tr>
                                <td>
                                  &nbsp;<br/>του κ.
                                </td>
                                <td>
                                  &nbsp;<br/>του κ.
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  &nbsp;<br/>του κ.
                                </td>
                                <td>
                                  &nbsp;<br/>του κ.
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>
                <div align="center"><b>σελ. 3/4</b></div>
<pagebreak>
    <div class="with-border">
                <div class="page">
                  <div id="printable">
                    <table class="table-bordered" style="width: 100%" >
                        <tr>
                          <th colspan="3">
                            <center>ΠΟΔΟΣΦΑΙΡΙΣΤΕΣ ΠΟΥ ΑΝΤΙΚΑΤΑΣΤΑΘΗΚΑΝ ΚΑΤΑ ΤΗΝ ΔΙΑΡΚΕΙΑ ΤΟΥ ΑΓΩΝΑ</center>
                          </th>
                        </tr>
                        <tr>
                          <td colspan="3">
                            <table class="table-bordered" style="width: 100%" >
                              <tr>
                                <th colspan="4">
                                  ΤΗΣ ΓΗΠΕΔΟΥΧΟΥ ΟΜΑΔΑΣ
                                </th>
                                <th colspan="4">
                                  ΤΗΣ ΦΙΛΟΞΕΝΟΥΜΕΝΗΣ ΟΜΑΔΑΣ
                                </th>
                              </tr>
                              <tr>
                                <td style="font-size: 8px;">
                                  ΛΕΠΤΟ ΑΓΩΝΑ
                                </td>
                                <th style="font-size: 12px;">
                                  ΟΝΟΜΑΤΕΠΩΝΥΜΟ ΠΟΔΟΣΦΑΙΡΙΣΤΗ
                                </th>
                                <td style="font-size: 7px;">
                                  ΑΡΙΘΜΟΣ ΦΑΝΕΛΑΣ
                                </td>
                                <td style="font-size: 7px;">
                                  ΑΡΙΘΜΟΣ ΔΕΛΤΙΟΥ
                                </td>
                                <td style="font-size: 7px;">
                                  ΛΕΠΤΟ ΑΓΩΝΑ
                                </td>
                                <th style="font-size: 12px;">
                                  ΟΝΟΜΑΤΕΠΩΝΥΜΟ ΠΟΔΟΣΦΑΙΡΙΣΤΗ
                                </th>
                                <td style="font-size: 7px;">
                                  ΑΡΙΘΜΟΣ ΦΑΝΕΛΑΣ
                                </td>
                                <td style="font-size: 7px;">
                                  ΑΡΙΘΜΟΣ ΔΕΛΤΙΟΥ
                                </td>
                              </tr>
                              @for ($i=1; $i<=5;$i++)
                                <tr>
                                  <td></td>
                                  <td style="font-size: 8px;">&nbsp;<br/>{{$i}}. O</td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td style="font-size: 8px;">&nbsp;<br/>{{$i}}. O</td>
                                  <td></td>
                                  <td></td>
                                </tr>
                                <tr>
                                  <td></td>
                                  <td style="font-size: 8px;">&nbsp;<br/>με τον</td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td style="font-size: 8px;">&nbsp;<br/>με τον</td>
                                  <td></td>
                                  <td></td>
                                </tr>
                              @endfor
                            </table>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="3">
                            Λοιπές Παρατηρήσεις Διαιτητή:
                          </td>
                        </tr>
                        <tr>
                          <th colspan="3">
                            <center>ΠΑΡΑΤΗΡΗΘΕΝΤΕΣ ΠΟΔΟΣΦΑΙΡΙΣΤΕΣ (Κίτρινες Κάρτες)</center>
                          </th>
                        </tr>
                        <tr>
                          <td colspan="3">
                             <table class="table-bordered" style="width: 100%" >
                              <tr>
                                <th style="font-size: 7px;">
                                  ΛΕΠΤΟ ΑΓΩΝΑ
                                </th>
                                <th style="font-size: 12px;">
                                  ΟΝΟΜΑΤΕΠΩΝΥΜΟ ΠΟΔΟΣΦΑΙΡΙΣΤΗ
                                </th>
                                <td style="font-size: 7px;">
                                  ΑΡΙΘΜΟΣ ΦΑΝΕΛΑΣ
                                </td>
                                <td style="font-size: 7px;">
                                  ΑΡΙΘΜΟΣ ΔΕΛΤΙΟΥ
                                </td>
                                <td style="font-size: 7px;">
                                  ΟΜΑΔΑ
                                </td>
                                <td style="font-size: 7px;">
                                  ΑΙΤΙΟΛΟΓΙΑ
                                </td>
                                <td style="font-size: 7px;">
                                  ΠΟΙΝΗ
                                </td>
                              </tr>
                              @for ($i=1;$i<=5;$i++)
                              <tr>
                                <td>&nbsp;<br/>&nbsp;</td>
                                <td>&nbsp;<br/>&nbsp;</td>
                                <td>&nbsp;<br/>&nbsp;</td>
                                <td>&nbsp;<br/>&nbsp;</td>
                                <td>&nbsp;<br/>&nbsp;</td>
                                <td>&nbsp;<br/>&nbsp;</td>
                                <td>&nbsp;<br/>&nbsp;</td>
                              </tr>
                              @endfor
                            </table>
                          </td>
                        </tr>
                        <tr>
                          <th colspan="3">
                            <center>ΣΚΟΡΕΡΣ ΑΓΩΝΑ</center>
                          </th>
                        </tr>
                        <tr>
                          <td colspan="3">
                            <table class="table-bordered" style="width: 100%" >
                              <tr>
                                <th colspan="9">
                                  <center>ΓΗΠΕΔΟΥΧΟΣ</center>
                                </th>
                                <th></th>
                                <th colspan="8">
                                  <center>ΦΙΛΟΞΕΝΟΥΜΕΝΗ</center>
                                </th>
                              </tr>
                              <tr>
                                <td style="font-size: 7px; width: 10%" >
                                  ΛΕΠΤΟ ΑΓΩΝΑ
                                </td>
                                <td style="width: 5%">&nbsp;<br/>&nbsp;</td>
                                <td style="width: 5%">&nbsp;<br/>&nbsp;</td>
                                <td style="width: 5%">&nbsp;<br/>&nbsp;</td>
                                <td style="width: 5%">&nbsp;<br/>&nbsp;</td>
                                <td style="width: 5%">&nbsp;<br/>&nbsp;</td>
                                <td style="width: 5%">&nbsp;<br/>&nbsp;</td>
                                <td style="width: 5%">&nbsp;<br/>&nbsp;</td>
                                <td style="width: 5%">&nbsp;<br/>&nbsp;</td>
                                <td style="width: 2%">&nbsp;<br/>&nbsp;</td>
                                <td style="width: 5%">&nbsp;<br/>&nbsp;</td>
                                <td style="width: 5%">&nbsp;<br/>&nbsp;</td>
                                <td style="width: 5%">&nbsp;<br/>&nbsp;</td>
                                <td style="width: 5%">&nbsp;<br/>&nbsp;</td>
                                <td style="width: 5%">&nbsp;<br/>&nbsp;</td>
                                <td style="width: 5%">&nbsp;<br/>&nbsp;</td>
                                <td style="width: 5%">&nbsp;<br/>&nbsp;</td>
                                <td style="width: 5%">&nbsp;<br/>&nbsp;</td>
                              </tr>
                              <tr>
                                <td style="font-size: 7px;">
                                  ΑΡΙΘΜΟΣ ΦΑΝΕΛΑΣ
                                </td>
                                <td>&nbsp;<br/>&nbsp;</td>
                                <td>&nbsp;<br/>&nbsp;</td>
                                <td>&nbsp;<br/>&nbsp;</td>
                                <td>&nbsp;<br/>&nbsp;</td>
                                <td>&nbsp;<br/>&nbsp;</td>
                                <td>&nbsp;<br/>&nbsp;</td>
                                <td>&nbsp;<br/>&nbsp;</td>
                                <td>&nbsp;<br/>&nbsp;</td>
                                <td>&nbsp;<br/>&nbsp;</td>
                                <td>&nbsp;<br/>&nbsp;</td>
                                <td>&nbsp;<br/>&nbsp;</td>
                                <td>&nbsp;<br/>&nbsp;</td>
                                <td>&nbsp;<br/>&nbsp;</td>
                                <td>&nbsp;<br/>&nbsp;</td>
                                <td>&nbsp;<br/>&nbsp;</td>
                                <td>&nbsp;<br/>&nbsp;</td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                        <tr>
                          <th colspan="3">
                            <center>ΠΑΡΑΤΗΡΗΣΕΙΣ ΔΙΑΙΤΗΤΗ</center>
                            
                          </th>
                        </tr>
                        @for ($i=1;$i<=14;$i++)
                        <tr style="line-height: 1.4">
                          <td colspan="3">
                            &nbsp;
                          </td>
                        </tr>
                        @endfor
                        <tr>
                          <td colspan="3" style="font-size: 10px;">
                            (Η άρνηση υπογραφής Φ.Α. από αρχηγό ομάδας επισύρει σε βάρος του ποινή αποκλεισμού μιας αγωνιστικής ημέρας. Άρθρο 10 παρ. 1α περ. ΙΙ του Πειθαρχικού κώδικα)
                          </td>
                        </tr>
                        <tr>
                          <td colspan="3">
                            <table class="table" style="width: 100%" >
                              <tr>
                                <td>
                                  Οι αρχηγοί των ομάδων <br/><br/>
                                  ΓΗΠΕΔΟΥΧΟΥ:........................<br/><br/>
                                  ΦΙΛΟΞΕΝΟΥΜΕΝΟΥ:..........................

                                </td>
                                <td>
                                  Ο Διαιτητής<br/><br/>
                                  <br/><br/>
                                  ............................
                                </td>
                                <td>
                                  Οι Βοηθοί Διαιτητή<br/><br/>
                                Α'...........................<br/><br/>
                                Β'...........................
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>
<div align="center"><b>σελ. 4/4</b></div>

</div>

