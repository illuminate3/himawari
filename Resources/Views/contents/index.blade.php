@extends('app')

{{-- Web site Title --}}
@section('title')
{{ Lang::choice('kotoba::shop.content', 2) }} :: @parent
@stop

@section('styles')
	<link href="{{ asset('assets/vendors/DataTables-1.10.5/plugins/integration/bootstrap/3/dataTables.bootstrap.css') }}" rel="stylesheet">
@stop

@section('scripts')
	<script src="{{ asset('assets/vendors/DataTables-1.10.5/media/js/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('assets/vendors/DataTables-1.10.5/plugins/integration/bootstrap/3/dataTables.bootstrap.min.js') }}"></script>
@stop


@section('inline-scripts')
$(document).ready(function() {
oTable =
	$('#table').DataTable({
		"processing": true,
		"serverSide": true,
		"ajax": "{{ URL::to('/admin/api/contents') }}",
		"columns": [
			{
				data: 'id',
				name: 'id',
				visible: false
			},
			{
				data: 'title',
				name: 'title',
				orderable: true,
				searchable: true
			},
			{
				data: 'make',
				name: 'make',
				orderable: true,
				searchable: true
			},
			{
				data: 'model',
				name: 'model',
				orderable: true,
				searchable: true
			},
			{
				data: 'model_number',
				name: 'model_number',
				orderable: true,
				searchable: true
			},
			{
				data: 'description',
				name: 'description',
				orderable: true,
				searchable: true
			},
			{
				data: 'actions',
				name: 'actions',
				orderable: false,
				searchable: false
			}
		]
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
	</p>
	<i class="fa fa-angle-double-right fa-lg"></i>
		{{ Lang::choice('kotoba::shop.content', 2) }}
	<hr>
</h1>
</div>


<div class="row">
<table id="table" class="table table-striped table-hover">
	<thead>
		<tr>
			<th>{{ trans('kotoba::table.id') }}</th>
			<th>{{ trans('kotoba::table.page') }}</th>
			<th>{{ trans('kotoba::table.make') }}</th>
			<th>{{ trans('kotoba::table.model') }}</th>
			<th>{{ trans('kotoba::table.model_number') }}</th>
			<th>{{ trans('kotoba::table.description') }}</th>

			<th>{{ Lang::choice('kotoba::table.action', 2) }}</th>
		</tr>
	</thead>
	<tbody></tbody>
</table>
</div>


@stop
