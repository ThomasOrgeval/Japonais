<?php

class Token extends Database
{
    public function rowCountToken($token, $mail): int
    {
        $token = $this->db()->quote($token);
        $mail = $this->db()->quote($mail);
        return $this->db()->query("select * from lexiqumjaponais.TOKEN 
            inner join lexiqumjaponais.USER on USER.id = TOKEN.id_user 
            where token like $token and mail like $mail and expire >= curdate()")->rowCount();
    }

    public function unsetToken($token)
    {
        $token = $this->db()->quote($token);
        $this->db()->query("delete from lexiqumjaponais.TOKEN where token like $token");
    }

    public function setToken($token, $id_user)
    {
        $token = $this->db()->quote($token);
        $id_user = $this->db()->quote($id_user);
        $this->db()->query("insert into lexiqumjaponais.TOKEN set token=$token, id_user=$id_user, expire=date_add(curdate(), interval 1 year)");
    }

    public function getUserWithToken($token, $mail)
    {
        $token = $this->db()->quote($token);
        $mail = $this->db()->quote($mail);
        return $this->db()->query("select u.id, pseudo, mail, droits, nombre, icone, life, last_login, theme, kanji, background from lexiqumjaponais.TOKEN t
            inner join lexiqumjaponais.USER u on t.id_user = u.id
            where token like $token and mail like $mail")->fetch();
    }
}