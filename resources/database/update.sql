-- pc portable

create table `EXCEPTION`
(
    `id`      int auto_increment not null,
    `libelle` varchar(255),
    primary key (`id`)
) engine = InnoDB;

alter table GROUPE
    add column `quantifieur` varchar(255);

alter table FRANCAIS
    add column `slug` varchar(255);

alter table USER
    add column `slug` varchar(255);

alter table GROUPE
    add column `slug` varchar(255);

alter table USER
    add column `background` varchar(255);

create table `JLPT`
(
    `id`    int not null,
    `color` varchar(255),
    primary key (`id`)
) engine = InnoDB;

alter table JAPONAIS
    add column `jlpt` int;
create index jlpt
    on JAPONAIS (jlpt);
alter table JAPONAIS
    add constraint japonais_jlpt_fk
        foreign key (`jlpt`) references JLPT (`id`);

insert into JLPT(id, color)
values (0, ''),
       (1, 'rouge'),
       (2, 'orange'),
       (3, 'jaune'),
       (4, 'vert'),
       (5, 'bleu');

create table `MUSIQUE`
(
    `id`       int auto_increment not null,
    `japonais` longtext           not null,
    `romaji` longtext           not null,
    `francais` longtext           not null,
    `anime`    varchar(255),
    `chanteur` varchar(255),
    `titre`    varchar(255),
    `slug`    varchar(255),
    `audio`    varchar(255),
    primary key (`id`)
) engine = InnoDB;