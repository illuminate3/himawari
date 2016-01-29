<h2>
	<i class="fa fa-file fa-lg"></i>
	{{ Lang::choice('kotoba::cms.content', 2) }}
	<hr>
</h2>

<dl class="dl-horizontal">
	<dt>
		{{ trans('kotoba::general.all') }}
	</dt>
	<dd>
		<a href="{{ URL::to('/admin/contents') }}">{{ $total_contents }}</a>
	</dd>
</dl>
