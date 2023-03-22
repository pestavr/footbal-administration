<ul class="dropdown-menu" role="menu">
	<?php $seasons= App\Models\Backend\season::orderBy('season_id', 'desc')->pluck('period', 'season_id'); ?>
		@foreach ($seasons as $season_id=>$season)
                @if ($season_id != session('season'))
                        <li><a href="{{ route('admin.season.set', $season_id)}}">{{ $season }}</a></li>
                @endif
        @endforeach
        @needsroles('Admin')
        <li><a href="{{ route('admin.season.create')}}"><strong>Νέα Αγωνιστική Περίοδος</strong></a></li>
        @endauth
</ul>