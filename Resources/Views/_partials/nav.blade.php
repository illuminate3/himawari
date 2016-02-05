<ul class="nav navbar-nav navbar-right">
	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
			{{ trans('kotoba::cms.cms') }} <span class="caret"></span>
		</a>
		<ul class="dropdown-menu" role="menu">
			<li>
			{!!
				Widget::MenuCMS()
			!!}
			</li>
		</ul>
	</li>
</ul>
