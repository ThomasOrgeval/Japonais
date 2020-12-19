-- modifications à appporter
alter database lexiqumjaponais character set UTF8;

set global event_scheduler = "ON";

alter table JAPONAIS
    add column `description` longtext;

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

drop trigger after_insert_user;

delimiter |

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

delimiter ;

create event delete_history_riddle on schedule every 1 day starts '2020-12-01 00:00:00' on completion not preserve enable
    do
    delete
    from HISTORIQUE_RIDDLE
    where life < curdate() - interval 14 day;

insert into RIDDLE(id_user, riddle, last_response)
select distinct id, riddle, true
from USER;

alter table USER
    drop column riddle;
alter table USER
    add column `kanji` boolean not null;
update lexiqumjaponais.USER
set user.kanji = 1;

alter table JAPONAIS
    add column `id_type` int;
alter table JAPONAIS
    add foreign key (`id_type`) references TYPE (`id`);

update JAPONAIS
    inner join TRADUCTION t on JAPONAIS.id = t.id_japonais
    inner join FRANCAIS f on t.id_word = f.id
set JAPONAIS.id_type = f.id_type;

alter table FRANCAIS
    drop foreign key francais_ibfk_1;
drop index id_type on FRANCAIS;
alter table FRANCAIS
    drop column id_type;

drop table WORDS_GROUPE;
create table `JAPONAIS_GROUPE`
(
    `id`          int auto_increment not null,
    `id_japonais` int                not null,
    `id_groupe`   int                not null,
    primary key (`id`),
    foreign key (`id_japonais`) references JAPONAIS (`id`),
    foreign key (`id_groupe`) references GROUPE (`id`)
) engine = InnoDB;

create table `KANA`
(
    `id`       int auto_increment not null,
    `hiragana` varchar(255),
    `katakana` varchar(255),
    `romaji`   varchar(255)       not null,
    primary key (`id`)
) engine = InnoDB;

-- Autre

alter table ANGLAIS
    drop foreign key anglais_ibfk_1;
drop index id_type on ANGLAIS;
alter table ANGLAIS
    drop column id_type;

-- Modifications pour la tour

drop table `FURIGANA`;
create table `KANA`
(
    `id`       int auto_increment not null,
    `hiragana` varchar(255),
    `katakana` varchar(255),
    `romaji`   varchar(255)       not null,
    primary key (`id`)
) engine = InnoDB;