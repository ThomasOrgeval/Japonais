drop database if exists lexiqumjaponais;
create database lexiqumjaponais;
use lexiqumjaponais;

create table `USER`
(
    `id`         int auto_increment,
    `pseudo`     varchar(255) not null,
    `pass`       varchar(255) not null,
    `mail`       varchar(255) not null,
    `date`       date         not null,
    `droits`     int          not null,
    `nombre`     int          not null,
    `points`     int          not null,
    `icone`      varchar(255) not null,
    `riddle`     varchar(255) not null,
    `life`       int          not null,
    `last_login` date         not null,
    `theme`      varchar(255) not null,
    primary key (`id`)
) engine = InnoDB;

create table `RECUPERATION`
(
    `id`   int auto_increment not null,
    `mail` varchar(255)       not null,
    `code` int                not null,
    primary key (`id`)
) engine = InnoDB;

create table `RECOMPENSE_TYPE`
(
    `id`   int auto_increment not null,
    `type` varchar(255)       not null,
    primary key (`id`)
) engine = InnoDB;

create table `RECOMPENSE`
(
    `id`            int auto_increment not null,
    `libelle`       varchar(255)       not null,
    `slug`          varchar(255)       not null,
    `cout`          int                not null,
    `date_parution` date,
    `id_type`       int,
    primary key (`id`),
    foreign key (`id_type`) references RECOMPENSE_TYPE (`id`)
) engine = InnoDB;

create table `ACHAT`
(
    `id`            int auto_increment not null,
    `id_user`       int                not null,
    `id_recompense` int                not null,
    `date_achat`    date,
    primary key (`id`),
    foreign key (`id_user`) references `USER` (`id`),
    foreign key (`id_recompense`) references `RECOMPENSE` (`id`)
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
    `id`       int auto_increment not null,
    `kanji`    varchar(1)         not null,
    `lignes`   int,
    `grade`    int,
    `on_yomi`  varchar(255),
    `kun_yomi` varchar(255),
    `sens`     longtext,
    `sens_en`  longtext,
    primary key (`id`)
) engine = InnoDB,
  character set utf8;

create table `JUKUGO`
(
    `id`             int auto_increment not null,
    `jukugo`         char(2)            not null,
    `id_left_kanji`  int                not null,
    `id_right_kanji` int                not null,
    `frequence`      int,
    `type`           varchar(255),
    `prononciation`  varchar(255),
    `traduction`     varchar(255),
    primary key (`id`),
    foreign key (`id_left_kanji`) references KANJI (`id`),
    foreign key (`id_right_kanji`) references KANJI (`id`)
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

create table `TRADUCTION`
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