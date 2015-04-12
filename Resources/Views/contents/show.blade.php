@extends('app')

{{-- Web site Title --}}
@section('title')
{{ Lang::choice('kotoba::shop.content', 2) }} :: @parent
@stop

@section('styles')
	<link href="{{ asset('assets/vendors/DataTables-1.10.5/plugins/integration/bootstrap/3/dataTables.bootstrap.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/vendors/DataTables-1.10.5/extensions/TableTools/css/dataTables.tableTools.min.css') }}" rel="stylesheet">
@stop

@section('scripts')
	<script src="{{ asset('assets/vendors/DataTables-1.10.5/media/js/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('assets/vendors/DataTables-1.10.5/plugins/integration/bootstrap/3/dataTables.bootstrap.min.js') }}"></script>
	<script src="{{ asset('assets/vendors/DataTables-1.10.5/extensions/TableTools/js/dataTables.tableTools.min.js') }}"></script>
@stop

@section('inline-scripts')

$(document).ready( function () {

	$('#table').dataTable( {
		"dom": 'T<"clear">lfrtip',
		"tableTools": {
			"aButtons": [
				"copy",
				"print",
				{
					"sExtends":    "collection",
					"sButtonText": "Save",
					"aButtons":    [ "csv", "xls", "pdf" ]
				}
			],
			"sSwfPath": "{{ asset('assets/vendors/DataTables-1.10.5/extensions/TableTools/swf/copy_csv_xls_pdf.swf') }}"
		}
	} );

});
@stop


{{-- Content --}}
@section('content')

<div class="row">
<h1>
	<p class="pull-right">
	<a href="/admin/contents" class="btn btn-default" title="{{ trans('kotoba::button.back') }}">
		<i class="fa fa-chevron-left fa-fw"></i>
		{{ trans('kotoba::button.back') }}
	</a>
	<a href="/pages" class="btn btn-default" title="{{ trans('kotoba::button.back') }}">
		<i class="fa fa-chevron-left fa-fw"></i>
		{{ Lang::choice('kotoba::general.page', 2) }}
	</a>
	</p>
	<i class="fa fa-tag fa-lg"></i>
	{{{ $content->make }}}&nbsp;:&nbsp;{{{ $content->model }}}&nbsp;:&nbsp;{{{ $content->model_number }}}
	<hr>
</h1>
</div>


<div class="row">
<table id="" class="table table-striped table-hover">
	<thead>
		<tr>

			<th>{{ trans("kotoba::table.image") }}</th>
			<th>{{ trans("kotoba::table.make") }}</th>
			<th>{{ trans("kotoba::table.model") }}</th>
			<th>{{ trans("kotoba::table.model_number") }}</th>
			<th>{{ trans("kotoba::table.description") }}</th>

			<th>{{ Lang::choice('kotoba::table.action', 2) }}</th>
		</tr>
	</thead>

	<tbody>
		<tr>

			<td>
				{!! Html::image($content->image, '', ['class' => 'img-thumbnail img-show']) !!}
				{{-- $content->image --}}
			</td>
			<td>{{{ $content->make }}}</td>
			<td>{{{ $content->model }}}</td>
			<td>{{{ $content->model_number }}}</td>
			<td>{{{ $content->description }}}</td>

			<td width="25%">
				<a href="{{ URL::to('/admin/contents/' . $content->id . '/edit' ) }}" class="btn btn-success" >
					<span class="glyphicon glyphicon-pencil"></span>  {{ trans("kotoba::button.edit") }}
				</a>
				<a data-toggle="modal" data-target="#myModal" class="btn btn-danger" title="{{ trans('kotoba::button.delete') }}">
					<i class="fa fa-trash-o fa-fw"></i>
					{{ trans('kotoba::general.command.delete') }}
				</a>
			</td>
		</tr>
	</tbody>
</table>
</div>

@if (count($content['assets']))

<h3>
	{{ Lang::choice('kotoba::shop.asset', 2) }}
</h3>

<div class="row">
<table id="table" class="table table-striped table-hover">
	<thead>
		<tr>
			<th>{{ trans("kotoba::table.site") }}</th>
			<th>{{ Lang::choice('kotoba::table.room', 1) }}</th>
			<th>{{ trans("kotoba::table.asset_status") }}</th>
			<th>{{ trans("kotoba::table.asset_tag") }}</th>
			<th>{{ trans("kotoba::table.serial") }}</th>
			<th>{{ trans("kotoba::table.po") }}</th>
			<th>{{ trans("kotoba::table.note") }}</th>

			<th>{{ Lang::choice('kotoba::table.action', 2) }}</th>
		</tr>
	</thead>

	<tbody>
		@foreach ($content['assets'] as $asset)
		<tr>
			<td>{{{ $asset->present()->site($asset->site_id) }}}</td>
			<td>{{{ $asset->room->name }}}</td>
			<td>{{{ $asset->present()->asset_status($asset->asset_status_id) }}}</td>
			<td>{{{ $asset->asset_tag }}}</td>
			<td>{{{ $asset->serial }}}</td>
			<td>{{{ $asset->po }}}</td>
			<td>{{{ $asset->note }}}</td>
			<td>
				<a href="{{ URL::to('/admin/asset/' . $asset->id . '/edit' ) }}" class="btn btn-success" >
					<span class="glyphicon glyphicon-pencil"></span>  {{ trans("kotoba::button.edit") }}
				</a>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
</div>


@else
	<div class="alert alert-info">
		{{ trans('kotoba::general.no_records') }}
	</div>
@endif


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	@include('_partials.modal')
</div>


@stop
