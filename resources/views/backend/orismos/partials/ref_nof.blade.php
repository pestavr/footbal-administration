<center>
    <input 
    type="checkbox" 
    class="form-check-input nof" 
    name="notified-{{$match}}" 
    value="{{$match}}" 
    {{ (($readonly)?'disabled="disabled"':'') }} 
    {{ (($ref_nof == 1) ? 'checked="checked" disabled="disabled"' : '' ) }} 
    ref="{{$ref_nof}}"><br/>
    <span></span>
</center>