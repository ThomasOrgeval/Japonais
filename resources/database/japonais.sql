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
    `points` int          not null,
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
    `id`    int auto_increment not null,
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

insert into `CONFIDENTIALITY` (confidentiality)
values ('Public'),
       ('Amis'),
       ('Privé');

insert into `USER` (`id`, `pseudo`, `pass`, `mail`, `date`, `droits`, nombre, points)
values (1, 'raiwtsu', '$2y$10$ITwvnUx2a7mMREZP1TCe4.gCbSeLbi9ND/VvdTxvY5HU1vDaP2SQK', 'orgevalthomas@gmail.com',
        '2020-10-11', 1, 10, 0),
       (3, 'jco', '$2y$10$sf5IRDT/9acktptGpeHeMuGz6Yd8gLjbNzDZDg0XaL4wntDurzpo2', 'orgeval-jean.claude@orange.fr',
        '2020-10-11', 1, 10, 0),
       (4, 'Léo', '$2y$10$q.HbtdQuX/txMupwgBfVRegN1D7ERZ7coHyFmQWCJqsTheIf9XTWq', 'leoorgeval@gmail.com', '2020-10-11',
        1, 10, 0),
       (5, 'League', '$2y$10$NuGlmuHGrtCr0mjBg076nO9OdUYbcZEEurwqAbYgotmbJol262bjS', 'a@a.fr', '2020-10-12', 1, 10, 0);

INSERT INTO `TYPE` (`id`, `type`)
VALUES (1, 'Nom'),
       (2, 'Verbe'),
       (3, 'Pronom'),
       (4, 'Adjectif');

INSERT INTO `ANGLAIS` (`id`, `anglais`, `id_type`)
VALUES (1, 'I', 3),
       (2, 'Father', 1),
       (4, 'Breakfast', 1),
       (5, 'Red', 4),
       (6, 'Blue', 4),
       (7, 'Dangerous', 4),
       (8, 'Sweet', 4),
       (9, 'Morning', 1),
       (10, 'Night', 1),
       (11, 'Foot', 1),
       (12, 'New', 1),
       (13, 'Hot', 4),
       (14, 'Dinner', 1),
       (15, 'Bento', 1),
       (16, 'Beauty salon', 1),
       (17, 'Minute', 1);

INSERT INTO `FRANCAIS` (`id`, `francais`, `id_type`)
VALUES (1, 'Je', 3),
       (2, 'Père', 1),
       (4, 'Petit-déjeuner', 1),
       (5, 'Rouge', 4),
       (6, 'Bleu', 4),
       (7, 'Dangereux', 4),
       (8, 'Doux', 4),
       (9, 'Sucré', 4),
       (10, 'Matin', 1),
       (11, 'Nuit', 1),
       (12, 'Pied', 1),
       (13, 'Nouveau', 1),
       (14, 'Nouvelle', 1),
       (15, 'Chaud', 4),
       (16, 'Dîner', 1),
       (17, 'Bento', 1),
       (18, 'Salon de beauté', 1),
       (19, 'Minute', 1);

INSERT INTO `GROUPE` (`id`, `libelle`, `id_parent`)
VALUES (1, 'Famille', NULL),
       (2, 'Habitation', NULL),
       (3, 'Couleur', NULL),
       (4, 'Repas', NULL),
       (5, 'Temps', NULL);

INSERT INTO `JAPONAIS` (`id`, `kanji`, `kana`, `romaji`)
VALUES (1, '私', 'わたし', 'Watashi'),
       (2, 'お父さん', 'おとうさん', 'Otōsan'),
       (4, '朝ご飯', 'あさごはん', 'Asagohan'),
       (5, '赤い', 'あかい', 'Akai'),
       (6, '青い', 'あおい', 'Aoi'),
       (7, '危ない', 'あぶない', 'Abunai'),
       (8, '甘い', 'あまい', 'Amai'),
       (9, '朝', 'あさ', 'Asa'),
       (10, '晩', 'ばん', 'Ban'),
       (11, '足', 'あし', 'Ashi'),
       (12, '新しい', 'あたらしい', 'Atarashī'),
       (13, '熱い', 'あつい', 'Atsui'),
       (14, '晩ご飯', 'ばんごはん', 'Bangohan'),
       (15, '弁当', 'べんとう', 'Bentō'),
       (16, '美容院', 'びよういん', 'Biyōin'),
       (17, '分', 'ぶん', 'Bun');

INSERT INTO `WORDS_GROUPE` (`id`, `id_word`, `id_groupe`)
VALUES (18, 5, 3),
       (19, 6, 3),
       (20, 16, 4),
       (21, 4, 4),
       (22, 10, 5),
       (23, 11, 5),
       (24, 19, 5);

INSERT INTO `TRADUCTION` (`id`, `id_word`, `id_japonais`, `id_anglais`)
VALUES (1, 1, 1, 1),
       (2, 2, 2, 2),
       (6, 4, 4, NULL),
       (7, 4, NULL, 4),
       (8, NULL, 4, 4),
       (9, 5, 5, NULL),
       (10, 5, NULL, 5),
       (11, NULL, 5, 5),
       (12, 6, 6, NULL),
       (13, 6, NULL, 6),
       (14, NULL, 6, 6),
       (15, 7, 7, NULL),
       (16, 7, NULL, 7),
       (17, NULL, 7, 7),
       (18, 8, 8, NULL),
       (19, 9, 8, NULL),
       (20, NULL, 8, 8),
       (21, 8, NULL, 8),
       (22, 9, NULL, 8),
       (23, 10, 9, NULL),
       (24, 10, NULL, 9),
       (25, NULL, 9, 9),
       (26, 11, 10, NULL),
       (27, 11, NULL, 10),
       (28, NULL, 10, 10),
       (29, 12, 11, NULL),
       (30, 12, NULL, 11),
       (31, NULL, 11, 11),
       (32, 13, 12, NULL),
       (33, 14, 12, NULL),
       (34, NULL, 12, 12),
       (35, 13, NULL, 12),
       (36, 14, NULL, 12),
       (37, 15, 13, NULL),
       (38, NULL, 13, 13),
       (39, 15, NULL, 13),
       (40, 16, 14, NULL),
       (41, NULL, 14, 14),
       (42, 16, NULL, 14),
       (43, 17, 15, NULL),
       (44, NULL, 15, 15),
       (45, 17, NULL, 15),
       (46, 18, 16, NULL),
       (47, NULL, 16, 16),
       (48, 18, NULL, 16),
       (49, 19, 17, NULL),
       (50, NULL, 17, 17),
       (51, 19, NULL, 17);