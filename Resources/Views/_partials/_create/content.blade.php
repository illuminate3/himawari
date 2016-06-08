<div class="tab-content">

@if (count($languages))

<ul class="nav nav-tabs">
	@foreach( $languages as $language)
		<li class="@if ($language->locale == $lang)active @endif">
			<a href="#{{ $language->id }}" data-target="#lang_{{ $language->id }}" data-toggle="tab">{{{ $language->name }}}</a>
		</li>
	@endforeach
</ul>

@foreach( $languages as $language)
<div role="tabpanel" class="tab-pane padding fade @if ($language->locale == $lang)in active @endif" id="lang_{{{ $language->id }}}">

		<div class="form-group">
			<label for="title">{{ trans('kotoba::general.title') }}</label>
			<input type="text" class="form-control" name="{{ 'title_'. $language->id }}" id="{{ 'title_'. $language->id }}" placeholder="{{ trans('kotoba::general.title') }}">
		</div>

		<div class="form-group">
			<label for="slug">{{ trans('kotoba::general.slug') }}</label>
			<input type="text" class="form-control" name="{{ 'slug_'. $language->id }}" id="{{ 'slug_'. $language->id }}" placeholder="{{ trans('kotoba::general.slug') }}">
		</div>

		<div class="form-group">
			<label for="content">{{ trans('kotoba::cms.content') }}</label>
			<textarea class="form-control summernote" name="{{ 'content_'. $language->id }}" id="{{ 'content_'. $language->id }}" placeholder="{{ trans('kotoba::cms.content') }}"></textarea>
		</div>

		<div class="form-group">
			<label for="summary">{{ trans('kotoba::cms.summary') }}</label>
			<textarea class="form-control summersummary" name="{{ 'summary_'. $language->id }}" id="{{ 'summary_'. $language->id }}" placeholder="{{ trans('kotoba::cms.summary') }}"></textarea>
		</div>

</div><!-- ./ $lang panel -->
@endforeach

@endif

</div>
