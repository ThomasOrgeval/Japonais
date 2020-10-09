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

create table `TYPE`
(
    `id`   int auto_increment not null,
    `type` varchar(255)       not null,
    primary key (`id`)
) engine = InnoDB;

create table `CONFIDENTIALITY`
(
    `id`              int auto_increment not null,
    `confidentiality` varchar(255)       not null,
    primary key (`id`)
) engine = InnoDB;

create table `WORDS`
(
    `id`      int auto_increment not null,
    `fr`      varchar(255)       not null,
    `kana`    varchar(255)       not null,
    `kanji`   varchar(255),
    `romaji`  varchar(255)       not null,
    `id_type` int                not null,
    primary key (`id`),
    foreign key (`id_type`) references TYPE (`id`)
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
    `id`                 int auto_increment not null,
    `nom`                varchar(255)       not null,
    `description`        longtext           not null,
    `id_confidentiality` int                not null,
    `id_user`            int                not null,
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

insert into `TYPE` (type)
values ('Nom'),
       ('Verbe');

insert into `CONFIDENTIALITY` (confidentiality)
values ('Public'),
       ('Amis'),
       ('Privé');