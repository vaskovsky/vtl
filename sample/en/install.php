<?php
$ADMIN_PASSWORD = hash("gost-crypto", $ADMIN_PASSWORD);
if(preg_match("/^sqlite:/", $DB_DSN))
{
	if(!isset($sample_version))
	{
		$dbh->exec("create table db_sample(sample_version integer not null primary key)");
		$dbh->exec("insert into db_sample(sample_version) values(0)");
		$sample_version = 0;
	}
	if($sample_version < 1)
	{
		$dbh->exec("create table role(role_id integer not null primary key, role_name text not null)");
		$dbh->exec("update db_sample set sample_version = 1");
		$sample_version = 1;
	}
	if($sample_version < 2)
	{
		$dbh->exec("insert into role(role_id, role_name) values ('1', 'User')");
		$dbh->exec("update db_sample set sample_version = 2");
		$sample_version = 2;
	}
	if($sample_version < 3)
	{
		$dbh->exec("insert into role(role_id, role_name) values ('2', 'Moderator')");
		$dbh->exec("update db_sample set sample_version = 3");
		$sample_version = 3;
	}
	if($sample_version < 4)
	{
		$dbh->exec("insert into role(role_id, role_name) values ('3', 'Administrator')");
		$dbh->exec("update db_sample set sample_version = 4");
		$sample_version = 4;
	}
	if($sample_version < 5)
	{
		$dbh->exec("create table account(account_id integer not null primary key autoincrement, login text not null, password text not null, role_id integer not null)");
		$dbh->exec("update db_sample set sample_version = 5");
		$sample_version = 5;
	}
	if($sample_version < 6)
	{
		$dbh->exec("insert into account(account_id, login, password, role_id) values ('1', '$ADMIN_LOGIN', '$ADMIN_PASSWORD', '3')");
		$dbh->exec("update db_sample set sample_version = 6");
		$sample_version = 6;
	}
}
if(preg_match("/^pgsql:/", $DB_DSN))
{
	if(!isset($sample_version))
	{
		$dbh->exec("create table db_sample(sample_version integer not null primary key)");
		$dbh->exec("insert into db_sample(sample_version) values(0)");
		$sample_version = 0;
	}
	if($sample_version < 1)
	{
		$dbh->exec("create table role(role_id integer not null primary key, role_name text not null)");
		$dbh->exec("update db_sample set sample_version = 1");
		$sample_version = 1;
	}
	if($sample_version < 2)
	{
		$dbh->exec("insert into role(role_id, role_name) values ('1', 'User')");
		$dbh->exec("update db_sample set sample_version = 2");
		$sample_version = 2;
	}
	if($sample_version < 3)
	{
		$dbh->exec("insert into role(role_id, role_name) values ('2', 'Moderator')");
		$dbh->exec("update db_sample set sample_version = 3");
		$sample_version = 3;
	}
	if($sample_version < 4)
	{
		$dbh->exec("insert into role(role_id, role_name) values ('3', 'Administrator')");
		$dbh->exec("update db_sample set sample_version = 4");
		$sample_version = 4;
	}
	if($sample_version < 5)
	{
		$dbh->exec("create table account(account_id serial not null primary key, login text not null, password text not null, role_id integer not null)");
		$dbh->exec("update db_sample set sample_version = 5");
		$sample_version = 5;
	}
	if($sample_version < 6)
	{
		$dbh->exec("insert into account(account_id, login, password, role_id) values ('1', '$ADMIN_LOGIN', '$ADMIN_PASSWORD', '3')");
		$dbh->exec("update db_sample set sample_version = 6");
		$sample_version = 6;
	}
}
if(preg_match("/^mysql:/", $DB_DSN))
{
	if(!isset($sample_version))
	{
		$dbh->exec("create table db_sample(sample_version integer not null primary key)");
		$dbh->exec("insert into db_sample(sample_version) values(0)");
		$sample_version = 0;
	}
	if($sample_version < 1)
	{
		$dbh->exec("create table role(role_id integer not null primary key, role_name varchar(255) not null)");
		$dbh->exec("update db_sample set sample_version = 1");
		$sample_version = 1;
	}
	if($sample_version < 2)
	{
		$dbh->exec("insert into role(role_id, role_name) values ('1', 'User')");
		$dbh->exec("update db_sample set sample_version = 2");
		$sample_version = 2;
	}
	if($sample_version < 3)
	{
		$dbh->exec("insert into role(role_id, role_name) values ('2', 'Moderator')");
		$dbh->exec("update db_sample set sample_version = 3");
		$sample_version = 3;
	}
	if($sample_version < 4)
	{
		$dbh->exec("insert into role(role_id, role_name) values ('3', 'Administrator')");
		$dbh->exec("update db_sample set sample_version = 4");
		$sample_version = 4;
	}
	if($sample_version < 5)
	{
		$dbh->exec("create table account(account_id integer not null primary key auto_increment, login varchar(255) not null, password varchar(255) not null, role_id integer not null)");
		$dbh->exec("update db_sample set sample_version = 5");
		$sample_version = 5;
	}
	if($sample_version < 6)
	{
		$dbh->exec("insert into account(account_id, login, password, role_id) values ('1', '$ADMIN_LOGIN', '$ADMIN_PASSWORD', '3')");
		$dbh->exec("update db_sample set sample_version = 6");
		$sample_version = 6;
	}
}

