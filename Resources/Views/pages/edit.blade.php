@extends('app')

{{-- Web site Title --}}
@section('title')
{{ Lang::choice('kotoba::cms.page', 2) }} :: @parent
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
	<a href="/pages" class="btn btn-default" title="{{ trans('kotoba::button.back') }}">
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
	$page,
	[
		'route' => ['pages.update', $page->id],
		'method' => 'PATCH',
		'class' => 'form'
	]
) !!}


<div class="form-group">
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-tag fa-fw"></i></span>
		<input type="text" id="title" name="title" value="{{ $page->title }}" placeholder="{{ trans('kotoba::general.title') }}" class="form-control" autofocus="autofocus">
</div>
</div>


<div class="form-group">
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-info fa-fw"></i></span>
		<input type="text" id="summary" name="summary" value="{{ $page->summary }}" placeholder="{{ trans('kotoba::cms.summary') }}" class="form-control">
</div>
</div>


<div class="form-group">
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-info fa-fw"></i></span>
		<input type="text" id="body" name="body" value="{{ $page->body }}" placeholder="{{ trans('kotoba::cms.body') }}" class="form-control">
</div>
</div>


<div class="form-group">
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-info fa-fw"></i></span>
		<input type="text" id="user_id" name="user_id" value="{{ $page->user_id }}" placeholder="{{ Lang::choice('kotoba::account.user', 1) }}" class="form-control">
</div>
</div>


<div class="form-group">
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-info fa-fw"></i></span>
		<input type="text" id="print_status_id" name="print_status_id" value="{{ $page->print_status_id }}" placeholder="{{ trans('kotoba::cms.in_print') }}" class="form-control">
</div>
</div>


<div class="form-group">
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-info fa-fw"></i></span>
		<input type="text" id="is_published" name="is_published" value="{{ $page->is_published }}" placeholder="{{ trans('kotoba::cms.is_published') }}" class="form-control">
</div>
</div>


<div class="form-group">
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-info fa-fw"></i></span>
		<input type="text" id="is_featured" name="is_featured" value="{{ $page->is_featured }}" placeholder="{{ trans('kotoba::cms.is_featured') }}" class="form-control">
</div>
</div>


<div class="form-group">
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-info fa-fw"></i></span>
		<input type="text" id="publish_start" name="publish_start" value="{{ $page->publish_start }}" placeholder="{{ trans('kotoba::cms.publish_start') }}" class="form-control">
</div>
</div>


<div class="form-group">
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-info fa-fw"></i></span>
		<input type="text" id="publish_end" name="publish_end" value="{{ $page->publish_end }}" placeholder="{{ trans('kotoba::cms.publish_end') }}" class="form-control">
</div>
</div>


<div class="form-group">
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-info fa-fw"></i></span>
		<input type="text" id="locale" name="locale" value="{{ $page->locale }}" placeholder="{{ trans('kotoba::cms.locale') }}" class="form-control">
</div>
</div>


<div class="form-group">
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-info fa-fw"></i></span>
		<input type="text" id="uri" name="uri" value="{{ $page->uri }}" placeholder="{{ trans('kotoba::cms.uri') }}" class="form-control">
</div>
</div>


<div class="form-group">
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-info fa-fw"></i></span>
		<input type="text" id="meta_title" name="meta_title" value="{{ $page->meta_title }}" placeholder="{{ trans('kotoba::cms.meta_title') }}" class="form-control">
</div>
</div>


<div class="form-group">
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-info fa-fw"></i></span>
		<input type="text" id="meta_keywords" name="meta_keywords" value="{{ $page->meta_keywords }}" placeholder="{{ trans('kotoba::cms.meta_keywords') }}" class="form-control">
</div>
</div>


<div class="form-group">
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-info fa-fw"></i></span>
		<input type="text" id="meta_description" name="meta_description" value="{{ $page->meta_description }}" placeholder="{{ trans('kotoba::cms.meta_description') }}" class="form-control">
</div>
</div>


<div class="form-group">
<div class="input-group">
	<span class="input-group-addon">{{ Request::root().'/' }}</span>
		<input type="text" id="slug" name="slug" value="{{ $page->slug }}" placeholder="{{ trans('kotoba::general.slug') }}" class="form-control">
</div>
</div>


@if (!isset($page) || !$page->isRoot())
	<div class="form-group padding-bottom-xl">
		<label for="inputStatus" class="col-sm-1 control-label">{{ trans('kotoba::general.parent') }}:</label>
		<div class="col-sm-11">
			{!!
				Form::select(
					'parent_id',
					$parents,
					null,
					array(
						'class' => 'form-control chosen-select'
					)
				)
			!!}
		</div>
	</div>
@endif


<hr>


<div class="form-group">
	<input class="btn btn-success btn-block" type="submit" value="{{ trans('kotoba::button.save') }}">
</div>

{!! Form::close() !!}


<div class="row">
<div class="col-sm-4">
	<a href="/pages" class="btn btn-default btn-block" title="{{ trans('kotoba::button.cancel') }}">
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
