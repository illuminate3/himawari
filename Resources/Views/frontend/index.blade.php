@extends($theme_front)

{{-- Web site Title --}}
@section('title')
{{{ $page->title }}} :: @parent
@stop

@section('styles')
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/pdf_viewer.css') }}">
@stop

@section('scripts')
	<script src="{{ asset('assets/js/pdf_viewer.min.js') }}"></script>
@stop

@section('inline-scripts')
$(function(){
	$('.view-pdf').on('click',function(){
		var pdf_link = $(this).attr('href');
		var text = {!! json_encode($js_lang) !!};
		var iframe = '<div class="iframe-container"><iframe src="'+pdf_link+'"></iframe></div>'
		$.createModal({
		title: text.TITLE,
		close: text.CLOSE,
		message: iframe,
		closeButton:true,
		scrollable:false
		});
		return false;
	});
})
@stop


{{-- Content --}}
@section('content')


<div class="row">
	<h1>
		{{ $page->title }}
	</h1>
</div>

<div class="row">
	<h2>
		{!! $page->summary !!}
	</h2>
</div>

<div class="row">
	{!! $page->content !!}
</div>


@if ( count($page->documents) )
	<div class="row">
		<h3>
			{{ Lang::choice('kotoba::files.file', 2) }}
		</h3>
		<hr>
	</div>

	<div class="row">
	<table id="table" class="table table-striped table-hover">
		<thead>
			<tr>
				<th>{{ Lang::choice('kotoba::table.document', 1) }}</th>
				<th>{{ trans('kotoba::table.updated') }}</th>
			</tr>
		</thead>
		<tbody>
			@foreach($page->documents as $document)
			<tr>
				<td>
					@if ( File::extension($document->document_file_name) == "pdf" )
						<i class="fa fa-file-pdf-o fa-lg"></i>
						<a class="view-pdf" href="{{ $document->document->url() }}">{{ $document->document_file_name }}</a>
					@else
						<i class="fa fa-download fa-lg"></i>
						<a class="" href="{{ $document->document->url() }}">{{ $document->document_file_name }}</a>
					@endif
				</td>
				<td>{{ $document->document_updated_at }}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	</div>

@endif


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	@include($activeTheme . '::' . '_partials.modal')
</div>


@stop
