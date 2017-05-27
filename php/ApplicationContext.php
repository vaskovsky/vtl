<?php
// Copyright © 2017 Alexey Vaskovsky.
//
// This file is free software; you can redistribute it and/or
// modify it under the terms of the GNU Lesser General Public
// License as published by the Free Software Foundation; either
// version 3.0 of the License, or (at your option) any later version.
//
// This file is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
// Lesser General Public License for more details.
//
// You should have received a copy of the GNU Lesser General Public
// License along with this file. If not, see
// <http://www.gnu.org/licenses/>
namespace VTL;
/**
 * The application context.
 *
 * @author Alexey Vaskovsky
 */
class ApplicationContext
{
	private $dir = ".";
	private $url = ".";

	private function __construct()
	{
		//
		$dir = __DIR__; // php
		$dir = dirname($dir); // vtl
		$dir = dirname($dir); // vaskovsky
		$dir = dirname($dir); // vendor
		$dir = dirname($dir); // your application
		$this->dir = $dir;
	}

	/**
	 * Returns the application context.
	 */
	public static function getInstance()
	{
		//
		static $instance = null;
		if(is_null($instance)) {$instance = new ApplicationContext();}
		return $instance;
	}

	/**
	 * Sets a locale to use with this page.
	 *
	 * @param string $locale
	 *        	is the locale name.
	 *
	 * @throws InvalidArgumentException if `$locale` is empty.
	 */
	public function setLocale($locale)
	{
		// locale: -empty
		if (!is_string($locale) || empty($locale)) {
			throw new \InvalidArgumentException();
		}
		//
		putenv("LC_ALL=" . $locale);
		setlocale(LC_ALL, $locale);
		$domain = "messages";
		bindtextdomain($domain, $this->getFile("locale"));
		textdomain($domain);
	}

	/**
	 * Sets the application directory.
	 *
	 * @param string $directory
	 *        	is a directory name.
	 *
	 * @throws InvalidArgumentException if `$directory` is empty.
	 */
	public final function setDirectory($directory)
	{
		// directory: -empty
		if(!is_string($directory) || empty($directory)) {
			throw new \InvalidArgumentException();
		}
		//
		return $this->dir = $directory;
	}

	/**
	 * Returns the application directory path; never null.
	 */
	public final function getDirectory()
	{
		//
		return $this->dir;
	}

	/**
	 * Returns a file path relative to the application directory.
	 *
	 * @param string $filename
	 *        	is a file name.
	 *
	 * @throws InvalidArgumentException if `$filename` is empty.
	 */
	public final function getFile($filename)
	{
		// filename: -empty
		if (!is_string($filename) || empty($filename)) {
			throw new \InvalidArgumentException();
		}
		//
		if($filename[0] != '/') {$filename = '/' . $filename;}
		return $this->dir . $filename;
	}

	/**
	 * Sets the application URL.
	 *
	 * @param string $url
	 *        	is the application URL.
	 *
	 * @throws InvalidArgumentException if `$url` is null.
	 */
	public final function setURL($url)
	{
		// url: -null
		if (!is_string($url)) {throw new \InvalidArgumentException();}
		//
		$this->application_url = $url;
	}

	/**
	 * Returns the application URL; never null.
	 */
	public final function getURL()
	{
		//
		return $this->url;
	}

	/**
	 * Returns a path relative to the application URL.
	 *
	 * @param string $path
	 *        	is a relative path.
	 *
	 * @throws InvalidArgumentException if `$path` is null.
	 */
	public final function getPath($path)
	{
		// path: -empty
		if (!is_string($path) || empty($path)) {
			throw new \InvalidArgumentException();
		}
		//
		if($path[0] != '/') {$path .= '/' . $path;}
		return $this->url . $path;
	}
}
