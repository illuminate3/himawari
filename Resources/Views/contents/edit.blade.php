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
	<script type="text/javascript" src="{{ asset('assets/vendors/quicksearch/jquery.quicksearch.js') }}"></script>
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
		});

		$('#site_select').multiSelect({
			selectableHeader: "<input type='text' class='search-input' autocomplete='off' placeholder='{{ Lang::choice('kotoba::general.search', 1) }}'>",
			selectionHeader: "<input type='text' class='search-input' autocomplete='off' placeholder='{{ Lang::choice('kotoba::general.search', 1) }}'>",

			selectableFooter: "<div class='bg-primary padding-md'>{{ trans('kotoba::general.available') }}</div>",
			selectionFooter: "<div class='bg-primary padding-md'>{{ trans('kotoba::general.assigned') }}</div>",

			afterInit: function(ms){
				var that = this,
				$selectableSearch = that.$selectableUl.prev(),
				$selectionSearch = that.$selectionUl.prev(),
				selectableSearchString = '#'+that.$container.attr('id')+' .ms-elem-selectable:not(.ms-selected)',
				selectionSearchString = '#'+that.$container.attr('id')+' .ms-elem-selection.ms-selected';
				that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
				.on('keydown', function(e){
					if (e.which === 40){
						that.$selectableUl.focus();
						return false;
					}
				});
				that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
				.on('keydown', function(e){
					if (e.which == 40){
						that.$selectionUl.focus();
						return false;
					}
				});
			},
			afterSelect: function(){
				this.qs1.cache();
				this.qs2.cache();
			},
			afterDeselect: function(){
				this.qs1.cache();
				this.qs2.cache();
			}
		});

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
{!! Form::model(
	$content,
	[
		'route' => ['admin.contents.update', $content->id],
		'method' => 'PATCH',
		'class' => 'form'
	]
) !!}

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
		@include('himawari::_partials._edit.content')
	</div><!-- ./ content panel -->

	<div role="tabpanel" class="tab-pane" id="meta">
		@include('himawari::_partials._edit.meta')
	</div><!-- ./ meta panel -->

	<div role="tabpanel" class="tab-pane" id="files">
		@include('himawari::_partials._edit.files')
	</div><!-- ./ images panel -->

	<div role="tabpanel" class="tab-pane" id="settings">
		@include('himawari::_partials._edit.settings')
	</div><!-- ./ settings panel -->

</div><!-- ./ tab panes -->


<hr>


<div class="row">
<div class="col-sm-12">
	<input class="btn btn-success btn-block" type="submit" value="{{ trans('kotoba::button.save') }}">
</div>
</div>

<br>

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


{!! Form::close() !!}


</div> <!-- ./ row -->


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	@include($activeTheme . '::' . '_partials.modal')
</div>


@stop
