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
namespace AVaskovsky\WebApplication;
/**
 * An abstract page.
 *
 * @author Alexey Vaskovsky
 */
abstract class AbstractPage
{
	//
	//	PATHS
	//--------------------------------------------------------------------------
	/**
	 * Sets the application URL.
	 *
	 * @param string $url
	 *        	is the application URL.
	 *
	 * @throws InvalidArgumentException if `$url` is null.
	 */
	protected final function setApplicationURL($url)
	{
		// url: -null
		if (! is_string($url)) {
			throw new \InvalidArgumentException();
		}
		//
		$this->application_url = $url;
	}
	/**
	 * Returns a path relative to the application URL.
	 *
	 * @param string $path
	 *        	is a relative path.
	 *
	 * @throws InvalidArgumentException if `$path` is null.
	 */
	protected final function getApplicationURL($path)
	{
		// filename: -null
		if (! is_string($path)) {
			throw new \InvalidArgumentException();
		}
		//
		$url = $this->application_url;
		if(empty($path)) {
			return $url;
		}
		if($path[0] != '/') {
			$url .= '/';
		}
		$url .= $path;
		return $url;
	}
	/**
	 * Sets the application directory.
	 *
	 * @param string $directory
	 *        	is a directory name.
	 *
	 * @throws InvalidArgumentException if `$directory` is empty.
	 */
	protected final function setApplicationDirectory($directory)
	{
		// directory: -empty
		if (! is_string($directory) || empty(
			$directory)) {
			throw new \InvalidArgumentException();
		}
		//
		$this->application_path = $directory;
	}
	/**
	 * Returns a file path relative to the application directory.
	 *
	 * @param string $filename
	 *        	is a file name.
	 *
	 * @throws InvalidArgumentException if `$filename` is empty.
	 */
	protected final function getApplicationFile($filename)
	{
		// filename: -empty
		if (empty($filename)) {
			throw new \InvalidArgumentException();
		}
		//
		if (empty($this->application_path)) {
			$dir = __DIR__; // src
			$dir = dirname($dir); // web-application
			$dir = dirname($dir); // vaskovsky
			$dir = dirname($dir); // vendor
			$dir = dirname($dir); // your application
			$this->application_path = $dir;
		}
		$file = $this->application_path;
		if(empty($filename)) {
			return $file;
		}
		if($filename[0] != '/') {
			$file .= '/';
		}
		$file .= $filename;
		return $file;
	}
	//
	//	REFLECTION
	//--------------------------------------------------------------------------
	/**
	 * Returns `new \ReflectionClass($this)`.
	 */
	public function getClass()
	{
		//
		return new \ReflectionClass($this);
	}
	/**
	 * Returns short class name without 'Page' suffix.
	 */
	public function getPageName()
	{
		$name = $this->getClass()->getShortName();
		$name = preg_replace('/(_[Pp]|P)age$/', '', $name);
		return $name;
	}
	//
	//	LOCALIZATION
	//--------------------------------------------------------------------------
	/**
	 * Sets a locale to use with this page.
	 *
	 * @param string $locale
	 *        	is the locale name.
	 *
	 * @throws InvalidArgumentException if `$locale` is empty.
	 */
	protected function setLocale($locale)
	{
		// locale: -empty
		if (! is_string($locale) || empty($locale)) {
			throw new \InvalidArgumentException();
		}
		//
		putenv("LC_ALL=" . $locale);
		setlocale(LC_ALL, $locale);
		$domain = "messages";
		bindtextdomain($domain, $this->getApplicationFile("locale"));
		textdomain($domain);
	}
	//
	//	DATABASE
	//--------------------------------------------------------------------------
	/**
	 * Opens a database connection to use in this application.
	 *
	 * @param string $dsn
	 *        	is a string that contains the information required to connect
	 *        	to the database.
	 *
	 * @param string $user
	 *        	is a user name for the DSN string.
	 *
	 * @param string $password
	 *        	is a password for the DSN string.
	 *
	 * @throws PDOException if a database access error occurs.
	 *
	 * @throws InvalidArgumentException :
	 *         if `$dsn` is empty;
	 *         if `$user` is null;
	 *         if `$password` is null.
	 */
	protected final function openPDO($dsn, $user = "", $password = "")
	{
		// dsn: -empty
		if (! is_string($dsn) || empty($dsn)) {
			throw new \InvalidArgumentException();
		}
		// user: -null
		if (! is_string($user)) {
			throw new \InvalidArgumentException();
		}
		// password: -null
		if (! is_string($password)) {
			throw new \InvalidArgumentException();
		}
		//
		if (empty($user)) {
			$user = null;
		}
		if (empty($password)) {
			$password = null;
		}
		$this->pdo = new \PDO(
			$dsn,
			$user,
			$password,
			array(
				\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
				\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ
			));
	}
	/**
	 * Returns a PDO connection.
	 *
	 * @throws PDOException if a database access error occurs.
	 *
	 * @see #openPDO()
	 */
	protected final function getPDO()
	{
		//
		if (is_null($this->pdo))
			$this->openPDO("pgsql:", "", "");
		return $this->pdo;
	}
	//
	//	AUTHORIZATION
	//--------------------------------------------------------------------------
	/**
	 * Sets an authentication to use with this page.
	 *
	 * @param AbstractAuthentication $auth
	 *        	is an authentication.
	 *
	 * @throws InvalidArgumentException if `$auth` is null.
	 */
	protected final function setAuthentication(AbstractAuthentication $auth)
	{
		// auth: -null @prototype
		$this->auth = $auth;
	}
	/**
	 * Returns an AbstractAuthentication object; never null.
	 *
	 * @throws PDOException if `$this->getPDO()` throws.
	 */
	protected final function getAuthentication()
	{
		//
		if (is_null($this->auth)) {
			$this->auth = new BasicAuthentication("", $this->getPDO(), "Account");
		}
		return $this->auth;
	}
	/**
	 * Performs authorization.
	 *
	 * @return true if user is authorized; false otherwise.
	 */
	protected function authorize()
	{
		//
		return true;
	}
	/**
	 * Performs authorization by the account attribute.
	 *
	 * @param string $attribute
	 *			is an account attribute name.
	 *
	 * @return true if user is authorized; false otherwise.
	 * @see #authorize()
	 */
	protected function authorizeByAttribute($attribute)
	{
		//
		if(!!$this->getAuthentication()->getAccountAttribute($attribute)) {
			return true;
		} else {
			$this->getAuthentication()->signOut();
			return false;
		}
	}
	/**
	 * Performs authorization by the page name.
	 *
	 * @param array $public_pages
	 *			are list of page names.
	 *
	 * @return true if user is authorized; false otherwise.
	 * @see #authorize()
	 */
	protected function authorizeByPageName(array $public_pages = array())
	{
		//
		$page_name = $this->getPageName();
		if(in_array($page_name, $public_pages)) return true;
		$role_attr = "is_" . strtolower($page_name) . "_manager";
		return $this->authorizeByAttribute($role_attr);
	}
	//
	//	VIEW
	//--------------------------------------------------------------------------
	/**
	 * Renders a view.
	 *
	 * @param string $template
	 *        	is a template name.
	 *
	 * @param array $view_data
	 *        	is an associative array that contains a view data.
	 *
	 * @param int $code
	 *        	is an HTTP status code.
	 *
	 * @throws InvalidArgumentException :
	 *         if `$template` is empty;
	 *         if `$code` is out of the bounds 100..599.
	 *
	 * @return a string; never null.
	 */
	protected function render($template, array $view_data = array(), $code = 200)
	{
		// template: -empty
		if (! is_string($template) || empty($template)) {
			throw new \InvalidArgumentException();
		}
		// view_data: -null @prototype
		// code: 100..599
		if (! is_int($code) || $code < 100 || $code > 599) {
			throw new \InvalidArgumentException($code);
		}
		//
		if ($code != 200)
			http_response_code($code);
		extract($view_data);
		ob_start();
		include $this->getApplicationFile("view/$template.php");
		$contents = ob_get_contents();
		ob_end_clean();
		return $contents;
	}
	/**
	 * Renders an error.
	 *
	 * @param string $message
	 *        	is an error message.
	 *
	 * @param int $code
	 *        	is an HTTP status code.
	 *
	 * @throws InvalidArgumentException :
	 *         if `$message` is null;
	 *         if `$code` is out of the bounds 100..599.
	 *
	 * @return a string; never null.
	 */
	protected function renderError($message, $code = 500)
	{
		// message: -null
		if (! is_string($message)) {
			throw new \InvalidArgumentException();
		}
		// code: 100..599
		if (! is_int($code) || $code < 100 || $code > 599) {
			throw new \InvalidArgumentException();
		}
		//
		return $this->render(
			"ErrorView",
			array(
				"code" => $code,
				"message" => $message
			),
			$code);
	}
	/**
	 * Renders an exception.
	 *
	 * @param Exception $ex
	 *        	is an exception.
	 *
	 * @return a string; never null.
	 */
	protected function renderException(\Exception $ex)
	{
		// ex: -null @prototype
		$file = basename($ex->getFile());
		$line = $ex->getLine();
		$message = $ex->getMessage();
		$classname = get_class($ex);
		return $this->renderError("$message ($classname@$file:$line)", 500);
	}
	/**
	 * Handles a server request and displays this page.
	 */
	public final function show()
	{
		//
		$action = @$_REQUEST["action"];
		if (! isset($action))
			$action = $_SERVER["REQUEST_METHOD"];
		assert($action != null);
		$action = strtolower($action);
		$method = "do" . ucwords($action);
		if (method_exists($this, $method)) {
			try {
				if (!$this->authorize())
					return;
				echo call_user_method($method, $this);
			} catch (\Exception $ex) {
				echo $this->renderException($ex);
			}
		} else {
			$classname = get_class($this);
			echo $this->renderError(
				_("Method not found") . ": {$classname}::{$method}",
				404);
		}
	}
	//	PRIVATE
	//--------------------------------------------------------------------------
	private $pdo = null;
	private $auth = null;
	private $application_path = null;
	private $application_url = "";
}
