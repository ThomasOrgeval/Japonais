-- pc portable

create table `EXCEPTION`
(
    `id`      int auto_increment not null,
    `libelle` varchar(255),
    primary key (`id`)
) engine = InnoDB;

alter table GROUPE
    add column `quantifieur` varchar(255);