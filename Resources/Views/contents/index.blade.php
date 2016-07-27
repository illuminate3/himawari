@extends($theme_back)


{{-- Web site Title --}}
@section('title')
{{ Lang::choice('kotoba::cms.content', 2) }} :: @parent
@stop


@section('styles')
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/DataTables-1.10.10/DataTables-1.10.10/css/dataTables.bootstrap.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/chosen_v1.4.2/chosen.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/chosen_bootstrap.css') }}">
@stop

@section('scripts')
	<script type="text/javascript" src="{{ asset('assets/vendors/DataTables-1.10.10/datatables.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/vendors/chosen_v1.4.2/chosen.jquery.min.js') }}"></script>
@stop

@section('inline-scripts')
$(document).ready(function() {

	$(".chosen-select").chosen({
		width: "100%"
	});

	$('#table-publish').DataTable({
		stateSave: true,
		'pageLength': 25
		});
	$('#table-draft').DataTable( {
		stateSave: true,
		'pageLength': 25
		});
	$('#table-archive').DataTable( {
		stateSave: true,
		'pageLength': 25
		});

});
@stop


{{-- Content --}}
@section('content')

<div class="row">
<h1>
	<p class="pull-right">
	<a href="/admin/contents/create" class="btn btn-primary" title="{{ trans('kotoba::button.new') }}">
		<i class="fa fa-plus fa-fw"></i>
		{{ trans('kotoba::button.new') }}
	</a>
	@if ( Auth::user()->is('super_admin') )
		<a href="/admin/contents/repair" class="btn btn-danger" title="{{ trans('kotoba::button.repair') }}">
			<i class="fa fa-wrench fa-fw"></i>
			{{ trans('kotoba::button.repair') }}
		</a>
	@endif
	</p>
	<i class="fa fa-paperclip fa-lg"></i>
		{{ Lang::choice('kotoba::cms.content', 2) }}
	<hr>
</h1>
</div>



<!-- Nav tabs -->
<ul class="nav nav-tabs nav-justified" role="tablist">
	<li role="presentation" class="active">
		<a href="#published" aria-controls="published" role="tab" data-toggle="tab">
		<i class="fa fa-newspaper-o fa-lg"></i>
		{{ trans('kotoba::cms.published') }}
		</a>
	</li>
	<li role="presentation">
		<a href="#draft" aria-controls="draft" role="tab" data-toggle="tab">
		<i class="fa fa-pencil fa-lg"></i>
		{{ Lang::choice('kotoba::cms.draft', 2) }}
		</a>
	</li>
	<li role="presentation">
		<a href="#archive" aria-controls="archive" role="tab" data-toggle="tab">
		<i class="fa fa-archive fa-lg"></i>
		{{ Lang::choice('kotoba::cms.archive', 2) }}
		</a>
	</li>
</ul>

<!-- Tab panes -->
<div class="tab-content padding">

	<div role="tabpanel" class="tab-pane active" id="published">
	<div class="tab-content padding">
		@if (count($published))

		<div class="row">
		<table id="table-publish" class="table table-striped table-hover">
			<thead>
				<tr>
					<th>{{ trans('kotoba::table.title') }}</th>
					<th>{{ trans('kotoba::table.summary') }}</th>
					<th>{{ trans('kotoba::table.slug') }}</th>
					<th>{{ trans('kotoba::table.position') }}</th>
					<th>{{ trans('kotoba::table.status') }}</th>
					<th>{{ trans('kotoba::table.private') }}</th>
					<th>{{ trans('kotoba::table.navigation') }}</th>
					<th>{{ trans('kotoba::table.timed') }}</th>
					<th>{{ Lang::choice('kotoba::table.action', 2) }}</th>
				</tr>
			</thead>
			<tbody>
				@foreach($publish_list as $item)
					{!! Html::contentNodes($item, $lang) !!}
				@endforeach
			</tbody>

		</table>
		</div>


		@else
		<div class="alert alert-info">
			{{ trans('kotoba::general.error.not_found') }}
		</div>
		@endif
	</div>
	</div><!-- ./ published panel -->

	<div role="tabpanel" class="tab-pane" id="draft">
	<div class="tab-content padding">
		@if (count($drafts))

		<div class="row">
		<table id="table-draft" class="table table-striped table-hover">
			<thead>
				<tr>
					<th>{{ trans('kotoba::table.title') }}</th>
					<th>{{ trans('kotoba::table.summary') }}</th>
					<th>{{ trans('kotoba::table.slug') }}</th>
					<th>{{ trans('kotoba::table.position') }}</th>
					<th>{{ trans('kotoba::table.status') }}</th>
					<th>{{ trans('kotoba::table.private') }}</th>
					<th>{{ trans('kotoba::table.navigation') }}</th>
					<th>{{ trans('kotoba::table.timed') }}</th>
					<th>{{ Lang::choice('kotoba::table.action', 2) }}</th>
				</tr>
			</thead>
			<tbody>
				@foreach($draft_list as $item)
					{!! Html::contentNodes($item, $lang) !!}
				@endforeach
			</tbody>

		</table>
		</div>


		@else
		<div class="alert alert-info">
			{{ trans('kotoba::general.error.not_found') }}
		</div>
		@endif
	</div>
	</div><!-- ./ draft panel -->


	<div role="tabpanel" class="tab-pane" id="archive">
	<div class="tab-content padding">
		@if (count($archives))

		<div class="row">
		<table id="table-archive" class="table table-striped table-hover">
			<thead>
				<tr>
					<th>{{ trans('kotoba::table.title') }}</th>
					<th>{{ trans('kotoba::table.summary') }}</th>
					<th>{{ trans('kotoba::table.slug') }}</th>
					<th>{{ trans('kotoba::table.position') }}</th>
					<th>{{ trans('kotoba::table.status') }}</th>
					<th>{{ Lang::choice('kotoba::table.action', 2) }}</th>
				</tr>
			</thead>
			<tbody>
				@foreach($archive_list as $item)
					{!! Html::contentNodes($item, $lang) !!}
				@endforeach
			</tbody>

		</table>
		</div>


		@else
		<div class="alert alert-info">
			{{ trans('kotoba::general.error.not_found') }}
		</div>
		@endif
	</div>
	</div><!-- ./ archive panel -->

</div><!-- ./ tab panes -->


{{--
@if (count($contents))

<div class="row">
<table id="table" class="table table-striped table-hover">
	<thead>
		<tr>
			<th>{{ trans('kotoba::table.title') }}</th>
			<th>{{ trans('kotoba::table.summary') }}</th>
			<th>{{ trans('kotoba::table.slug') }}</th>
			<th>{{ trans('kotoba::table.position') }}</th>
			<th>{{ trans('kotoba::table.online') }}</th>
			<th>{{ Lang::choice('kotoba::table.action', 2) }}</th>
		</tr>
	</thead>
	<tbody>
		@foreach($list as $item)
			{!! Html::contentNodes($item, $lang) !!}
		@endforeach
	</tbody>

</table>
</div>


@else
<div class="alert alert-info">
	{{ trans('kotoba::general.error.not_found') }}
</div>
@endif
--}}
</div>


@stop
