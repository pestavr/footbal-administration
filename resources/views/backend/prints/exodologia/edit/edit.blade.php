@extends('backend.layouts.app')

@section('page-header')
    <h1>
        {{ app_name() }}
        <small>Εκτυπώσεις</small>
    </h1>
@endsection

@section('after-styles')

@endsection

@section('content')
  @foreach ($match as $m)
        <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Επεξεργασία Εξοδολογίου της Αναμέτρησης {{ $m->team1 }} - {{ $m->team2 }}</h3>

            <div class="box-tools pull-right">
                Κατηγορία: <strong>{{ $m->omilos}}</strong> Ημερομηνία: <strong>{{ Carbon\Carbon::parse($m->date_time)->format('d-m-Y H:i') }}</strong> Γήπεδο: <strong>{{ $m->field}}</strong>
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->
        @foreach ($exod as $ex)
          
                <div class="box-body">
                    <div class="with-border">
                        <form method="POST" action="{{ route('admin.prints.exodologia.update_ex', $ex->id) }}">
                            {{ csrf_field() }}
                              <div class="form-group">
                                <label for="ref_sal">Αμοιβή Διαιτητή</label>
                                <input type="text" class="form-control" id="ref_sal" name="ref_sal" aria-describedby="Herbhelp" value="{{ $ex->ref_sal }}">
                                <small class="form-text text-muted">Διαιτητής: {{ $m->ref_last_name}} {{ $m->ref_firstname}}</small>
                              </div>
                              @if(config('settings.imergargiaReferee'))
                              <div class="form-group">
                                <label for="ref_sal">Ημεραργία Διαιτητή</label>
                                <input type="text" class="form-control" id="ref_daily" name="ref_daily" aria-describedby="Herbhelp" value="{{ $ex->ref_daily }}">
                                <small class="form-text text-muted">Διαιτητής: {{ $m->ref_last_name}} {{ $m->ref_firstname}}</small>
                              </div>
                              @endif
                              <div class="form-group">
                                <label for="ref_mov">Αποζημίωση Μετακίνησης Διαιτητή</label>
                                <input type="text" class="form-control" id="ref_mov" name="ref_mov" aria-describedby="Herbhelp" value="{{ $ex->ref_mov }}">
                                <small class="form-text text-muted">Διαιτητής: {{ $m->ref_last_name}} {{ $m->ref_firstname}}</small>
                              </div>
                              <div class="form-group">
                                <label for="hel_sal">Αμοιβή Βοηθών</label>
                                <input type="text" class="form-control" id="hel_sal" name="hel_sal" aria-describedby="Herbhelp" value="{{ $ex->hel_sal }}">
                                <small class="form-text text-muted">Βοηθοί: {{ $m->h1_last_name}} {{ $m->h1_firstname}} - {{ $m->h2_last_name}} {{ $m->h2_firstname}}</small>
                              </div>
                              @if(config('settings.distanceHelper'))
                              <div class="form-group">
                                <label for="hel_mov">Αποζημίωση Μετακίνησης Βοηθών</label>
                                <input type="text" class="form-control" id="hel_mov" name="hel_mov" aria-describedby="Herbhelp" value="{{ $ex->hel_mov }}">
                                <small class="form-text text-muted">Βοηθοί: {{ $m->h1_last_name}} {{ $m->h1_firstname}} - {{ $m->h2_last_name}} {{ $m->h2_firstname}}</small>
                              </div>
                              @endif
                              @if(config('settings.imergargiaHelpers'))
                              <div class="form-group">
                                <label for="ref_sal">Ημεραργία Βοηθών</label>
                                <input type="text" class="form-control" id="hel_daily" name="hel_daily" aria-describedby="Herbhelp" value="{{ $ex->hel_daily }}">
                                <small class="form-text text-muted">Διαιτητής: {{ $m->ref_last_name}} {{ $m->ref_firstname}}</small>
                              </div>
                              @endif
                              
                              @if(config('settings.toll'))
                              <div class="form-group">
                                <label for="toll">Διόδια</label>
                                <input type="text" class="form-control" id="toll" name="toll" aria-describedby="Herbhelp" value="{{ $ex->toll }}">
                                
                              </div>
                              @endif
                              @if(config('settings.exodologioRefObserver'))
                              <div class="form-group">
                                <label for="ref_par">Αμοιβή Παρατηρητή Διαιτησίας</label>
                                <input type="text" class="form-control" id="ref_wa_sal" name="ref_wa_sal" aria-describedby="Herbhelp" value="{{ $ex->ref_wa_sal }}">
                                <small class="form-text text-muted">Παρατηρητής Διαιτησίας: {{ $m->ref_par_last_name}} {{ $m->ref_par_first_name}}</small>
                              </div>
                              @endif
                              @if(config('settings.distanceRefObserver'))
                              <div class="form-group">
                                <label for="ref_par">Αποζημίωση Μετακίνησης Παρατηρητή Διαιτησίας</label>
                                <input type="text" class="form-control" id="ref_wa_mov" name="ref_wa_mov" aria-describedby="Herbhelp" value="{{ $ex->ref_wa_mov }}">
                                <small class="form-text text-muted">Παρατηρητής Διαιτησίας: {{ $m->ref_par_last_name}} {{ $m->ref_par_first_name}}</small>
                              </div>
                              @endif
                              @if(config('settings.exodologioObserver'))
                              <div class="form-group">
                                <label for="ref_par">Αμοιβή Παρατηρητή</label>
                                <input type="text" class="form-control" id="obs_sal" name="obs_sal" aria-describedby="Herbhelp" value="{{ $ex->obs_sal }}">
                                <small class="form-text text-muted">Παρατηρητής: {{ $m->par_last_name}} {{ $m->par_first_name}}</small>
                              </div>
                              @endif
                              @if(config('settings.distanceObserver'))
                              <div class="form-group">
                                <label for="ref_par">Αποζημίωση Μετακίνησης Παρατηρητή</label>
                                <input type="text" class="form-control" id="obs_mov" name="obs_mov" aria-describedby="Herbhelp" value="{{ $ex->obs_mov }}">
                                <small class="form-text text-muted">Παρατηρητής: {{ $m->par_last_name}} {{ $m->par_first_name}}</small>
                              </div>
                              @endif
                              @if(config('settings.exodologioDoctor'))
                              <div class="form-group">
                                <label for="ref_par">Αμοιβή Υγειονομικού Προσωπικού</label>
                                <input type="text" class="form-control" id="doc_sal" name="doc_sal" aria-describedby="Herbhelp" value="{{ $ex->doc_sal }}">
                                <small class="form-text text-muted">Υγειονομικό Προσωπικό: {{ $m->ref_par_last_name}} {{ $m->ref_par_first_name}}</small>
                              </div>
                              @endif
                              @if(config('settings.distanceDoctor'))
                              <div class="form-group">
                                <label for="ref_par">Αποζημίωση Μετακίνησης Υγειονομικού Προσωπικού</label>
                                <input type="text" class="form-control" id="doc_mov" name="doc_mov" aria-describedby="Herbhelp" value="{{ $ex->doc_mov }}">
                                <small class="form-text text-muted">Υγειονομικό Προσωπικό: {{ $m->doc_last_name}} {{ $m->doc_first_name}}</small>
                              </div>
                              @endif
                              <div class="form-group">
                                <label for="tk">Παρατηρήσεις</label>
                                <textarea name="comments" class="form-control" rows="3">{{ $ex->comments}}</textarea>
                              </div>
                              <?php
                                if ($ex->extrapage==1){
                                    $extraPage='checked="checked"'; 
                                    $extraPageDiv='';
                                  }else{
                                    $extraPage='';
                                    $extraPageDiv='display:none';
                                  }
                              ?>
                              <div class="form-group">
                                <label for="tk">Ειδοποιητήριο προς Διατητές</label>
                                <input type="checkbox" id="extraPage-trigger" name="extraPage" {{ $extraPage }}/>
                              </div>
                               @if(config('settings.extraPage'))
                               <div style="{{ $extraPageDiv }}" id="extraPage">
                                 <hr>
                                 <h3>Ειδοποιητήριο προς Δαιτητές</h3>
                                <div class="form-group">
                                  <label for="date">Ημερομηνία</label>
                                  <input type="text" class="form-control" id="date" name="date" aria-describedby="Herbhelp" value="{{ $ex->date }}">
                                  <small class="form-text text-muted">Ημερομηνία: {{ $ex->date}}</small>
                                </div>
                                <div class="form-group">
                                  <label for="protokollo">Αρ. Πρωτοκόλλου</label>
                                  <input type="text" class="form-control" id="protokollo" name="protokollo" aria-describedby="Herbhelp" value="{{ $ex->protokollo }}">
                                  <small class="form-text text-muted">Αρ, Πρωτοκόλλου: {{ $ex->protokollo}}</small>
                                </div>
                                <div class="form-group">
                                  <label for="pros">Απευθείνεται Προς</label>
                                  <input type="text" class="form-control" id="pros" name="pros" aria-describedby="Herbhelp" value="{{ $ex->pros }}">
                                  <small class="form-text text-muted">Απευθείνεται Προς: {{ $ex->pros}}</small>
                                </div>
                                <div class="form-group">
                                  <label for="thema">Θέμα</label>
                                  <input type="text" class="form-control" id="thema" name="thema" aria-describedby="Herbhelp" value="{{ $ex->thema }}">
                                  <small class="form-text text-muted">Θέμα: {{ $ex->thema}}</small>
                                </div>
                                <div class="form-group">
                                  <label for="keimeno">Κυρίως Κείμενο</label>
                                  <textarea name="keimeno" class="form-control" rows="3">{{ $ex->keimeno }}</textarea>
                                  <small class="form-text text-muted">Κυρίως Κείμενο: {{ $ex->keimeno}}</small>
                                </div>
                              </div>
                              @endif
                              
                              
                              
                              <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                    </div>
            </div><!--box-->
            
      @endforeach
@endforeach
    
        
@endsection

@section('after-scripts')
   
<script>
  $(function() {
    $('#extraPage-trigger').on('click', function(){
        if ($(this).is(':checked')){
          $('#extraPage').css('display','block');
        }else{
          $('#extraPage').css('display','none');
        }
    });
  });
</script>
    
 
@endsection