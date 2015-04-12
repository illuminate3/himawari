@extends('app')

{{-- Web site Title --}}
@section('title')
{{ Lang::choice('kotoba::shop.content', 2) }} :: @parent
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
	<a href="/admin/contents" class="btn btn-default" title="{{ trans('kotoba::button.back') }}">
		<i class="fa fa-chevron-left fa-fw"></i>
		{{ trans('kotoba::button.back') }}
	</a>
	</p>
	<i class="fa fa-edit fa-lg"></i>
	{{ trans('kotoba::general.command.create') }}
	<hr>
</h1>
</div>


<div class="row">
{!! Form::open([
	'url' => 'admin/contents',
	'method' => 'POST',
	'class' => 'form'
]) !!}


<div class="form-group">
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-tag fa-fw"></i></span>
		<input type="text" id="make" name="make" placeholder="{{ trans('kotoba::shop.make') }}" class="form-control" autofocus="autofocus">
</div>
</div>


<div class="form-group">
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-info fa-fw"></i></span>
		<input type="text" id="model" name="model" placeholder="{{ trans('kotoba::shop.model') }}" class="form-control">
</div>
</div>


<div class="form-group">
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-info fa-fw"></i></span>
		<input type="text" id="model_number" name="model_number" placeholder="{{ trans('kotoba::shop.model_number') }}" class="form-control">
</div>
</div>


<div class="form-group">
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-info fa-fw"></i></span>
		<textarea id="description" name="description" placeholder="{{ trans('kotoba::general.description') }}" class="form-control"></textarea>
</div>
</div>


<div class="form-group padding-bottom-xl">
	<label for="page_id" class="col-sm-1 control-label">{{ trans('kotoba::general.parent') }}:</label>
	<div class="col-sm-11">
		{!!
			Form::select(
				'page_id',
				$parents,
				null,
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
<div class="col-sm-6">
	<a href="/admin/contents" class="btn btn-default btn-block" title="{{ trans('kotoba::button.cancel') }}">
		<i class="fa fa-times fa-fw"></i>
		{{ trans('kotoba::button.cancel') }}
	</a>
</div>

<div class="col-sm-6">
	<input class="btn btn-default btn-block" type="reset" value="{{ trans('kotoba::button.reset') }}">
</div>
</div>


</div> <!-- ./ row -->
@stop
