<div class="tab-content padding">


<div class="row">
<div class="col-sm-6">
<div class="padding">

<div class="form-group">
	{!! Form::label('parent_id', trans('kotoba::cms.parent'), ['class' => 'control-label']) !!}
	{!!
		Form::select(
			'parent_id',
			$pagelist,
			Input::old('parent_id'),
			array(
				'class' => 'form-control chosen-select',
				'id' => 'parent_id'
			)
		)
	!!}
</div>

<div class="form-group">
	{!! Form::label('is_online', Lang::choice('kotoba::account.user', 1), ['class' => 'control-label']) !!}
	{!!
		Form::select(
			'user_id',
			$users,
			$user_id,
			array(
				'class' => 'form-control chosen-select'
			)
		)
	!!}
</div>

<br>

<h4>
	<i class="fa fa-building-o fa-fw"></i>
	{{ trans('kotoba::general.command.select') . '&nbsp;' . Lang::choice('kotoba::hr.site', 2) }}
</h4>
<hr>

<select multiple="multiple" id="site_select" name="sites_id[]">
	@foreach ($allSites as $key => $value)
		@if (isset($sites[$key]) )
			<option value='{{ $key }}' selected>{{ $value }}</option>
		@else
			<option value='{{ $key }}'>{{ $value }}</option>
		@endif
	@endforeach
</select>


</div>
</div><!-- ./ col-6 -->
<div class="col-sm-6">
<div class="padding">

@if (Auth::user()->is('super_admin'))
	<div class="form-group">
		{!! Form::label('is_online', Lang::choice('kotoba::general.status', 1), ['class' => 'control-label']) !!}
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
@else
	<div class="form-group">
		{!! Form::label('is_online', Lang::choice('kotoba::general.status', 1), ['class' => 'control-label']) !!}
		{!! Form::hidden('print_status_id', $default_publish_status) !!}
		{{ Lang::choice('kotoba::cms.draft', 1) }}
	</div>
@endif


<hr>

<div class="well">

	<div class="form-group">
		<label for="is_navigation" class="col-sm-3 control-label">{{ trans('kotoba::cms.is_navigation') }}</label>
		<div class="col-sm-9">
			<div class="checkbox">
				<label>
					<input type="checkbox" id="is_navigation" name="is_navigation" value="{{ Input::old('is_navigation') }}">
				</label>
			</div>
		</div>
	</div>

	<div class="row">

	<div class="col-sm-6">
		<div class="form-group {{ $errors->first('order') ? 'has-error' : '' }}">
			{!! Form::label('order', trans('kotoba::cms.position'), $errors->first('order'), ['class' => 'control-label']) !!}
			{!! Form::text('order', Input::old('order'), ['id' => 'order', 'class' => 'form-control']) !!}
		</div>
	</div><!-- ./ col-6 -->
	<div class="col-sm-6">
		<div class="form-group {{ $errors->first('class') ? 'has-error' : '' }}">
			{!! Form::label('class', trans('kotoba::cms.class'), $errors->first('class'), ['class' => 'control-label']) !!}
			{!! Form::text('class', Input::old('class'), ['id' => 'class', 'class' => 'form-control', 'placeholder' => trans('kotoba::cms.class')]) !!}
		</div>
	</div><!-- ./ col-6 -->

	</div><!-- ./ row -->

</div><!-- ./well -->


<hr>

<div class="well">

	<div class="form-group">
		<label for="is_timed" class="col-sm-3 control-label">{{ trans('kotoba::cms.is_timed') }}</label>
		<div class="col-sm-9">
			<div class="checkbox">
				<label>
					<input type="checkbox" id="is_timed" name="is_timed" value="{{ Input::old('is_timed') }}">
				</label>
			</div>
		</div>
	</div>

	<div class="row">

	<div class="col-sm-6">
		<div class="form-group {{ $errors->first('order') ? 'has-error' : '' }}">
		{!! Form::label('order', trans('kotoba::cms.publish_start'), $errors->first('publish_start'), ['class' => 'control-label']) !!}
		<div id="datepicker-container">
			<div class="input-group date">
				<input type="text" id="publish_start" name="publish_start" class="form-control">
				<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
			</div>
		</div>
		</div>
	</div><!-- ./ col-6 -->
	<div class="col-sm-6">
		<div class="form-group {{ $errors->first('order') ? 'has-error' : '' }}">
		{!! Form::label('order', trans('kotoba::cms.publish_end'), $errors->first('publish_end'), ['class' => 'control-label']) !!}
		<div id="datepicker-container">
			<div class="input-group date">
				<input type="text" id="publish_end" name="publish_end" class="form-control">
				<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
			</div>
		</div>
		</div>
	</div><!-- ./ col-6 -->

	</div><!-- ./ row -->

</div><!-- ./well -->


<hr>


<div class="well">

	<div class="form-group">
		<label for="is_private" class="col-sm-3 control-label">{{ trans('kotoba::general.private') }}</label>
		<div class="col-sm-9">
			<div class="checkbox">
				<label>
					<input type="checkbox" id="is_private" name="is_private" value="{{ Input::old('is_private') }}">
				</label>
			</div>
		</div>
	</div>

</div><!-- ./well -->



</div>
</div><!-- ./ col-6 -->
</div><!-- ./ row -->



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
