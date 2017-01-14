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
namespace Vaskovsky\WebApplicationExample;
/**
 * An abstract application page.
 *
 * @author Alexey Vaskovsky
 */
abstract class Page extends \Vaskovsky\WebApplication\Page
{
	/**
	 * Creates a new application page.
	 */
	public final function __construct()
	{
		//
		$this->setApplicationPath(dirname(__DIR__));
		$this->setApplicationURL("/web-application");
		$this->openPDO("pgsql:");
		// Uncomment to try internationalization capabilities.
		//$this->setLocale("ru_RU.utf8");
	}
}
