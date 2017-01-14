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
 * Performs basic HTTP authentication and authorization.
 *
 * @author Alexey Vaskovsky
 */
class BasicAuthorization implements Authorization
{
	/**
	 * Creates a new instance.
	 *
	 * @param string $realm
	 *        	is a realm string for the HTTP Authentication.
	 *
	 * @param PDO $pdo
	 *        	is a PDO connection.
	 *
	 * @param string $table
	 *        	is a table name where user data is stored.
	 *
	 * @throws InvalidArgumentException :
	 *         if `$pdo` is null;
	 *         if `$table` is empty.
	 */
	public function __construct($realm, \PDO $pdo, $table)
	{
		// realm: +null
		if (is_null($realm)) {
			$realm = "";
		}
		if (! is_string($realm)) {
			throw new \InvalidArgumentException();
		}
		// pdo: -null
		if (is_null($pdo)) {
			throw new \InvalidArgumentException();
		}
		// table: -empty
		if (! is_string($table) || empty($table)) {
			throw new \InvalidArgumentException();
		}
		//
		$this->realm = $realm;
		$this->pdo = $pdo;
		$this->table = $table;
	}
	/**
	 * @copydoc Authorization#getPasswordHash()
	 *
	 * @see Authorization#getPasswordHash()
	 */
	public function getPasswordHash($password)
	{
		// password: -null
		if (! is_string($password)) {
			throw new \InvalidArgumentException();
		}
		//
		return password_hash($password, PASSWORD_BCRYPT);
	}
	/**
	 * @copydoc Authorization#authorize()
	 *
	 * @see Authorization#authorize()
	 * @see #__construct()
	 */
	public function authorize($role)
	{
		// role: -empty
		if (! is_string($role) || empty($role)) {
			throw new \InvalidArgumentException();
		}
		//
		if ($this->processAutorization($role))
			return true;
		$www_authenticate = "WWW-Authenticate: Basic";
		if (! empty($this->realm))
			$www_authenticate .= "realm=\"{$this->realm}\"";
		header($www_authenticate);
		// header("HTTP/1.0 401 Unauthorized");
		// exit();
		http_response_code(401);
		return false;
	}
	// Private
	private function processAutorization($role)
	{
		// role: -empty @authorize
		if (is_null($this->account)) {
			if (! isset($_SERVER["PHP_AUTH_USER"]))
				return false;
			$username = $_SERVER['PHP_AUTH_USER'];
			if (empty($username))
				return false;
			$acc_sql = "select * from {$this->table} where username = ";
			$acc_sql .= $this->pdo->quote($username);
			$account = $this->pdo->query($acc_sql)->fetchObject();
			if (is_null($account))
				return false;
			$hash = $account->password;
			if (empty($hash)) {
				throw new \UnexpectedValueException(
					_("Empty password") . ": {$account->username}");
			}
			$password = $_SERVER['PHP_AUTH_PW'];
			if (! password_verify($password, $hash))
				return false;
			$this->account = $account;
		}
		$roleField = "role_$role";
		if (! isset($this->account->{$roleField})) {
			$errmsg = _("Role is not set");
			$errmsg .= ": {$roleField}";
			$errmsg .= "; username = {$this->account->username}";
			throw new \UnexpectedValueException($errmsg);
		}
		if (! $this->account->{$roleField}) {
			$this->account = null;
			return false;
		}
		return true;
	}
	private $account = null;
	private $realm;
	private $pdo;
	private $table;
}
