<?php
namespace App\Modules\Himawari\Lib;

use Form;
use Html;
use View;


/**
 * Simple macro for generating bootstrap icons.
 *
 * @param string $icon
 */
Html::macro('glyphicon', function ($icon)
{
//dd($icon);
	return '<span class="glyphicon glyphicon-'.$icon.'"></span>';
});


/**
 * Render spaces to represent content depth.
 *
 * @param int $depth
 *
 * @return string
 */
Html::macro('content_depth', function ($depth)
{
//dd($depth);
	return str_repeat('<i class="fa fa-chevron-right fa-fw"></i>', $depth);
});



/**
 * Begin boostrap form group.
 *
 * Checks whether field has errors.
 *
 * @param string $name
 *
 * @return string
 */
Form::macro('beginGroup', function ($name)
{
    $errors = View::shared('errors');

    $class = 'form-group';

    if ($errors->has($name)) $class .= ' has-error';

    return '<div class="'.$class.'">';
});

/**
 * End bootstrap form group.
 *
 * Displays last error for a field if any.
 *
 * @param string $name
 *
 * @return string
 */
Form::macro('endGroup', function ($name)
{
    $html = '</div>';

    $errors = View::shared('errors');

    if ($errors->has($name))
    {
        $html = '<div class="col-lg-10 col-lg-offset-2"><span class="help-block">'.$errors->first($name).'</span></div>'.$html;
    }

    return $html;
});



// SIDE BAR MENU
/**
 * Render multi-level navigation.
 *
 * @param  array  $data
 *
 * @return string
 */
Html::macro('nav', function($data)
{
    if (empty($data)) return '';

    $html = '<ul>';

    foreach ($data as $content)
    {
        $html .= '<li';

//        if (isset($content['active']) && $content['active']) $html .= ' class="active"';

        $html .= '><a href="'.$content['url'].'">';

        $html .= e($content['label']);

//if (isset($content['contents'])) $html .= '<span class="fa plus-minus"></span>';

        $html .= '</a>';

        if (isset($content['contents'])) $html .= Html::nav($content['contents']);
        $html .= '</li>';
    }

    return $html.'</ul>';
});


Html::macro('navclean', function($data)
{
    if (empty($data)) return '';
//print_r($data);
    $html = '<nav class=""><ul id="">';

    foreach ($data as $content)
    {
        $html .= '<li';

//        if (isset($content['active']) && $content['active']) $html .= ' class="active"';

        $html .= '><a href="'.$content['url'].'">';
        $html .= e($content['label']);

//if (isset($content['contents'])) $html .= '<span class="fa plus-minus"></span>';

        $html .= '</a>';
        if (isset($content['contents'])) $html .= Html::nav($content['contents']);
        $html .= '</li>';
    }

    return $html.'</ul></nav>';
});





Html::macro('pulldown', function($data)
{

	if (empty($data)) return '';

	$html = '<select>';

	foreach ($data as $content)
	{
		if ( $content->slug == '/' ) {
			$html .= '<option value="NULL">Select a Page</option>';
		} else {
			$html .= '<option value="' . $content->id . '">';
			$html .= $content->slug;
			$html .= '</option>';
		}
	}

	$html .= '</select>';

	return $html;

});


/*
<nav class="sidebar-nav">
<ul id="metisMenu">
	<li class="active">
		<a href="#">
		<span class="sidebar-nav-content-icon fa fa-github fa-lg"></span>
		<span class="sidebar-nav-content">metisMenu</span>
		<span class="fa arrow"></span>
		</a>
		<ul class="collapse in">
			<li>
				<a href="https://github.com/onokumus/metisMenu">
				<span class="sidebar-nav-content-icon fa fa-code-fork"></span>
				LEVEL 1
				</a>
			</li>
			<li>
				<a href="#">
				<span class="sidebar-nav-content-icon fa fa-code-fork"></span>
				LEVEL 1
				<span class="fa plus-minus"></span>
				</a>
				<ul class="collapse">
					<li><a href="#">content 2.1</a></li>
					<li><a href="#">content 2.2</a></li>
					<li><a href="#">content 2.3</a></li>
					<li><a href="#">content 2.4</a></li>
				</ul>
			</li>
		</ul>
	</li>
</ul>
</nav>
*/



Html::macro('navy', function($data)
{
    if (empty($data)) return '';
//print_r($data);
    $html = '<ul id="navagoco" class="navagoco">';

    foreach ($data as $content)
    {
        $html .= '<li';

//        if (isset($content['active']) && $content['active']) $html .= ' class="active"';

        $html .= '><a href="'.$content['url'].'">';
        $html .= e($content['label']);

//if (isset($content['contents'])) $html .= '<span class="fa plus-minus"></span>';

        $html .= '</a>';
        if (isset($content['contents'])) $html .= Html::nav($content['contents']);
        $html .= '</li>';
    }

    return $html.'</ul>';
});
