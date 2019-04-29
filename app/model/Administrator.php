<?php
class Administrator
{
    public static function read()
    {
        $db=Db::getInstance();
        $izraz=$db->prepare("select sifra, korisnickoIme, eMail, lozinka from administrator order by korisnickoIme");
        $izraz->execute();
        return $izraz->fetchAll();
    }

    public static function find($id){
        $db = Db::getInstance();
        $izraz = $db->prepare("select * from administrator where sifra=:sifra");
        $izraz->execute(["sifra"=>$id]);
        return $izraz->fetch();
    }

    public static function add()
    {
        $db = Db::getInstance();
        $izraz = $db->prepare("insert into administrator (korisnickoIme, eMail, lozinka) 
        values (:korisnickoIme,:eMail,:lozinka)");
        $izraz->execute(self::podaci());
    }

    public static function update($id)
    {
        $db = Db::getInstance();
        $izraz = $db->prepare("update administrator set 
        korisnickoIme=:korisnickoIme,
        eMail=:eMail,
        lozinka=:lozinka
        where sifra=:sifra");
        $podaci = self::podaci();
        $podaci["sifra"]=$id;
        $izraz->execute($podaci);
    }

    public static function delete($id)
    {
        $db = Db::getInstance();
        $izraz = $db->prepare("delete from administrator where sifra=:sifra");
        $podaci = [];
        $podaci["sifra"]=$id;
        $izraz->execute($podaci);
    }

    private static function podaci(){
        return [
            "korisnickoIme"=>Request::post("korisnickoIme"),
            "eMail"=>Request::post("eMail"),
            "lozinka"=>Request::post("lozinka")
        ];
    }
}