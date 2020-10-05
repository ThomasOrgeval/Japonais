drop database if exists japonais;
create database japonais;
use japonais;

create table `USER`
(
    `id`     int auto_increment,
    `pseudo` varchar(255) not null,
    `pass`   varchar(255) not null,
    `mail`   varchar(255) not null,
    `date`   date,
    `droits` int          not null,
    primary key (`id`)
) engine = InnoDB;

create table `WORDS`
(
    `id`     int auto_increment not null,
    `fr`     varchar(255)       not null,
    `jp`     varchar(255)       not null,
    `kanji`  varchar(255)       not null,
    `romaji` varchar(255)       not null,
    primary key (`id`)
) engine = InnoDB,
  character set utf8;

create table `GROUPE`
(
    `id`      int auto_increment not null,
    `libelle` varchar(255)       not null,
    primary key (`id`)
) engine = InnoDB;

create table `LISTES`
(
    `id`      int auto_increment not null,
    `nom`     varchar(255)       not null,
    `id_user` int                not null,
    primary key (`id`),
    foreign key (`id_user`) references `USER` (`id`)
) engine = InnoDB;

create table `WORDS_GROUPE`
(
    `id`        int auto_increment not null,
    `id_word`   int                not null,
    `id_groupe` int                not null,
    primary key (`id`),
    foreign key (`id_word`) references WORDS (`id`),
    foreign key (`id_groupe`) references GROUPE (`id`)
) engine = InnoDB;

create table `WORDS_LISTES`
(
    `id`       int auto_increment not null,
    `id_word`  int                not null,
    `id_liste` int                not null,
    primary key (`id`),
    foreign key (`id_word`) references WORDS (`id`),
    foreign key (`id_liste`) references LISTES (`id`)
) engine = InnoDB;

insert into `USER` (id, pseudo, pass, mail, date, droits)
values (1, 'raiwtsu', '', 'orgevalthomas@gmail.com', null, 1);

insert into `GROUPE` (libelle)
values ('Famille');

insert into `WORDS` (fr, jp, kanji, romaji)
values ('Maison', '家', '', 'ie');

select words.id, groupe.*
from words
         inner join words_groupe as wg
                    on wg.id_word = WORDS.id
         inner join groupe
                    on wg.id_groupe = groupe.id
