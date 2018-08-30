\c postgres
drop database if exists ajax_app;
create database ajax_app;
\c ajax_app
create table account
(
	account_id		serial	not null primary key,
	login			text	not null unique,
	password		text	not null,
	is_admin		boolean	not null default false
);
create table product
(
	product_id		serial			not null primary key,
	product_name	text			not null,
	image			text			not null,
	description		text,
	price			decimal(18,2)	not null
);
insert into account (login, password, is_admin)
values ('admin', '$2y$10$bRVXD4RlrS1BzOLi4p7sOePwpMTqfaYeh5NDqcy3dxp9SVZmXYwHa', true);
insert into product (product_name, image, description, price)
values ('Часы некоторой марки', 'product.jpeg', 'Детальное описание продукта', 123.45);
