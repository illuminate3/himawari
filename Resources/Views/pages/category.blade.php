@extends('app')

{{-- Web site Title --}}
@section('title')
{{ Lang::choice('kotoba::cms.page', 2) }} :: @parent
@stop

@section('styles')
@stop

@section('scripts')
@stop

@section('inline-scripts')
@stop


{{-- Content --}}
@section('content')

@if (isset($breadcrumbs) && !empty($breadcrumbs))
<div class="row">
	<ul class="breadcrumb">
	@foreach ($breadcrumbs as $label => $url)
		@if (is_numeric($label))
			<li class="active">{{{ $url }}}</li>
		@else
			<li><a href="{{ $url }}">{{{ $label }}}</a></li>
		@endif
	@endforeach
	</ul>
	<hr>
</div>
@endif


<div class="row">

	<h2 class="margin-top-none">
		{{ $page->title }}
	</h2>

</div>


<div class="row">
@if ($page->contents->count())

<div class="row">
<table id="table" class="table table-striped table-hover">
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
		@foreach ($page->contents as $content)
			<tr>

				<td>
					{!! Html::image($content->image, '', ['class' => 'img-thumbnail img-table']) !!}
					{{-- $content->image --}}
				</td>
				<td>{{{ $content->make }}}</td>
				<td>{{{ $content->model }}}</td>
				<td>{{{ $content->model_number }}}</td>
				<td>{{{ $content->description }}}</td>

				<td>
					{!! link_to_route('admin.contents.show', trans("kotoba::button.view"), array($content->id), array('class' => 'btn btn-info')) !!}
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


@if (isset($menu1))
<ul class="nav navbar-nav">
	@foreach ($menu as $content)
	<li @if(isset($content['active']) && $content['active'])class="active"@endif>
		<a href="{{ $content['url'] }}">{{ $content['label'] }}</a>
	</li>
	@endforeach
</ul>
@endif

@if ( isset($mainMenu) )
	{!! Html::navclean($mainMenu) !!}
@endif


</div> <!-- ./ row -->
@stop
