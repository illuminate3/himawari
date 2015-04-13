<?php
namespace App\Modules\Himawari\Lib;

use Illuminate\Support\Collection;

/**
 * Convert tree of nodes in an array appropriate for HTML::nav().
 *
 * @param  \Illuminate\Support\Collection $tree
 * @param  int         $activeContentKey
 * @param  boolean     $active
 *
 * @return array
 */
function make_nav_tree(Collection $tree, $activeContentKey = null, &$active = null)
{
//dd($tree);
	if (!$tree->count()) return null;

	return array_map(function ($content) use ($activeContentKey, &$active) {
		$data = array();

		$childActive = false;
		$data['contents'] = make_nav_tree($content->children, $activeContentKey, $childActive);

		if ($activeContentKey !== null)
		{
			$childActive |= $activeContentKey == $content->getKey();
		}

		$active |= $childActive;

		$data['active'] = $childActive;

		foreach (array('url', 'label') as $key) {
			$getter = 'getNav'.ucfirst($key);

			$data[$key] = $content->$getter();
		}

		return $data;

	}, $tree->all());
}

/**
 * Transform markdown to the HTML.
 *
 * @param string $text
 *
 * @return string
 */
function markdown($text)
{
	return Parsedown::instance()->parse($text);
}

/**
 * Render spaces to represent content depth.
 *
 * @param int $depth
 *
 * @return string
 */
function content_depth($depth)
{
//dd($depth);
	return str_repeat('<span class="space">&raquo;</span>', $depth);
}
