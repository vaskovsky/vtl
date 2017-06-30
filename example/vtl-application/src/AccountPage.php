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
namespace Example;
/**
 * The account management page.
 *
 * @extends VTL::CatalogPage
 *
 * @author Alexey Vaskovsky
 */
class AccountPage extends ApplicationPage
{
	protected function authorize()
	{
		//
		return $this->getAuthentication()->getAccountAttribute("role_admin");
	}
	/**
	 * @copydoc VTL::CatalogPage#create()
	 *
	 * @implements VTL::CatalogPage
	 */
	protected function create()
	{
		//
		return [
			"id" => "",
			"username" => "",
			"password" => "",
			"role_admin" => false
		];
	}
	/**
	 * @copydoc VTL::CatalogPage#sanitize()
	 *
	 * @implements VTL::CatalogPage
	 */
	protected function sanitize($x)
	{
		// x: object -null @CatalogPage
		return [
			"id" => (int) trim(@$x->id),
			"username" => trim(@$x->username),
			"password" => trim(@$x->password),
			"role_admin" => (bool) trim(@$x->role_admin)
		];
	}
	/**
	 * @copydoc VTL::CatalogPage#validateUpdate()
	 *
	 * @implements VTL::CatalogPage
	 */
	protected function validateUpdate($x)
	{
		// x: sanitized model -null @CatalogPage
		if (empty($x->password)) {
 			if (empty($x->username))
				return "Empty username";
		}
	}
	/**
	 * @copydoc VTL::CatalogPage#validateInsert()
	 *
	 * @implements VTL::CatalogPage
	 */
	protected function validateInsert($x)
	{
		// x: sanitized model -null @CatalogPage
		if (empty($x->password))
			return "Empty password";
		return $this->validateUpdate($x);
	}
	/**
	 * @copydoc VTL::CatalogPage#select()
	 *
	 * @implements VTL::CatalogPage
	 */
	protected function select($x)
	{
		// x: sanitized model -null @CatalogPage
		$dbh = $this->getDatabase();
		$sql = "select * from account";
		return $dbh->query($sql);
	}
	/**
	 * @copydoc VTL::CatalogPage#get()
	 *
	 * @implements VTL::CatalogPage
	 */
	protected function get($x)
	{
		// x: sanitized model -null @CatalogPage
		$dbh = $this->getDatabase();
		$sql = "select * from account where ";
		$sql .= "id = " . (int) $x->id;
		return $dbh->query($sql)->fetchObject();
	}
	/**
	 * @copydoc VTL::CatalogPage#insert()
	 *
	 * @implements VTL::CatalogPage
	 */
	protected function insert($x)
	{
		// x: valid model -null @CatalogPage
		$hash = $this->getAuthentication()->getPasswordHash($x->password);
		$dbh = $this->getDatabase();
		$sql = "insert into account (";
		$sql .= "username, password, role_admin";
		$sql .= ") values (";
		$sql .= $dbh->quote($x->username) . ", ";
		$sql .= $dbh->quote($hash) . ", ";
		$sql .= ($x->role_admin ? "true" : "false") . ")";
		return $dbh->exec($sql);
	}
	/**
	 * @copydoc VTL::CatalogPage#update()
	 *
	 * @implements VTL::CatalogPage
	 */
	protected function update($x)
	{
		// x: valid model -null @CatalogPage
		$dbh = $this->getDatabase();
		$sql = "update account set ";
		if(empty($x->password)) {
			$sql .= "username = " . $dbh->quote($x->username) . ", ";
			$sql .= "role_admin = ";
			$sql .= ($x->role_admin ? "true" : "false") . " ";
		} else {
			$hash = $this->getAuthentication()->getPasswordHash($x->password);
			$sql .= "password = " . $dbh->quote($hash);
		}
		$sql .= "where id = " . (int) $x->id;
		return $dbh->exec($sql);
	}
	/**
	 * @copydoc VTL::CatalogPage#delete()
	 *
	 * @implements VTL::CatalogPage
	 */
	protected function delete($x)
	{
		// x: sanitized model -null @CatalogPage
		$dbh = $this->getDatabase();
		$sql = "delete from account where id = " . (int) $x->id;
		return $dbh->exec($sql);
	}
	use \VTL\CatalogPage;
}
