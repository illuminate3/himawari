@extends($theme_back)


{{-- Web site Title --}}
@section('title')
{{ trans('kotoba::cms.content') }} :: @parent
@stop

@section('styles')
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/multi-select_v0_9_12/css/multi-select.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/bootstrap-datepicker/css/datepicker3.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/chosen_v1.4.2/chosen.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/chosen_bootstrap.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/summernote_0.6.16/summernote.css') }}">
@stop

@section('scripts')
	<script type="text/javascript" src="{{ asset('assets/vendors/multi-select_v0_9_12/js/jquery.multi-select.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/vendors/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/vendors/bootstrap-datepicker/js/datepicker-settings.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/vendors/chosen_v1.4.2/chosen.jquery.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/vendors/summernote_0.6.16/summernote.min.js') }}"></script>
@stop

@section('inline-scripts')
	jQuery(document).ready(function($) {
		$('#file_select').multiSelect({
			selectableHeader: "<div class='bg-primary padding-md'>{{ trans('kotoba::general.available') }}</div>",
			selectionHeader: "<div class='bg-primary padding-md'>{{ trans('kotoba::general.assigned') }}</div>"
		})
		$('#site_select').multiSelect({
			selectableHeader: "<div class='bg-primary padding-md'>{{ trans('kotoba::general.available') }}</div>",
			selectionHeader: "<div class='bg-primary padding-md'>{{ trans('kotoba::general.assigned') }}</div>"
		})
		$(".chosen-select").chosen({
			width: "100%"
		});
		$('.summernote').summernote({
			height: 300,				// set minimum height of editor
			minHeight: null,			// set minimum height of editor
			maxHeight: null,			// set maximum height of editor
			focus: true,				// set focus to editable area after initializing summernote
		});
		$('.summersummary').summernote({
			height: 100,				// set minimum height of editor
			minHeight: null,			// set minimum height of editor
			maxHeight: null,			// set maximum height of editor
			focus: true,				// set focus to editable area after initializing summernote
		});
	});

function setImage(select){
	var image = document.getElementsByName("image-swap")[0];
	image.src = select.options[select.selectedIndex].label;
		if ( image.src == "" ) {
			$("#imagePreview").append("displays image here");
		}
}
@stop


{{-- Content --}}
@section('content')


<div class="row margin-top-lg">
{!! Form::open([
	'url' => 'admin/contents',
	'method' => 'POST',
	'class' => 'form-horizontal'
]) !!}

<!-- Nav tabs -->
<ul class="nav nav-tabs nav-justified" role="tablist">
	<li role="presentation" class="active"><a href="#content" aria-controls="content" role="tab" data-toggle="tab">{{ trans('kotoba::cms.content') }}</a></li>
	<li role="presentation"><a href="#meta" aria-controls="meta" role="tab" data-toggle="tab">{{ trans('kotoba::cms.meta') }}</a></li>
	<li role="presentation"><a href="#files" aria-controls="settings" role="tab" data-toggle="tab">{{ Lang::choice('kotoba::files.file', 2) }}</a></li>
	<li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">{{ Lang::choice('kotoba::general.setting', 2) }}</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content padding">

	<div role="tabpanel" class="tab-pane active" id="content">
		@include('himawari::_partials._create.content')
	</div><!-- ./ content panel -->

	<div role="tabpanel" class="tab-pane" id="meta">
		@include('himawari::_partials._create.meta')
	</div><!-- ./ meta panel -->

	<div role="tabpanel" class="tab-pane" id="files">
		@include('himawari::_partials._create.files')
	</div><!-- ./ images panel -->

	<div role="tabpanel" class="tab-pane" id="settings">
		@include('himawari::_partials._create.settings')
	</div><!-- ./ settings panel -->

</div><!-- ./ tab panes -->

<hr>

<div class="form-group">
<div class="col-sm-12">
	<input class="btn btn-success btn-block" type="submit" value="{{ trans('kotoba::button.save') }}">
</div>
</div>

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

{!! Form::close() !!}

</div> <!-- ./ row -->


@stop
