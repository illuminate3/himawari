<div class="tab-content">


<div class="row">
<div class="col-sm-6">
<div class="padding">


<h3>
	{{ trans('kotoba::general.command.select_an') . '&nbsp;' . Lang::choice('kotoba::cms.image', 1) }}
</h3>

<hr>

<select id="image_select" name="image_id" class="form-control chosen-select" onchange="setImage(this);">
	<option value="" label="">{{ trans('kotoba::general.command.select_an') . '&nbsp;' . Lang::choice('kotoba::cms.image', 1) }}</option>
	@foreach($get_images as $image)
		<option value="{{ $image->id }}" label="../../../system/files/images/{{ $image->id }}/preview/{{ $image->image_file_name }}">{{ $image->image_file_name }}</option>
	@endforeach
</select>

<h4 class="margin-top-xl">
	{{ Lang::choice('kotoba::cms.image', 1) }}
</h4>

<hr>

<div id="imagePreview">
	<img src="" name="image-swap" />
</div>


</div>
</div><!-- ./ col-6 -->
<div class="col-sm-6">
<div class="padding">


<h3>
	{{ trans('kotoba::general.command.select') . '&nbsp;' . Lang::choice('kotoba::files.file', 2) }}
</h3>

<hr>

<select multiple id="file_select" name="document_id[]" class="form-control chosen-multi" data-placeholder="{{ trans('kotoba::general.command.select') . '&nbsp;' . Lang::choice('kotoba::files.file', 2) }}">
	@foreach($get_documents as $document)
		<option value="{{ $document->id }}">{{ $document->document_file_name }}</option>
	@endforeach
</select>


{{--
<div class="form-group">
	{!! Form::label('featured_image', Lang::choice('kotoba::cms.image', 1), ['class' => 'control-label']) !!}
	<div class="imageTarget" rel="{{ $thumbnailPath }}"></div>
	{!! Form::hidden('featured_image', Input::old('featured_image'), ['id' => 'featured_image', 'class' => 'form-control hidden']) !!}
</div>
<div class="form-group">
	<a class="btn btn-default btn-rect btn-grad" id="changeFeaturedImage" data-toggle="modal" data-target="#featuredImageModal">{{ trans('kotoba::general.change') }}</a>
	<a class="btn btn-metis-3 btn-rect btn-grad" id="clearFeaturedImage">{{ trans('kotoba::general.clear') }}</a>
</div>
--}}

</div>
</div><!-- ./ col-6 -->
</div><!-- ./ row -->

</div>
