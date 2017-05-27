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
 * An abstract authentication.
 *
 * @author Alexey Vaskovsky
 */
interface AbstractAuthentication
{
	/**
	 * Performs authentication.
	 *
	 * @return true if user is authenticated; false otherwise.
	 */
	public function authenticate();
	/**
	 * Returns an account attribute.
	 *
	 * This method performs authentication if user is not authenticated yet,
	 * loads account attributes and returns a value of the specified attribute.
	 *
	 * @param string $name
	 *        	is an attribute name.
	 *
	 * @throws InvalidArgumentException if `$name` is empty.
	 *
	 * @return the attribute value or null if the authentication failed.
	 */
	public function getAccountAttribute($name);
	/**
	 * Creates a new password hash.
	 *
	 * @param string $password
	 *        	is a password string.
	 *
	 * @throws InvalidArgumentException if `$password` is null.
	 *
	 * @return a string that contains the password hash; never null.
	 */
	public function getPasswordHash($password);
	/**
	 * Signs out.
	 *
	 * @see #authenticate()
	 */
	public function signOut();
}
