drop database if exists japonais;
create database japonais character set UTF8;
use japonais;

create table user
(
    id         int auto_increment not null,
    pseudo     varchar(255)       not null,
    pass       varchar(255)       not null,
    mail       varchar(255)       not null,
    date       date               not null,
    droits     int                not null,
    nombre     int                not null,
    icone      varchar(255)       not null,
    life       int                not null,
    last_login date               not null,
    theme      varchar(255)       not null,
    kanji      boolean            not null,
    slug       varchar(255),
    background varchar(255)       not null,
    primary key (id)
) engine = InnoDB;

create table recuperation
(
    id   int auto_increment not null,
    mail varchar(255)       not null,
    code int                not null,
    primary key (id)
) engine = InnoDB;

create table recompense_type
(
    id   int auto_increment not null,
    type varchar(255)       not null,
    primary key (id)
) engine = InnoDB;

create table recompense
(
    id            int auto_increment not null,
    libelle       varchar(255)       not null,
    slug          varchar(255)       not null,
    cout          int                not null,
    date_parution date,
    id_type       int,
    primary key (id),
    foreign key (id_type) references recompense_type (id)
) engine = InnoDB;

create table achat
(
    id            int auto_increment not null,
    id_user       int                not null,
    id_recompense int                not null,
    date_achat    date,
    primary key (id),
    foreign key (id_user) references user (id),
    foreign key (id_recompense) references recompense (id)
) engine = InnoDB;

create table type
(
    id      int auto_increment not null,
    type    varchar(255)       not null,
    type_jp varchar(255),
    primary key (id)
) engine = InnoDB;

create table confidentiality
(
    id              int auto_increment not null,
    confidentiality varchar(255)       not null,
    primary key (id)
) engine = InnoDB;

create table francais
(
    id       int auto_increment not null,
    francais varchar(255)       not null,
    slug     varchar(255),
    primary key (id)
) engine = InnoDB;

create table jlpt
(
    id    int not null,
    color varchar(255),
    primary key (id)
) engine = InnoDB;

create table japonais
(
    id          int auto_increment not null,
    kanji       varchar(255)       not null,
    kana        varchar(255)       not null,
    romaji      varchar(255)       not null,
    description longtext,

    jlpt        int,
    id_type     int,
    primary key (id),
    foreign key (id_type) references TYPE (id),
    foreign key (jlpt) references JLPT (id)
) engine = InnoDB;

create table anglais
(
    id      int auto_increment not null,
    anglais varchar(255)       not null,
    primary key (id)
) engine = InnoDB;

create table kanji
(
    id       int auto_increment not null,
    kanji    varchar(1)         not null,
    lignes   int,
    grade    int,
    on_yomi  varchar(255),
    kun_yomi varchar(255),
    sens     longtext,
    sens_en  longtext,
    primary key (id)
) engine = InnoDB;

create table jukugo
(
    id             int auto_increment not null,
    jukugo         char(2)            not null,
    id_left_kanji  int                not null,
    id_right_kanji int                not null,
    frequence      int,
    type           varchar(255),
    prononciation  varchar(255),
    traduction     varchar(255),
    primary key (id),
    foreign key (id_left_kanji) references kanji (id),
    foreign key (id_right_kanji) references kanji (id)
) engine = InnoDB;

create table groupe
(
    id          int auto_increment not null,
    libelle     varchar(255)       not null,
    id_parent   int,
    quantifieur varchar(255),
    slug        varchar(255),
    primary key (id),
    foreign key (id_parent) references groupe (id)
) engine = InnoDB;

create table listes
(
    id                 int auto_increment not null,
    nom                varchar(255)       not null,
    description        longtext           not null,
    id_confidentiality int                not null,
    id_user            int                not null,
    primary key (id),
    foreign key (id_user) references user (id),
    foreign key (id_confidentiality) references confidentiality (id)
) engine = InnoDB;

create table japonais_groupe
(
    id          int auto_increment not null,
    id_japonais int                not null,
    id_groupe   int                not null,
    primary key (id),
    foreign key (id_japonais) references japonais (id),
    foreign key (id_groupe) references groupe (id)
) engine = InnoDB;

create table words_listes
(
    id       int auto_increment not null,
    id_word  int                not null,
    id_liste int                not null,
    primary key (id),
    foreign key (id_word) references francais (id),
    foreign key (id_liste) references listes (id)
) engine = InnoDB;

create table japonais_kanji
(
    id          int auto_increment not null,
    id_japonais int                not null,
    id_kanji    int                not null,
    primary key (id),
    foreign key (id_japonais) references japonais (id),
    foreign key (id_kanji) references kanji (id)
) engine = InnoDB;

create table traduction
(
    id          int auto_increment not null,
    id_word     int,
    id_japonais int,
    id_anglais  int,
    primary key (id),
    foreign key (id_word) references francais (id),
    foreign key (id_japonais) references japonais (id),
    foreign key (id_anglais) references anglais (id)
) engine = InnoDB;

create table sakura
(
    id_user      int not null,
    sakura       int not null,
    sakura_total int not null,
    primary key (id_user),
    foreign key (id_user) references user (id)
) engine = InnoDB;

create table historique_sakura
(
    id      int auto_increment not null,
    sakura  int                not null,
    date    date               not null,
    id_user int                not null,
    primary key (id),
    foreign key (id_user) references user (id)
) engine = InnoDB;

create table riddle
(
    id_user       int          not null,
    riddle        varchar(255) not null,
    last_response boolean      not null,
    primary key (id_user),
    foreign key (id_user) references user (id)
) engine = InnoDB;

create table historique_riddle
(
    id       int auto_increment not null,
    id_user  int                not null,
    riddle   varchar(255)       not null,
    response boolean            not null,
    life     date               not null,
    primary key (id),
    foreign key (id_user) references user (id)
) engine = InnoDB;

create table kana
(
    id       int auto_increment not null,
    hiragana varchar(255),
    katakana varchar(255),
    romaji   varchar(255)       not null,
    primary key (id)
) engine = InnoDB;

create table exception
(
    id      int auto_increment not null,
    libelle varchar(255),
    primary key (id)
) engine = InnoDB;

create table musique
(
    id       int auto_increment not null,
    japonais longtext           not null,
    romaji   longtext           not null,
    francais longtext           not null,
    anime    varchar(255),
    chanteur varchar(255),
    titre    varchar(255),
    slug     varchar(255),
    audio    varchar(255),
    primary key (id)
) engine = InnoDB;

create table token
(
    id      int auto_increment not null,
    id_user int                not null,
    token   char(48)           not null,
    expire  date               not null,
    primary key (id),
    foreign key (id_user) references user (id)
) engine = InnoDB;

delimiter |

create trigger after_update_sakura
    after update
    on sakura
    for each row
begin
    declare id_user_sakura int;
    declare nb_sakura int;
    declare last_date date;
    set id_user_sakura = old.id_user;
    set nb_sakura = new.sakura_total - old.sakura_total;
    set last_date = (select date from historique_sakura where id_user = id_user_sakura order by date desc limit 1);
    call insert_sakura_history(id_user_sakura, nb_sakura, last_date);
end |

create trigger after_update_riddle
    after update
    on riddle
    for each row
begin
    insert into historique_riddle(riddle, response, life, id_user) value (old.riddle, new.last_response, curdate(), old.id_user);
end |

create trigger after_insert_user
    after insert
    on user
    for each row
begin
    declare random varchar(255);
    set random = (select francais from francais order by rand() limit 1);
    insert into sakura(id_user, sakura, sakura_total) value (new.id, 0, 0);
    insert into riddle(id_user, last_response, riddle) value (new.id, true, random);
end |

create trigger before_delete_user
    before delete
    on user
    for each row
begin
    delete from sakura where id_user = old.id;
    delete from riddle where id_user = old.id;
    delete from historique_sakura where id_user = old.id;
    delete from historique_riddle where id_user = old.id;
    delete from achat where id_user = old.id;
    delete from listes where id_user = old.id;
end |

drop procedure if exists insert_sakura_history|
create procedure insert_sakura_history(in id_user_sakura int, in nb_sakura int, in last_date date)
begin
    if (last_date = curdate()) then
        update historique_sakura set sakura = sakura + nb_sakura where date = curdate() and id_user = id_user_sakura;
    else
        insert into historique_sakura(sakura, date, id_user) value (nb_sakura, curdate(), id_user_sakura);
    end if;
end |

delimiter ;

create view select_day as
select sum(sakura) as sakura, u.pseudo
from historique_sakura hs
         inner join user u on hs.id_user = u.id
where hs.date <= curdate()
  and hs.date > date_sub(curdate(), interval 1 day)
group by id_user
order by sakura desc
limit 5;

create view select_week as
select sum(sakura) as sakura, u.pseudo
from historique_sakura hs
         inner join user u on hs.id_user = u.id
where hs.date <= curdate()
  and hs.date > date_sub(curdate(), interval 1 week)
group by id_user
order by sakura desc
limit 5;

create view select_month as
select sum(sakura) as sakura, u.pseudo
from historique_sakura hs
         inner join user u on hs.id_user = u.id
where hs.date <= curdate()
  and hs.date > date_sub(curdate(), interval 1 month)
group by id_user
order by sakura desc
limit 5;