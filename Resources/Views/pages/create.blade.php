@extends('app')

{{-- Web site Title --}}
@section('title')
{{ Lang::choice('kotoba::cms.page', 2) }} :: @parent
@stop

@section('styles')
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/bootstrap-datepicker/css/datepicker3.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/chosen_v1.4.1/chosen.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/chosen_bootstrap.css') }}">
@stop

@section('scripts')
	<script type="text/javascript" src="{{ asset('assets/vendors/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/vendors/bootstrap-datepicker/js/datepicker-settings.js') }}"></script>
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
	{{ trans('kotoba::general.command.create') }}
	<hr>
</h1>
</div>


<div class="row">
{!! Form::open([
	'url' => 'pages',
	'method' => 'POST',
	'class' => 'form'
]) !!}
<div class="row">
<div class="col-sm-8">


<div role="tabpanel">

	<!-- Nav tabs -->
	<ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active"><a href="#content" aria-controls="content" role="tab" data-toggle="tab">{{ trans('kotoba::cms.content') }}</a></li>
		<li role="presentation"><a href="#meta" aria-controls="meta" role="tab" data-toggle="tab">{{ trans('kotoba::cms.meta') }}</a></li>
		<li role="presentation"><a href="#option" aria-controls="option" role="tab" data-toggle="tab">{{ Lang::choice('kotoba::shop.option', 2) }}</a></li>
	</ul>

	<!-- Tab panes -->
	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="content">


			<div class="form-group margin-top-xl">
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-tag fa-fw"></i></span>
					<input type="text" id="title" name="title" placeholder="{{ trans('kotoba::general.title') }}" class="form-control" autofocus="autofocus">
			</div>
			</div>


			<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon">{{ Request::root().'/' }}</span>
					<input type="text" id="slug" name="slug" placeholder="{{ trans('kotoba::general.slug') }}" class="form-control">
			</div>
			</div>


			<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-tag fa-fw"></i></span>
					<input type="text" id="summary" name="summary" placeholder="{{ trans('kotoba::cms.summary') }}" class="form-control">
			</div>
			</div>


			<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-tag fa-fw"></i></span>
					<input type="text" id="body" name="body" placeholder="{{ trans('kotoba::cms.body') }}" class="form-control">
			</div>
			</div>


		</div>
		<div role="tabpanel" class="tab-pane" id="meta">


			<div class="form-group margin-top-xl">
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-tag fa-fw"></i></span>
					<input type="text" id="meta_title" name="meta_title" placeholder="{{ trans('kotoba::cms.meta_title') }}" class="form-control">
			</div>
			</div>


			<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-tag fa-fw"></i></span>
					<input type="text" id="meta_keywords" name="meta_keywords" placeholder="{{ trans('kotoba::cms.meta_keywords') }}" class="form-control">
			</div>
			</div>


			<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-tag fa-fw"></i></span>
					<input type="text" id="meta_description" name="meta_description" placeholder="{{ trans('kotoba::cms.meta_description') }}" class="form-control">
			</div>
			</div>


		</div>
		<div role="tabpanel" class="tab-pane" id="option">
		</div>
	</div>

</div>


</div><!-- ./col -->
<div class="col-sm-4">


	@if (!isset($page) || !$page->isRoot())
		<div class="form-group padding-bottom-xl">
			<label for="inputStatus" class="col-sm-2 control-label">{{ trans('kotoba::general.parent') }}:</label>
			<div class="col-sm-10">
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


	<div class="form-group padding-bottom-xl">
		<label for="category_id" class="col-sm-2 control-label">{{ Lang::choice('kotoba::account.user', 1) }}:</label>
		<div class="col-sm-10">
			{!!
				Form::select(
					'user_id',
					$users,
					null,
					array(
						'class' => 'form-control chosen-select'
					)
				)
			!!}
		</div>
	</div>


	<div class="form-group padding-bottom-xl">
		<label for="category_id" class="col-sm-2 control-label">{{ Lang::choice('kotoba::cms.print_status', 1) }}:</label>
		<div class="col-sm-10">
			{!!
				Form::select(
					'print_status_id',
					$print_statuses,
					null,
					array(
						'class' => 'form-control chosen-select'
					)
				)
			!!}
		</div>
	</div>


	<div class="form-group">
		<label for="is_featured" class="col-sm-2 control-label">{{ trans('kotoba::cms.is_featured') }}</label>
		<div class="col-sm-10">
			<div class="checkbox">
				<label>
					<input type="checkbox" name="is_featured">
				</label>
			</div>
		</div>
	</div>


	<div class="form-group padding-bottom-xl margin-bottom-xl">
		<label for="publish_start" class="col-sm-2 control-label">{{ trans('kotoba::cms.publish_start') }}</label>
		<div id="datepicker-container" class="col-sm-10">
			<div class="input-group date">
				<input type="text" id="publish_start" name="publish_start" class="form-control">
				<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
			</div>
		</div>
	</div>

<br>

		<div class="form-group padding-bottom-xl">
			<label for="publish_end" class="col-sm-2 control-label">{{ trans('kotoba::cms.publish_end') }}</label>
			<div id="datepicker-container" class="col-sm-10">
				<div class="input-group date">
					<input type="text" id="publish_end" name="publish_end" class="form-control">
					<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
				</div>
			</div>
		</div>


		<div class="form-group">
		<div class="input-group">
			<span class="input-group-addon"><i class="fa fa-tag fa-fw"></i></span>
				<input type="text" id="tenant_id" name="tenant_id" placeholder="{{ trans('kotoba::cms.tenant') }}" class="form-control">
		</div>
		</div>


		<div class="form-group">
		<div class="input-group">
			<span class="input-group-addon"><i class="fa fa-tag fa-fw"></i></span>
				<input type="text" id="locale" name="locale" placeholder="{{ trans('kotoba::cms.locale') }}" class="form-control">
		</div>
		</div>


		<div class="form-group">
		<div class="input-group">
			<span class="input-group-addon"><i class="fa fa-tag fa-fw"></i></span>
				<input type="text" id="uri" name="uri" placeholder="{{ trans('kotoba::cms.link') }}" class="form-control">
		</div>
		</div>


</div>


</div><!-- ./col -->
</div><!-- ./row -->


<hr>


<div class="form-group">
	<input class="btn btn-success btn-block" type="submit" value="{{ trans('kotoba::button.save') }}">
</div>

{!! Form::close() !!}


<div class="row">
<div class="col-sm-6">
	<a href="/pages" class="btn btn-default btn-block" title="{{ trans('kotoba::button.cancel') }}">
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
