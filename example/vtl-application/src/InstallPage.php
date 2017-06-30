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
 * Installs/updates the database.
 *
 * @author Alexey Vaskovsky
 */
class InstallPage extends ApplicationPage
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
			$dbh = $this->getDatabase();
			$app_name = $dbh->quote("web-application-example");
			$get_version_sql = "select * from install where name = $app_name";
			try {
				$install = $dbh->query($get_version_sql)->fetchObject();
			} catch (\PDOException $ex) {
				$install = null;
			}

			// Installation

			if (is_null($install)) {
				echo "* $msg_installing 1.0\n";
				flush();
				$sql = "create table install";
				$sql .= "(name text not null primary key,";
				$sql .= "major_version integer not null,";
				$sql .= "minor_version integer not null)";
				$dbh->exec($sql);
				$sql = "insert into install(name,major_version,minor_version)";
				$sql .= "values($app_name, 1, 0)";
				$dbh->exec($sql);
				$install = $dbh->query($get_version_sql)->fetchObject();
			}

			// Version 1.x

			if ($install->major_version == 1) {

				// Version 1.0

				if ($install->minor_version == 0) {
					echo "* $msg_installing 1.1\n";
					flush();
					$sql = "create table account";
					$sql .= "(id serial not null primary key,";
					$sql .= "username text not null unique,";
					$sql .= "password text not null,";
					$sql .= "role_admin bool not null)";
					$dbh->exec($sql);
					$hash = $this->getAuthentication()->getPasswordHash("admin");
					$hash = $dbh->quote($hash);
					$sql = "insert into account(username,password,role_admin)";
					$sql .= "values('admin',$hash,true)";
					$dbh->exec($sql);
					$sql = "update install set minor_version = 1 ";
					$sql .= "where name = $app_name and major_version = 1";
					$dbh->exec($sql);
					$install = $dbh->query($get_version_sql)->fetchObject();
				}

				// Unknown version

				else if($install->minor_version != 1) {
					$errmsg = _("Incompatible database version") . ": ";
					$errmsg .= $install->major_version . ".";
					$errmsg .= $install->minor_version . "\n";
					die($errmsg);
				}
			}

			// Unknown version

			else {
				$errmsg = _("Incompatible database version");
				$errmsg .= ": {$install->major_version}\n";
				die($errmsg);
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
