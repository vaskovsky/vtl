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
 * An abstract page.
 *
 * @author Alexey Vaskovsky
 */
abstract class AbstractPage
{
	/**
	 * Returns the ApplicationContext instance.
	 *
	 * @see ApplicationContext#getInstance()
	 */
	protected function getContext()
	{
		return ApplicationContext::getInstance();
	}
	/**
	 * @copydoc Database#getConnection()
	 *
	 * @see Database#getConnection()
	 */
	protected final function getDatabase($dsn = "", $user = "", $password = "")
	{
		// dsn: -null @PDO::getConnection
		// user: -null @PDO::getConnection
		// password: -null @PDO::getConnection
		//
		return DatabaseManager::getConnection($dsn, $user, $password);
	}
	/**
	 * Returns an AbstractAuthentication object; never null.
	 *
	 * @throws PDOException if `$this->getDatabase()` throws.
	 *
	 * @see BasicAuthentication
	 */
	protected final function getAuthentication()
	{
		//
		return new BasicAuthentication("", $this->getDatabase(), "Account");
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
				if(!$this->authorize()) {
					$this->getAuthentication()->signOut();
				} else {
					echo call_user_method($method, $this);
				}
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
	protected abstract function render(
		$template, array $view_data = array(), $code = 200);
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
	protected abstract function renderError($message, $code = 500);
	/**
	 * Renders an exception.
	 *
	 * @param Exception $ex
	 *        	is an exception.
	 *
	 * @return a string; never null.
	 */
	protected abstract function renderException(\Exception $ex);
}
