<div class="pull-right mb-10 hidden-sm hidden-xs">
    
    <input type="submit"  class="btn btn-primary btn-xs" value="Εκτύπωσε Επιλεγμένα">
</div><!--pull right-->

<div class="pull-right mb-10 hidden-lg hidden-md">
    <div class="btn-group">
        <button type="submit" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            Εκτύπωση<span class="caret"></span>
        </button>

        <ul class="dropdown-menu" role="menu">
            <li>{{ link_to_route('admin.access.role.index', 'Εκτύπωσε Επιλεγμένα') }}</li>
        </ul>
    </div><!--btn group-->
</div><!--pull right-->

<div class="clearfix"></div>