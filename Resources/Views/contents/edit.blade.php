@extends('app')

{{-- Web site Title --}}
@section('title')
{{ Lang::choice('kotoba::cms.content', 2) }} :: @parent
@stop

@section('styles')
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/chosen_v1.4.1/chosen.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/chosen_bootstrap.css') }}">
@stop

@section('scripts')
	<script type="text/javascript" src="{{ asset('assets/vendors/chosen_v1.4.1/chosen.jquery.min.js') }}"></script>
@stop

@section('inline-scripts')
	jQuery(document).ready(function($) {
		$(".chosen-select").chosen();
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
	</p>
	<i class="fa fa-edit fa-lg"></i>
	{{ trans('kotoba::general.command.edit') }}
	<hr>
</h1>
</div>


<div class="row">
{!! Form::model(
	$content,
	[
		'route' => ['admin.contents.update', $content->id],
		'method' => 'PATCH',
		'class' => 'form'
	]
) !!}


<div class="form-group">
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-tag fa-fw"></i></span>
		<input type="text" id="make" name="make" value="{{ $content->make }}" placeholder="{{ trans('kotoba::cms.make') }}" class="form-control" autofocus="autofocus">
</div>
</div>


<div class="form-group">
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-info fa-fw"></i></span>
		<input type="text" id="model" name="model" value="{{ $content->model }}" placeholder="{{ trans('kotoba::cms.model') }}" class="form-control">
</div>
</div>


<div class="form-group">
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-info fa-fw"></i></span>
		<input type="text" id="model_number" name="model_number" value="{{ $content->model_number }}" placeholder="{{ trans('kotoba::cms.model_number') }}" class="form-control">
</div>
</div>


<div class="form-group">
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-info fa-fw"></i></span>
		<textarea id="description" name="description" placeholder="{{ trans('kotoba::general.description') }}" class="form-control">{{ $content->description }}</textarea>
</div>
</div>


<div class="form-group padding-bottom-xl">
	<label for="page_id" class="col-sm-1 control-label">{{ trans('kotoba::general.parent') }}:</label>
	<div class="col-sm-11">
		{!!
			Form::select(
				'page_id',
				$parents,
				$content->page_id,
				array(
					'class' => 'form-control chosen-select'
				)
			)
		!!}
	</div>
</div>


<div class="form-group padding-bottom-xl">
	<label for="inputLogo" class="col-sm-1 control-label">{{ trans('kotoba::account.logo') }}:</label>
	<div class="col-sm-11">
		<div class="row margin-bottom-lg">
		<div class="col-sm-8">

{{-- $logo --}}
			@if($image != NULL)
				{!! Form::hidden('image', $content->image) !!}
				{!! Html::image($image, '', ['class' => 'img-thumbnail']) !!}
			@else
				<div class="alert alert-danger">
					{{ trans('kotoba::account.error.logo') }}
				</div>
			@endif

		</div>

		<div class="col-sm-4">
			{!! Form::file('newImage') !!}
		</div>

		</div>
	</div>
</div>


<hr>


<div class="form-group">
	<input class="btn btn-success btn-block" type="submit" value="{{ trans('kotoba::button.save') }}">
</div>

{!! Form::close() !!}


<div class="row">
<div class="col-sm-4">
	<a href="/admin/contents" class="btn btn-default btn-block" title="{{ trans('kotoba::button.cancel') }}">
		<i class="fa fa-times fa-fw"></i>
		{{ trans('kotoba::button.cancel') }}
	</a>
</div>

<div class="col-sm-4">
	<input class="btn btn-default btn-block" type="reset" value="{{ trans('kotoba::button.reset') }}">
</div>

<div class="col-sm-4">
<!-- Button trigger modal -->
	<a data-toggle="modal" data-target="#myModal" class="btn btn-default btn-block" title="{{ trans('kotoba::button.delete') }}">
		<i class="fa fa-trash-o fa-fw"></i>
		{{ trans('kotoba::general.command.delete') }}
	</a>
</div>
</div>


</div> <!-- ./ row -->


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	@include('_partials.modal')
</div>


@stop
