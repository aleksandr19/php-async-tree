create table tree
    (id integer not null auto_increment,
    parent_id integer not null,
    `level` integer,
    `description` varchar(50),
    image_name varchar(255),
    `url` varchar(255),
    constraint tree_pk primary key (id)
)
