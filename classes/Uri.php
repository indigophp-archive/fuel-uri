<?php

/*
 * This file is part of the Fuel URI package.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Indigo\Fuel;

use League\Url\Url;

/**
 * URI extension class using league/uri
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class Uri
{
	/**
	 * @var Url
	 */
	protected $url;

	/**
	 * @param string $uri
	 */
	public function __construct($uri = null)
	{
		// Is it really needed?
		if (\Fuel::$profiling)
		{
			\Profiler::mark(__METHOD__.' Start');
		}

		// if the route is a closure, an object will be passed here
		is_object($uri) and $uri = null;

		$uri = trim($uri ?: \Input::uri(), '/');

		$this->url = Url::createFromUrl($uri);

		// Is it really needed?
		if (\Fuel::$profiling)
		{
			\Profiler::mark(__METHOD__.' End');
		}
	}

	/**
	 * Returns the URI string
	 *
	 * @return string
	 */
	public function get()
	{
		return (string) $this->url;
	}

	/**
	 * Returns the URI segments
	 *
	 * @return array
	 */
	public function get_segments()
	{
		return $this->url->getPath()->toArray();
	}

	/**
	 * Get the specified URI segment, return default if it doesn't exist.
	 *
	 * Segment index is 1 based, not 0 based
	 *
	 * @param string $segment The 1-based segment index
	 * @param mixed  $default The default value
	 *
	 * @return mixed
	 */
	public function get_segment($segment, $default = null)
	{
		$path = $this->url->getPath();

		if (isset($path[$segment]))
		{
			return $path[$segment];
		}

		return \Fuel::value($default);
	}
}
