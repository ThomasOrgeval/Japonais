drop database if exists lexiqumjaponais;
create database lexiqumjaponais;
use lexiqumjaponais;

create table `USER`
(
    `id`     int auto_increment,
    `pseudo` varchar(255) not null,
    `pass`   varchar(255) not null,
    `mail`   varchar(255) not null,
    `date`   date         not null,
    `droits` int          not null,
    `nombre` int          not null,
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

create table `FRANCAIS`
(
    `id`       int auto_increment not null,
    `francais` varchar(255)       not null,
    `id_type`  int,
    primary key (`id`),
    foreign key (`id_type`) references TYPE (`id`)
) engine = InnoDB;

create table `JAPONAIS`
(
    `id`     int auto_increment not null,
    `kanji`  varchar(255)       not null,
    `kana`   varchar(255)       not null,
    `romaji` varchar(255)       not null,
    primary key (`id`)
) engine = InnoDB,
  character set utf8;

create table `ANGLAIS`
(
    `id`      int auto_increment not null,
    `anglais` varchar(255)       not null,
    `id_type` int,
    primary key (`id`),
    foreign key (`id_type`) references TYPE (`id`)
) engine = InnoDB;

create table `KANJI`
(
    `id`            int auto_increment not null,
    `kanji`         varchar(10)        not null,
    `kana`          varchar(255)       not null,
    `romaji`        varchar(255)       not null,
    `signification` longtext,
    primary key (`id`)
) engine = InnoDB,
  character set utf8;

create table `GROUPE`
(
    `id`        int auto_increment not null,
    `libelle`   varchar(255)       not null,
    `id_parent` int,
    primary key (`id`),
    foreign key (`id_parent`) references `GROUPE` (`id`)
) engine = InnoDB;

create table `LISTES`
(
    `id`                 int auto_increment not null,
    `nom`                varchar(255)       not null,
    `description`        longtext           not null,
    `id_confidentiality` int                not null,
    `id_user`            int                not null,
    primary key (`id`),
    foreign key (`id_user`) references `USER` (`id`),
    foreign key (`id_confidentiality`) references `CONFIDENTIALITY` (`id`)
) engine = InnoDB;

create table `WORDS_GROUPE`
(
    `id`        int auto_increment not null,
    `id_word`   int                not null,
    `id_groupe` int                not null,
    primary key (`id`),
    foreign key (`id_word`) references FRANCAIS (`id`),
    foreign key (`id_groupe`) references GROUPE (`id`)
) engine = InnoDB;

create table `WORDS_LISTES`
(
    `id`       int auto_increment not null,
    `id_word`  int                not null,
    `id_liste` int                not null,
    primary key (`id`),
    foreign key (`id_word`) references FRANCAIS (`id`),
    foreign key (`id_liste`) references LISTES (`id`)
) engine = InnoDB;

create table `JAPONAIS_KANJI`
(
    `id`          int auto_increment not null,
    `id_japonais` int                not null,
    `id_kanji`    int                not null,
    primary key (`id`),
    foreign key (`id_japonais`) references JAPONAIS (`id`),
    foreign key (`id_kanji`) references KANJI (`id`)
) engine = InnoDB;

create table `WORDS_JAPONAIS`
(
    `id`          int auto_increment not null,
    `id_word`     int,
    `id_japonais` int,
    `id_anglais`  int,
    primary key (`id`),
    foreign key (`id_word`) references FRANCAIS (`id`),
    foreign key (`id_japonais`) references JAPONAIS (`id`),
    foreign key (`id_anglais`) references ANGLAIS (`id`)
) engine = InnoDB;

insert into `TYPE` (type)
values ('Nom'),
       ('Verbe');

insert into `CONFIDENTIALITY` (confidentiality)
values ('Public'),
       ('Amis'),
       ('Privé');