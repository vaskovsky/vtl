-- Web Application Database Example.
--
-- Copyright © 2017 Alexey Vaskovsky.
--
-- This file is free software; you can redistribute it and/or
-- modify it under the terms of the GNU Lesser General Public
-- License as published by the Free Software Foundation; either
-- version 3.0 of the License, or (at your option) any later version.
--
-- This file is distributed in the hope that it will be useful,
-- but WITHOUT ANY WARRANTY; without even the implied warranty of
-- MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
-- Lesser General Public License for more details.
--
-- You should have received a copy of the GNU Lesser General Public
-- License along with this file. If not, see
-- <http://www.gnu.org/licenses/>

-- Accounts

create table account (
	id serial not null primary key,
	username text not null unique,
	password text not null,
	role_admin bool not null
);

insert into account	(
	username,
	password,
	role_admin
) values (
	'admin',
	'$2y$10$EBKd/1R/d/nRd41.jBqZKeQeLhx5x/OGr1KKaq1DS4Kwbj3UBvtEy', -- admin
	true
);

-- Installation

create table install (
	name text		not null primary key,
	major_version	integer not null,
	minor_version	integer not null
);

insert into install (name, major_version, minor_version)
values ('web-application-example',	3, 0);

-- The End
