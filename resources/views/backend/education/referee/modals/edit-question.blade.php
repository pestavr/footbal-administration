<div id="edit-question-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 id="termsLabel" class="modal-title">Επεξεργασία Ερώτησης</h3>
      </div>
      <div class="modal-body">
        <div class="form-group">
        <input type="hidden" class="form-control" id="modal-id" name="id"> 
        <label for="BirthYear">Ερώτηση</label>
        <input type="text" class="form-control" id="modal-question" name="question" placeholder="Ερώτηση">
        </div>
        <div class="form-group">
        <label for="BirthYear">Απάντηση</label>
        <input type="text" class="form-control" id="modal-answer" name="answer" placeholder="Απάντηση">
        </div>
        <div class="form-group">
        <label for="BirthYear">Υπόδειξη</label>
        <input type="text" class="form-control" id="modal-suggestion" name="suggestion" placeholder="Υπόδειξη">
        </div>
        
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-success" id="modal-save">Save</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->  