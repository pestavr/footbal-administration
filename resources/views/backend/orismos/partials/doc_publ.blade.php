<center><input type="checkbox" class="form-check-input publ" name="published-{{$match}}" {{ (($readonly)?'disabled="disabled"':'') }} value="{{$match}}" {{ (($doc_publ==1)?'checked="checked"':'') }}></center>