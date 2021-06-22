drop database if exists lexiquejaponais;
create database lexiquejaponais character set UTF8;
use lexiquejaponais;

create table users
(
    id         int auto_increment not null primary key,
    pseudo     varchar(50)        not null,
    pass       varchar(100)       not null,
    mail       varchar(100)       not null unique,
    slug       varchar(50)        not null unique,
    token      char(36),
    rights     boolean            not null default 0,
    created_at datetime           not null default now(),
    updated_at datetime           not null default now() on update now()
) engine = InnoDB;

create table lang
(
    id         char(2)     not null primary key,
    label      varchar(40) not null,
    created_at datetime    not null default now()
) engine = InnoDB;

create table information
(
    id           int         not null primary key references users (id),
    words        int         not null default 20,
    icon         varchar(50) not null default 0,
    theme        varchar(50) not null default 0,
    background   varchar(50) not null default 0,
    life         int         not null default 10,
    kanji        boolean     not null default 1,
    sakura       int         not null default 1000,
    sakura_total int         not null default 1000
) engine = InnoDB;

create table type
(
    id         int auto_increment not null primary key,
    type       varchar(80)        not null,
    type_jp    varchar(80),
    created_at datetime           not null default now(),
    updated_at datetime           not null default now() on update now()
) engine = InnoDB;

create table translations
(
    id         int auto_increment not null primary key,
    label      varchar(255)       not null,
    slug       varchar(255)       not null,
    lang       enum ('fr', 'en', 'es', 'pt')  not null,
    created_at datetime           not null default now(),
    updated_at datetime           not null default now() on update now()
) engine = InnoDB;

create table jp
(
    id          int auto_increment not null primary key,
    kanji       varchar(255)       not null,
    kana        varchar(255)       not null,
    roman       varchar(255)       not null,
    description longtext,
    view        int                not null default 0,
    jlpt        int                not null default 0 check (jlpt >= 0 && jlpt < 6),
    type        int                not null references type (id),
    created_at  datetime           not null default now(),
    updated_at  datetime           not null default now() on update now()
) engine = InnoDB;

create table jp_links
(
    id          int auto_increment not null,
    origin      int                not null references jp (id),
    translation int                not null references translations (id),
    created_at  datetime           not null default now(),
    primary key (id, origin)
) engine = InnoBD;

create table jp_kanji
(
    id         int auto_increment not null primary key,
    kanji      char(1)            not null,
    strokes    int                not null,
    grade      int                not null,
    on_read    varchar(100),
    kun_read   varchar(100),
    sens_fr    longtext,
    sens_en    longtext,
    created_at datetime           not null default now(),
    updated_at datetime           not null default now() on update now()
) engine = InnoDB;

create table jp_kanji_links
(
    id         int auto_increment not null primary key,
    jp         int                not null references jp (id),
    kanji      int                not null references jp_kanji (id),
    created_at datetime           not null default now()
) engine = InnoDB;

create table cn
(
    id          int auto_increment not null primary key,
    kanji       varchar(255)       not null,
    roman       varchar(255)       not null,
    description longtext,
    view        int                not null default 0,
    created_at  datetime           not null default now(),
    updated_at  datetime           not null default now() on update now()
) engine = InnoDB;

create table links_cn
(
    id          int auto_increment not null,
    origin      int                not null references cn (id),
    translation int                not null references translations (id),
    created_at  datetime           not null default now(),
    primary key (id, origin)
) engine = InnoBD;

create table kr
(
    id          int auto_increment not null primary key,
    korean       varchar(255)       not null,
    roman       varchar(255)       not null,
    description longtext,
    view        int                not null default 0,
    created_at  datetime           not null default now(),
    updated_at  datetime           not null default now() on update now()
) engine = InnoDB;

create table links_kr
(
    id          int auto_increment not null,
    origin      int                not null references kr (id),
    translation int                not null references translations (id),
    created_at  datetime           not null default now(),
    primary key (id, origin)
) engine = InnoBD;

delimiter |

create trigger before_insert_user
    before insert
    on users
    for each row
begin
    set new.token = uuid();
    insert into information set id = new.id;
end |

delimiter |

insert into lang(id, label)
values ('jp', 'Japanese'),
       ('cn', 'Chinese'),
       ('kr', 'korean');
