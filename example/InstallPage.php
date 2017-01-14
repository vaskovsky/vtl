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
 * Installs/updates the database.
 *
 * @author Alexey Vaskovsky
 */
class InstallPage extends Page
{
	/**
	 * The GET action.
	 *
	 * @return a string; never null.
	 */
	public function doGet()
	{
		//
		header("Content-Type: text/plain;charset=UTF-8");
		try {
			$msg_installing = _("Installing version");
			$pdo = $this->getPDO();
			$app_name = $pdo->quote("web-application-example");
			$get_version_sql = "select * from Install where name = $app_name";
			try {
				$install = $pdo->query($get_version_sql)->fetchObject();
			} catch (\PDOException $ex) {
				$install = null;
			}
			if (is_null($install)) {
				echo "* $msg_installing 1.0\n";
				flush();
				$sql = "create table Install";
				$sql .= "(name text not null primary key,";
				$sql .= "major_version integer not null,";
				$sql .= "minor_version integer not null)";
				$pdo->exec($sql);
				$sql = "insert into Install(name,major_version,minor_version)";
				$sql .= "values($app_name, 1, 0)";
				$pdo->exec($sql);
				$install = $pdo->query($get_version_sql)->fetchObject();
			}
			if ($install->major_version != 1) {
				$errmsg = _("Incompatible database version");
				$errmsg .= ": {$install->major_version}\n";
				die($errmsg);
			} else {
				if ($install->minor_version < 1) {
					echo "* $msg_installing 1.1\n";
					flush();
					$sql = "create table Account";
					$sql .= "(id serial not null primary key,";
					$sql .= "username text not null unique,";
					$sql .= "password text not null,";
					$sql .= "role_admin bool not null)";
					$pdo->exec($sql);
					$hash = $this->getAuthorization()->getPasswordHash("admin");
					$hash = $pdo->quote($hash);
					$sql = "insert into Account(username,password,role_admin)";
					$sql .= "values('admin',$hash,true)";
					$pdo->exec($sql);
					$sql = "update Install set minor_version = 1 ";
					$sql .= "where name = $app_name and major_version = 1";
					$pdo->exec($sql);
					$install = $pdo->query($get_version_sql)->fetchObject();
				}
			}
			$msg = _("OK");
			$msg .= ". ";
			$msg .= _("Current version");
			$msg .= ": {$install->major_version}.{$install->minor_version}\n";
			echo $msg;
		} catch (\Exception $ex) {
			die("ERROR: $ex\n");
		}
	}
}
