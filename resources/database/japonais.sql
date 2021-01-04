drop database if exists lexiqumjaponais;
create database lexiqumjaponais character set UTF8;
use lexiqumjaponais;

set global event_scheduler = "ON";

create table `USER`
(
    `id`         int auto_increment not null,
    `pseudo`     varchar(255)       not null,
    `pass`       varchar(255)       not null,
    `mail`       varchar(255)       not null,
    `date`       date               not null,
    `droits`     int                not null,
    `nombre`     int                not null,
    `icone`      varchar(255)       not null,
    `life`       int                not null,
    `last_login` date               not null,
    `theme`      varchar(255)       not null,
    `kanji`      boolean            not null,
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
    `id`      int auto_increment not null,
    `type`    varchar(255)       not null,
    `type_jp` varchar(255),
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
    primary key (`id`)
) engine = InnoDB;

create table `JAPONAIS`
(
    `id`          int auto_increment not null,
    `kanji`       varchar(255)       not null,
    `kana`        varchar(255)       not null,
    `romaji`      varchar(255)       not null,
    `description` longtext,
    `id_type`     int,
    primary key (`id`),
    foreign key (`id_type`) references TYPE (`id`)
) engine = InnoDB,
  character set utf8;

create table `ANGLAIS`
(
    `id`      int auto_increment not null,
    `anglais` varchar(255)       not null,
    primary key (`id`)
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
    `id`          int auto_increment not null,
    `libelle`     varchar(255)       not null,
    `id_parent`   int,
    `quantifieur` varchar(255),
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

create table `JAPONAIS_GROUPE`
(
    `id`          int auto_increment not null,
    `id_japonais` int                not null,
    `id_groupe`   int                not null,
    primary key (`id`),
    foreign key (`id_japonais`) references JAPONAIS (`id`),
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

create table `SAKURA`
(
    `id_user`      int not null,
    `sakura`       int not null,
    `sakura_total` int not null,
    primary key (`id_user`),
    foreign key (`id_user`) references USER (`id`)
) engine = InnoDB;

create table `HISTORIQUE_SAKURA`
(
    `id`      int auto_increment not null,
    `sakura`  int                not null,
    `date`    date               not null,
    `id_user` int                not null,
    primary key (`id`),
    foreign key (`id_user`) references USER (`id`)
) engine = InnoDB;

create table `RIDDLE`
(
    `id_user`       int          not null,
    `riddle`        varchar(255) not null,
    `last_response` boolean      not null,
    primary key (`id_user`),
    foreign key (`id_user`) references USER (`id`)
) engine = InnoDB;

create table `HISTORIQUE_RIDDLE`
(
    `id`       int auto_increment not null,
    `id_user`  int                not null,
    `riddle`   varchar(255)       not null,
    `response` boolean            not null,
    `life`     date               not null,
    primary key (`id`),
    foreign key (`id_user`) references USER (`id`)
) engine = InnoDB;

create table `KANA`
(
    `id`       int auto_increment not null,
    `hiragana` varchar(255),
    `katakana` varchar(255),
    `romaji`   varchar(255)       not null,
    primary key (`id`)
) engine = InnoDB;

create table `EXCEPTION`
(
    `id`      int auto_increment not null,
    `libelle` varchar(255),
    primary key (`id`)
) engine = InnoDB;

delimiter |

create trigger after_update_sakura
    after update
    on SAKURA
    for each row
begin
    declare id_user_sakura int;
    declare nb_sakura int;
    declare last_date date;
    set id_user_sakura = old.id_user;
    set nb_sakura = new.sakura_total - old.sakura_total;
    set last_date = (select `date` from HISTORIQUE_SAKURA where id_user = id_user_sakura order by `date` desc limit 1);
    call insert_sakura_history(id_user_sakura, nb_sakura, last_date);
end |

create trigger after_update_riddle
    after update
    on RIDDLE
    for each row
begin
    insert into HISTORIQUE_RIDDLE(riddle, response, life, id_user) value (old.riddle, new.last_response, curdate(), old.id_user);
end |

create trigger after_insert_user
    after insert
    on USER
    for each row
begin
    declare random varchar(255);
    set random = (select francais from FRANCAIS order by rand() limit 1);
    insert into SAKURA(id_user, sakura, sakura_total) value (new.id, 0, 0);
    insert into RIDDLE(id_user, last_response, riddle) value (new.id, true, random);
end |

create trigger before_delete_user
    before delete
    on USER
    for each row
begin
    delete from SAKURA where id_user = old.id;
    delete from RIDDLE where id_user = old.id;
    delete from HISTORIQUE_SAKURA where id_user = old.id;
    delete from HISTORIQUE_RIDDLE where id_user = old.id;
    delete from ACHAT where id_user = old.id;
    delete from LISTES where id_user = old.id;
end |

drop procedure if exists `insert_sakura_history`|
create procedure insert_sakura_history(in id_user_sakura int, in nb_sakura int, in last_date date)
begin
    if (last_date = curdate()) then
        update HISTORIQUE_SAKURA set sakura = sakura + nb_sakura where date = curdate() and id_user = id_user_sakura;
    else
        insert into HISTORIQUE_SAKURA(sakura, date, id_user) value (nb_sakura, curdate(), id_user_sakura);
    end if;
end |

delimiter ;

create view select_day as
select sum(sakura) sakura, u.pseudo
from HISTORIQUE_SAKURA hs
         inner join USER u on hs.id_user = u.id
where hs.date <= curdate()
  and hs.date > date_sub(curdate(), interval 1 day)
group by id_user
order by sakura desc
limit 5;

create view select_week as
select sum(sakura) sakura, u.pseudo
from HISTORIQUE_SAKURA hs
         inner join USER u on hs.id_user = u.id
where hs.date <= curdate()
  and hs.date > date_sub(curdate(), interval 1 week)
group by id_user
order by sakura desc
limit 5;

create view select_month as
select sum(sakura) sakura, u.pseudo
from HISTORIQUE_SAKURA hs
         inner join USER u on hs.id_user = u.id
where hs.date <= curdate()
  and hs.date > date_sub(curdate(), interval 1 month)
group by id_user
order by sakura desc
limit 5;

create event delete_history_riddle on schedule every 1 day starts '2020-12-01 00:00:00' on completion not preserve enable
    do
    delete
    from HISTORIQUE_RIDDLE
    where life < curdate() - interval 14 day;