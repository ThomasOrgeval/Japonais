drop database if exists lexiquejaponais;
create database lexiquejaponais character set UTF8;
use lexiquejaponais;

create table users
(
    id         int auto_increment not null primary key,
    pseudo     varchar(50)        not null,
    pass       varchar(100)       not null,
    mail       varchar(100)       not null,
    slug       varchar(50)        not null,
    token      varchar(255)       not null,
    rights     boolean            not null,
    created_at datetime           not null,
    updated_at datetime           not null
) engine = InnoDB;

create table information
(
    id         int         not null primary key,
    words      int         not null,
    icon       varchar(50) not null,
    theme      varchar(50) not null,
    background varchar(50) not null,
    life       int         not null,
    kanji      boolean     not null,
    foreign key (id) references users (id)
) engine = InnoDB;

delimiter |

create trigger after_insert_user
    after insert
    on users
    for each row
begin
    set rights = 0;
    set created_at = now();
    set updated_at = now();
    insert into information value (new.id, 20, 0, 0, 0, 10, 1);
end |

create trigger after_update_user
    after update
    on users
    for each row
begin
    set updated_at = now();
end |

delimiter |
