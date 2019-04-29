<?php

class Dogadaj
{

    public static function pretraga()
    {
        $uvjet=$_POST["uvjet"];
        $db = Db::getInstance();
        $izraz = $db->prepare("
        select * from dogadaj where naziv like :uvjet; 
        ");
        $izraz->execute(["uvjet"=> '%' . $uvjet . '%' ]);
        return $izraz->fetchAll();

    }
    
    
    public static function arhiva($id)
    {
        $db = Db::getInstance();
        $izraz = $db->prepare("
        update dogadaj set aktivan=true 
        where sifra=$id
        ");
        $izraz->execute();

    }

    public static function read($stranica)
    {
        $poStranici=6;
        $db = Db::getInstance();
        $izraz = $db->prepare("
        
                    select 
                    a.korisnickoIme,
                    b.sifra,
                    b.vrsta,
                    b.naziv,
                    b.izvodac,
                    b.organizator,
                    b.termin,
                    b.aktivan,
                    count(b.sifra) as ukupno from 
                    administrator a inner join dogadaj b on a.sifra=b.administrator
                    group by 
                    a.korisnickoIme,
                    b.sifra,
                    b.vrsta,
                    b.naziv,
                    b.izvodac,
                    b.organizator,
                    b.termin,
                    b.aktivan
                    order by b.naziv
                    limit " . (($stranica*$poStranici) - $poStranici)  . ",$poStranici

        ");
        $izraz->execute();
        return $izraz->fetchAll();
    }

    public static function find($id)
    {
        $db = Db::getInstance();
        $izraz = $db->prepare("select * from dogadaj where sifra=:sifra");
        $izraz->execute(["sifra"=>$id]);
        return $izraz->fetch();
    }

    public static function add()
    {
        $db = Db::getInstance();
        $izraz = $db->prepare("insert into dogadaj (vrsta,naziv,izvodac,organizator,administrator,termin) 
        values (:vrsta,:naziv,:izvodac,:organizator,:administrator,:termin)");
        $izraz->execute(self::podaci());
        $dogadaj=$db->lastInsertId();
        $izraz = $db->prepare("insert into sjedalo (dogadaj) 
        values ($dogadaj)");
        $izraz->execute();


    }

    public static function update($id)
    {
        $db = Db::getInstance();
        $izraz = $db->prepare("update dogadaj set 
        vrsta=:vrsta,
        naziv=:naziv,
        izvodac=:izvodac,
        organizator=:organizator,
        administrator=:administrator,
        termin=:termin
        where sifra=:sifra");
        $podaci = self::podaci();
        $podaci["sifra"]=$id;
        $izraz->execute($podaci);
    }

    public static function delete($id)
    {
        $db = Db::getInstance();
        $izraz = $db->prepare("delete from sjedalo where dogadaj=$id");
        $izraz->execute();


        $db = Db::getInstance();
        $izraz = $db->prepare("delete from dogadaj where sifra=$id");
        $izraz->execute();
    }

    private static function podaci(){
        return [
            "vrsta"=>Request::post("vrsta"),
            "naziv"=>Request::post("naziv"),
            "izvodac"=>Request::post("izvodac"),
            "organizator"=>Request::post("organizator"),
            "administrator"=>Request::post("administrator"),
            "termin"=>Request::post("termin")
        ];
    }


}