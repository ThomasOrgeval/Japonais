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