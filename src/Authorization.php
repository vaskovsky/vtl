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
namespace Vaskovsky\WebApplication;
/**
 * An authorization.
 *
 * @author Alexey Vaskovsky
 */
interface Authorization
{
	/**
	 * Performs authorization.
	 *
	 * @param string $role
	 *        	is a role name.
	 *
	 * @throws PDOException if a database access error occurs.
	 *
	 * @throws UnexpectedValueException if the database structure is
	 *         inconsistent.
	 *
	 * @throws InvalidArgumentException if `$role` is invalid.
	 *
	 * @return true if the user is authorized; false otherwise.
	 */
	public function authorize($role);
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
}
