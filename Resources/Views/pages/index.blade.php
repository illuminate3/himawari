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

<div class="row">
<h1>
	<p class="pull-right">
	<a href="{{ route('pages.create') }}" class="btn btn-primary" title="{{ trans('kotoba::button.new') }}">
		<i class="fa fa-plus fa-fw"></i>
		{{ trans('kotoba::button.new') }}
	</a>
	</p>
	<i class="fa fa-angle-double-right fa-lg"></i>
		{{ Lang::choice('kotoba::cms.page', 2) }}
	<hr>
</h1>
</div>


@if (count($pages))
<div class="row">
<table class="table table-striped table-hover">

<thead>
	<tr>
		<th>#</th>
		<th>
			{{ trans('kotoba::table.title') }}
		</th>
		<th>
			{{ trans('kotoba::table.slug') }}
		</th>
		<th>
			{{ trans('kotoba::table.updated_at') }}
		</th>
		<th>
			{{ Lang::choice('kotoba::table.action', 2) }}
		</th>
	</tr>
</thead>

<tbody>
@foreach ($pages as $content)
	<tr>
		<td>{{ $content->id }}</td>

		<td class="plain">
			{!! Html::content_depth($content->depth) !!}
			<a href="{{ route('pages.edit', array('pages' => $content->id)) }}" class="">
				{{{ $content->title}}}
				&nbsp;
				{!! Html::glyphicon('edit') !!}
			</a>
		</td>

		<td class="plain">
			@if ($content->slug)
				<a href="{{ route('page', array('slug' => $content->slug)) }}" class="">
					{{{ $content->slug }}}
				</a>
			@endif
		</td>

		<td>
			{{{ $content->updated_at }}}
		</td>

		<td>
			@if ($content->isRoot())
				<a href="{{ URL::route('pages.export') }}" class="btn">
					{!! Html::glyphicon('floppy-save') !!}
					{{ trans('kotoba::general.export') }}
				</a>
			@else
				<div class="col-sm-1">
					{!! Form::model(
						$content,
						[
							'route' => ['pages.up', $content->id],
							'method' => 'POST',
							'class' => ''
						]
					) !!}
						<button class="btn btn-xs btn-link" type="submit" title="{{ trans('kotoba::general.up') }}">
							{!! HTML::glyphicon("arrow-up") !!}
						</button>
					{!! Form::close() !!}
				</div>

				<div class="col-sm-1">
					{!! Form::model(
						$content,
						[
							'route' => ['pages.down', $content->id],
							'method' => 'POST',
							'class' => ''
						]
					) !!}
						<button class="btn btn-xs btn-link" type="submit" title="{{ trans('kotoba::general.down') }}">
							{!! HTML::glyphicon("arrow-down") !!}
						</button>
					{!! Form::close() !!}
				</div>

				<div class="col-sm-1">
				<!-- Button trigger modal -->
					<a data-toggle="modal" data-target="#myModal" class="" title="{{ trans('kotoba::button.delete') }}">
						{!! HTML::glyphicon('trash') !!}
					</a>
				<!--
					<a class="btn btn-xs" type="submit" title="Destroy" href="{{ URL::route('pages.confirm', array($content->id)) }}">
						{!! HTML::glyphicon('trash') !!}
					</a>
				-->
				</div>
			@endif
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


@stop
