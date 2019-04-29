<?php

class Gledatelj{




    public static function traziGledatelj($uvjet)
    {
        $db = Db::getInstance();
        $izraz = $db->prepare("
                                select
                                sifra, 
                                ime,
                                prezime,
                                eMail,
                                telefon
                                from gledatelj
                                where concat(ime, ' ', prezime) like :uvjet
                                group by
                                sifra, 
                                ime,
                                prezime,
                                eMail,
                                telefon

         ");
        $izraz->execute(["uvjet"=>"%" . $uvjet . "%"]);
        return $izraz->fetchAll();
    }


    public static function read()
    {
        $db = Db::getInstance();
        $izraz = $db->prepare("select * from gledatelj order by prezime");
        $izraz->execute();
        return $izraz->fetchAll();
    }

    public static function find($id)
    {
        $db = Db::getInstance();
        $izraz = $db->prepare("select * from gledatelj where sifra=:sifra");
        $izraz->execute(["sifra"=>$id]);
        return $izraz->fetch();
    }

    public static function add()
    {
        $db = Db::getInstance();
        $izraz = $db->prepare("insert into gledatelj (ime,prezime,eMail,telefon,gdpr,napomena) 
        values (:ime,:prezime,:eMail,:telefon,:gdpr,:napomena)");
        $izraz->execute(self::podaci());
    }

    public static function update($id)
    {
        $db = Db::getInstance();
        $izraz = $db->prepare("update gledatelj set 
        ime=:ime,
        prezime=:prezime,
        eMail=:eMail,
        telefon=:telefon,
        gdpr=:gdpr,
        napomena=:napomena
        where sifra=:sifra");
        $podaci = [];
        $podaci = self::podaci();
        $podaci["sifra"]=$id;
        $izraz->execute($podaci);
    }

    public static function delete($id)
    {
        $db = Db::getInstance();
        $izraz = $db->prepare("delete from gledatelj where sifra=:sifra");
        $podaci = [];
        $podaci["sifra"]=$id;
        $izraz->execute($podaci);
    }

    private static function podaci(){
        return [
            "ime"=>Request::post("ime"),
            "prezime"=>Request::post("prezime"),
            "eMail"=>Request::post("eMail"),
            "telefon"=>Request::post("telefon"),
            "gdpr"=>Request::post("gdpr"),
            "napomena"=>Request::post("napomena")
        ];
    }


    public static function readGledatelj($sifra)
    {
        $db = Db::getInstance();
        $izraz = $db->prepare("
                                select 
                                sifra as sifra, 
                                concat(ime, ' ', prezime) as gledatelj,
                                email,
                                telefon
                                from gledatelj
                                where sifra=:sifra
        ");
        $izraz->execute(["sifra"=>$sifra]);
        return $izraz->fetchAll();
    }









}