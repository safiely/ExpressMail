drop database expressmail;
create database expressmail;
use expressmail;

create table customers
(
	cid int unsigned not null auto_increment,
	email varchar(100) not null,
	password char(40) not null,
	firstname varchar(30) not null,
	lastname varchar(30) not null,
	chinesename varchar(30) not null,
	phonenumber int unsigned not null,
	location char(80),
	primary key (customerid)
);

create table accounts
(
	accountid int unsigned not null auto_increment,
	customerid int unsigned not null references customers(customerid),
	balance float(8, 2) not null,
	zfbrecord float(8, 2) not null,
	paypalrecord float(8, 2) not null,
	cardrecord float(8, 2) not null,
	primary key (accountid)
);

create table recipient
(
	recipientid int unsigned not null auto_increment,
	customerid int unsigned not null references customers(customerid),
	recipientname varchar(40) not null,
	recipientaddress char(80) not null,
	city char(40) not null,
	state char(20) not null,
	zip char(10) not null,
	country char(20) not null,
	phonenumber char(20) not null,
	primary key (recipientid)
);

create table sender
(
	senderid int unsigned not null auto_increment,
	customerid int unsigned not null references customers(customerid),
	sendername varchar(40) not null,
	senderaddress char(80) not null,
	city char(40) not null,
	state char(20) not null,
	zip char(10) not null,
	country char(20) not null,	
	phonenumber char(20) not null,
	primary key (senderid)
);

create table package
(
	packageid int unsigned not null auto_increment primary key,
	customerid int unsigned not null references customers(customerid),
	storage char(50) not null,
	dilivermethod char(50) not null,
	tracknumber char(50) not null,
	note varchar(250) not null,
	packagestatus char(10) not null
);

create table orders
(
	trackingnumber varchar(100) not null primary key,
	customerid int unsigned not null references customers(customerid),
	packageid int unsigned not null,
	orderstatus varchar(100) not null,
	item1 char(50) not null,
	item2 char(50) not null,
	item3 char(50) not null,
	item4 char(50) not null,
	item5 char(50) not null
);

create table admin
(
	username char(15) not null primary key,
	password char(15) not null
);

grant select, insert, update, delete on expressmail.*
to em_user@localhost identified by 'password';