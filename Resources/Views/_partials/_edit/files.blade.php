<div class="tab-content">


<div class="row">
<div class="col-sm-6">
<div class="padding">

<h3>
	{{ trans('kotoba::files.media') }}
</h3>
<hr>


@if ( count($content->images) )

	<h4>
		{{ Lang::choice('kotoba::cms.image', 1) }}
	</h4>
	<hr>

	@foreach($content->images as $image)
		{!! Form::hidden('previous_image_id', $image->id) !!}
		<div class="thumbnail">
			<img src="<?= $image->image->url('preview') ?>" class="img-rounded">
			<div class="caption">
				<h3>
					{{ $image->image_file_name }}
				</h3>
				<p>
					{{ $image->image_file_size }}
					<br>
					{{ $image->image_content_type }}
					<br>
					{{ $image->image_updated_at }}
				</p>
			</div>
		</div>
	@endforeach

@endif


@if ( count($content->documents) )

	<br>

	<h4>
		{{ Lang::choice('kotoba::files.file', 2) }}
	</h4>
	<hr>

	<div class="row">
	<table id="table" class="table table-striped table-hover">
		<thead>
			<tr>
				<th>{{ Lang::choice('kotoba::table.user', 1) }}</th>
				<th>{{ Lang::choice('kotoba::table.document', 1) }}</th>
				<th>{{ trans('kotoba::table.size') }}</th>
				<th>{{ Lang::choice('kotoba::table.type', 1) }}</th>
				<th>{{ trans('kotoba::table.updated') }}</th>
			</tr>
		</thead>
		<tbody>
			@foreach($content->documents as $document)
			{!! Form::hidden('previous_document_id', $document->id) !!}
			<tr>
				<td>{{ $document->user_id }}</td>
				<td>{{ $document->document_file_name }}</td>
				<td>{{ $document->document_file_size }}</td>
				<td>{{ $document->document_content_type }}</td>
				<td>{{ $document->document_updated_at }}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	</div>

@endif


</div>
</div><!-- ./ col-6 -->
<div class="col-sm-6">
<div class="padding">


<h3>
	{{ trans('kotoba::general.command.select') . '&nbsp;' . trans('kotoba::files.media') }}
</h3>
<hr>

<h4>
	<i class="fa fa-file-image-o fa-fw"></i>
	{{ trans('kotoba::general.command.select_an') . '&nbsp;' . Lang::choice('kotoba::cms.image', 1) }}
</h4>
<hr>

<select id="image_select" name="image_id[]" class="form-control chosen-select" onchange="setImage(this);">
	<option value="" label="">{{ trans('kotoba::general.command.select_an') . '&nbsp;' . Lang::choice('kotoba::cms.image', 1) }}</option>
	@foreach($get_images as $get_image)
		<option value="{{ $get_image->id }}" label="../../../system/files/images/{{ $get_image->id }}/preview/{{ $get_image->image_file_name }}">{{ $get_image->image_file_name }}</option>
	@endforeach
</select>

<h4 class="margin-top-xl">
	{{ Lang::choice('kotoba::cms.image', 1) }}
</h4>

<hr>

<div id="imagePreview">
	<img src="" name="image-swap" />
</div>

<br>

<h4>
	<i class="fa fa-file-pdf-o fa-fw"></i>
	{{ trans('kotoba::general.command.select') . '&nbsp;' . Lang::choice('kotoba::files.file', 2) }}
</h4>
<hr>

<select multiple id="file_select" name="document_id[]" class="form-control chosen-multi" data-placeholder="{{ trans('kotoba::general.command.select') . '&nbsp;' . Lang::choice('kotoba::files.file', 2) }}">
@foreach ($allDocuments as $key => $value)
	@if (isset($documents[$key]) )
		<option value='{{ $key }}' selected>{{ $value }}</option>
	@else
		<option value='{{ $key }}'>{{ $value }}</option>
	@endif
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
