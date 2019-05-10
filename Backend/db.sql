create DATABASE camrent;

use camrent;

create table items
(
  PK_ItemId   int auto_increment
    primary key,
  name        varchar(30) not null,
available   tinyint      not null,
teacherId   int          not null,
description varchar(250) not null
);

create table unverifiedemail
(
  PK_unverifiedEmailId int auto_increment
    primary key,
  email                varchar(100)        not null,
activationCode       varchar(100)        not null,
date                 date                not null,
active               tinyint default '1' null,
constraint unverifiedEmail_PK_unverifiedEmailId_uindex
unique (PK_unverifiedEmailId)
);

create table users
(
  PK_UserId int auto_increment
    primary key,
  email     varchar(100) not null,
password  varchar(200) not null,
firstname varchar(100) not null,
surname   varchar(100) not null,
priority  int(1)       not null,
lastLogin date         not null,
constraint email
unique (email)
);

create table borrow
(
  begin_date  date not null,
  end_date    date not null,
  teacherId   int  not null,
  PK_borrowId int auto_increment
    primary key,
  PK_UserId   int  not null,
  PK_ItemId   int  null,
  constraint borrow_ibfk_1
  foreign key (PK_UserId) references users (PK_UserId),
constraint borrow_ibfk_2
foreign key (PK_ItemId) references items (PK_ItemId)
);

create index PK_ItemId
  on borrow (PK_ItemId);

create index PK_UserId
  on borrow (PK_UserId);

create table borrow_history
(
  begin_date  date not null,
  end_date    date not null,
  teacherId   int  not null,
  PK_borrowId int auto_increment
    primary key,
  PK_UserId   int  null,
  PK_ItemId   int  not null,
  constraint borrow_history_ibfk_3
  foreign key (teacherId) references users (PK_UserId),
constraint borrow_history_ibfk_4
foreign key (teacherId) references users (PK_UserId),
constraint borrow_history_ibfk_2
foreign key (PK_UserId) references users (PK_UserId),
constraint borrow_history_ibfk_1
foreign key (PK_ItemId) references items (PK_ItemId)
);

create index PK_ItemId
  on borrow_history (PK_ItemId);

create index borrow_history_PK_UserId_index
  on borrow_history (PK_UserId);

create index teacherId
  on borrow_history (teacherId);
