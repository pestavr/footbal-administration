@for($i=1;$i<=$nTeams;$i++)
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
                    <label for="iso">Γηπεδούχος</label>
                    {!! Form::text('team1[$i]', '', ['class'=>'form-control team', 'id'=>'team1-'.$i, 'rel'=>'teamID1-'.$i, 'data-style'=>'btn-danger', 'placeholder'=>'Συμπληρώστε τον Γηπεδούχο']) !!}
                    {!! Form::hidden('teamID1['.$i.']', '', ['class'=>'form-control', 'id'=>'teamID1-'.$i , 'data-style'=>'btn-danger']) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
                     <label for="iso">Φιλοξενούμενος</label>
                    {!! Form::text('team2['.$i.']', '', ['class'=>'form-control team', 'id'=>'team2-'.$i, 'data-style'=>'btn-danger', 'rel'=>'teamID2-'.$i,'placeholder'=>'Συμπληρώστε τον Φιλοξενούμενο']) !!}
                    {!! Form::hidden('teamID2['.$i.']', '', ['class'=>'form-control', 'id'=>'teamID2-'.$i, 'data-style'=>'btn-danger']) !!}
        </div>
    </div>
</div>
@endfor