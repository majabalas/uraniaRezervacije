<?php

class Arhiva
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
    
    public static function vrati($id)
    {
        $db = Db::getInstance();
        $izraz = $db->prepare("
        update dogadaj set aktivan=false 
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
                    b.aktivan
                    from 
                    administrator a inner join dogadaj b on a.sifra=b.administrator
                    where b.aktivan=true
                    order by b.naziv
                    limit " . (($stranica*$poStranici) - $poStranici)  . ",$poStranici

        ");
        $izraz->execute();
        return $izraz->fetchAll();
    }

    
}