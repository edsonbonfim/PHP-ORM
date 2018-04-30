create table posts(
  id int not null primary key auto_increment,
  title varchar(50),
  author_name varchar(50)
);

insert into posts(title,author_name) values('My first post blog!!','Edson Onildo');