create table user (
	user_id		         int,
	full_name		     varchar(100),
	username		     varchar(30) not null,
	password             varchar(200) not null,
	email                varchar(254),
	phone_num            varchar(20),
	birthday             date,
	primary key (user_id)
) ENGINE=INNODB;

create table book_details (
	ISBN                 varchar(20),
	title   	         varchar(100) not null,
	author		         varchar(200),
	publisher		     varchar(50),
	publish_date         date,
	version              varchar(10),
	page_num             int,
	language             varchar(20),
	tot_qty              int,
	avail_qty            int,
	primary key (ISBN)
) ENGINE=INNODB;

create table book (
	book_id	             int,
	ISBN                 varchar(20) not null,
	primary key (book_id),
	foreign key (ISBN) references book_details (ISBN)
		on delete cascade on update cascade
) ENGINE=INNODB;

create table book_genre (
	ISBN                 varchar(20) not null,
	genre                varchar(100),
	primary key (ISBN, genre),
	foreign key (ISBN) references book_details (ISBN)
		on delete cascade on update cascade
) ENGINE=INNODB;

create table dvd_details (
	title   	         varchar(100) not null,
	release_date         date,
	publish_company      varchar(50),
	actor		         varchar(200),
	director		     varchar(30),
	duration             int,
	language             varchar(20),
	tot_qty              int,
	avail_qty            int,
	primary key (title, release_date, publish_company)
) ENGINE=INNODB;

create table dvd (
	dvd_id	             int,
	title   	         varchar(100) not null,
	release_date         date,
	publish_company      varchar(50),
	primary key (dvd_id),
	foreign key (title, release_date, publish_company) references dvd_details (title, release_date, publish_company)
		on delete cascade on update cascade
) ENGINE=INNODB;

create table dvd_genre (
	title   	         varchar(100) not null,
	release_date         date,
	publish_company      varchar(50),
	genre                varchar(100),
	primary key (title, release_date, publish_company, genre),
	foreign key (title, release_date, publish_company) references dvd_details (title, release_date, publish_company)
		on delete cascade on update cascade
) ENGINE=INNODB;

create table staff (
	staff_id             int,
	name		         varchar(100),
	username		     varchar(30) not null,
	password             varchar(200) not null,
	email                varchar(254),
	phone_num            varchar(20),
	birthday             date,
	primary key (staff_id)
) ENGINE=INNODB;

create table room (
	room_id	             int,
	floor		         int,
	capacity             int,
	primary key (room_id)
) ENGINE=INNODB;

create table book_borrow (
	user_id              int,
	book_id		         int,
	staff_id             int,
	borrow_date          date,
	return_ddl           date,
	status               varchar(10),
	primary key (user_id, book_id, borrow_date, return_ddl),
	foreign key (user_id) references user (user_id)
		on delete cascade on update cascade,
	foreign key (book_id) references book (book_id)
		on delete cascade on update cascade,
	foreign key (staff_id) references staff (staff_id)
		on delete set null on update cascade
) ENGINE=INNODB;

create table dvd_borrow (
	user_id              int,
	dvd_id		         int,
	staff_id             int,
	borrow_date          date,
	return_ddl           date,
	status               varchar(10),
	primary key (user_id, dvd_id, borrow_date, return_ddl),
	foreign key (user_id) references user (user_id)
		on delete cascade on update cascade,
	foreign key (dvd_id) references dvd (dvd_id)
		on delete cascade on update cascade,
	foreign key (staff_id) references staff (staff_id)
		on delete set null on update cascade
) ENGINE=INNODB;

create table activity (
	user_id              int,
	room_id		         int,
	staff_id             int,
	activity_name        varchar(100),
	activity_date        date,
	primary key (user_id, room_id, activity_date),
	foreign key (user_id) references user (user_id)
		on delete cascade on update cascade,
	foreign key (room_id) references room (room_id)
		on delete cascade on update cascade,
	foreign key (staff_id) references staff (staff_id)
		on delete set null on update cascade
) ENGINE=INNODB;

create table book_reservation (
	user_id              int,
	book_id		         int,
	queue                int,
	estimation_date      date,
	primary key (user_id, book_id, estimation_date),
	foreign key (user_id) references user (user_id)
		on delete cascade on update cascade,
	foreign key (book_id) references book (book_id)
		on delete cascade on update cascade
) ENGINE=INNODB;

create table dvd_reservation (
	user_id              int,
	dvd_id		         int,
	queue                int,
	estimation_date      date,
	primary key (user_id, dvd_id, estimation_date),
	foreign key (user_id) references user (user_id)
		on delete cascade on update cascade,
	foreign key (dvd_id) references dvd (dvd_id)
		on delete cascade on update cascade
) ENGINE=INNODB;


