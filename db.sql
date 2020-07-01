create table images
(
	id int auto_increment
		primary key,
	image_raw mediumblob null,
	filename varchar(255) null,
	mime varchar(255) null
);
