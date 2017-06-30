<?php
/*!
 * Copyright © 2017 Alexey Vaskovsky.
 *
 * This file is part of VTL.
 *
 * VTL is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License
 * as published by the Free Software Foundation, either version 3
 * of the License, or (at your option) any later version.
 *
 * VTL is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with VTL. If not, see <http://www.gnu.org/licenses/>.
 * @file
 */
namespace VTL;
/**
 * An HTML page.
 *
 * @author Alexey Vaskovsky
 */
abstract class HTMLPage extends AbstractPage
{
	/**
	 * @copydoc AbstractPage#render()
	 *
	 * @implements AbstractPage
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
		include $this->getContext()->getFile("view/$template.php");
		$contents = ob_get_contents();
		ob_end_clean();
		return $contents;
	}
	/**
	 * @copydoc AbstractPage#renderError()
	 *
	 * @implements AbstractPage
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
	 * @copydoc AbstractPage#renderException()
	 *
	 * @implements AbstractPage
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
}
