<div class="tab-content">

@if (count($languages))

<ul class="nav nav-tabs">
	@foreach( $languages as $language)
		<li class="@if ($language->locale == $lang)active @endif">
			<a href="#{{ $language->id }}" data-target="#meta_{{ $language->id }}" data-toggle="tab">{{{ $language->name }}}</a>
		</li>
	@endforeach
</ul>

@foreach( $languages as $language)
<div role="tabpanel" class="tab-pane padding fade @if ($language->locale == $lang)in active @endif" id="meta_{{{ $language->id }}}">

	<div class="form-group">
		<label for="title">{{ trans('kotoba::cms.meta_title') }}</label>
		<input type="text" class="form-control" name="{{ 'meta_title_'. $language->id }}" id="{{ 'meta_title_'. $language->id }}" value="{{  $content->translate($language->locale)->meta_title }}">
	</div>

	<div class="form-group">
		<label for="title">{{ trans('kotoba::cms.meta_keywords') }}</label>
		<input type="text" class="form-control" name="{{ 'meta_keywords_'. $language->id }}" id="{{ 'meta_keywords_'. $language->id }}" value="{{  $content->translate($language->locale)->meta_keywords }}">
	</div>

	<div class="form-group">
		<label for="title">{{ trans('kotoba::cms.meta_description') }}</label>
		<input type="text" class="form-control" name="{{ 'meta_description_'. $language->id }}" id="{{ 'meta_description_'. $language->id }}" value="{{  $content->translate($language->locale)->meta_description }}">
	</div>

</div><!-- ./ $lang panel -->
@endforeach

@endif


</div>
