@extends('module_info')

{{-- Web site Title --}}
@section('title')
{{ Config::get('general.title') }} :: @parent
@stop

@section('styles')
@stop

@section('scripts')
@stop

@section('inline-scripts')
@stop


{{-- Content --}}
@section('content')

	<div class="container">
		<div class="content">
			<a href="/">
				<img src="/assets/images/himwari.png" class="img-responsive">
			</a>
			<div class="title">
				<a href="/">
					Himawari
				</a>
			</div>
			<div class="quote">
				Himwari is a CMS module for Rakko
			</div>
		</div>
	</div>

@stop
