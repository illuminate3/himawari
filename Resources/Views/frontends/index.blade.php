@extends('app')

{{-- Web site Title --}}
@section('title')
{{ Lang::choice('kotoba::general.content', 2) }} :: @parent
@stop

@section('styles')
@stop

@section('scripts')
@stop

@section('inline-scripts')
@stop

{{-- Content --}}
@section('content')

   <div class="col-sm-12">
        <div class="editor-content">
            {{ $page->content }}
        </div>
    </div>


@stop
