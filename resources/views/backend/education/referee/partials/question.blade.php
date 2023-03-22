<h3 class="box-title" style="margin-top: 10px">Ερώτηση</h3>
<span class="btn btn-success edit-question" data-id="{{$question->id}}">Επεξεργασία</span>
<span class="btn btn-danger delete-question" data-id="{{$question->id}}">Διαγραφή</span>
<div class="row">
<div class="dol-12">
    <p>Ερώτηση:&nbsp;{{$question->question}}</p>
</div>
</div>
<div class="row">
<div class="dol-12">
    <p>Απάντηση:&nbsp;{{$question->answer}}</p>
</div>
</div>
<div class="row">
<div class="dol-12">
    <p>Υπόδειξη:&nbsp;{{$question->suggestion}}</p>
</div>
</div>