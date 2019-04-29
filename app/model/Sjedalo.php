<?php

class Sjedalo
{


    public static function dodajGledatelja($sjedalo,$gledatelj)
    {
        $db = Db::getInstance();
        $db->beginTransaction();

        $izraz = $db->prepare("
                 select count(*) from gledatelj where gledatelj=:gledatelj;
        ");
        $izraz->execute(["gledatelj"=>$gledatelj]);
        $ukupno = $izraz->fetchColumn();
        $vrati="";
        if($ukupno>0){
            $vrati= "Polaznik postoji na grupi, nije dodan";
        }else{
            $izraz = $db->prepare("
            update sjedalo set $sjedalo=$gledatelj where dogadaj=$dogadaj;
            ");
            $izraz->execute([]);
            $vrati="OK";
        }

        
        $db->commit();
        return $vrati;
    }


    public static function obrisiPolaznika($grupa,$polaznik)
    {
        $db = Db::getInstance();

        $izraz = $db->prepare("
                delete from clan where grupa=:grupa and polaznik=:polaznik;
        ");
        $izraz->execute(["grupa"=>$grupa, "polaznik"=>$polaznik]);
       
        return "OK";
    }


    public static function gledatelj()
    {
        $gledatelj=Request::post("gledatelj");
        $dogadaj=Request::post("dogadaj");
        $db = Db::getInstance();
        if($gledatelj!=null){
        $izraz = $db->prepare("
        
        select sifra,ime,prezime,eMail,telefon from gledatelj 
        where sifra=$gledatelj;


        ");
        $izraz->execute();
        return $izraz->fetchAll(PDO::FETCH_ASSOC);
    } 
}
    
    public static function read($id)
    {
         $db = Db::getInstance();
        $izraz = $db->prepare("
        
        select * from sjedalo 
        where dogadaj=$id;


        ");
        $izraz->execute();
        return $izraz->fetchObject();
    }

    public static function find()
    {
        $sjedalo=Request::post("sjedalo");
        $dogadaj=Request::post("dogadaj");
        $db = Db::getInstance();
        $izraz = $db->prepare("
        select * from gledatelj a left join sjedalo b on a.sifra=$sjedalo 
                    where b.dogadaj=$dogadaj;
        ");
        $izraz->execute();
        return $izraz->fetch();
    }



    public static function naziv($dogadaj)
    {
        $db = Db::getInstance();
        $izraz = $db->prepare("
        select termin,naziv from dogadaj where sifra=$dogadaj;
        ");
        $izraz->execute();
        return $izraz->fetchAll(PDO::FETCH_ASSOC);
    }



    public static function update()
    {
        $sjedalo=Request::post("sjedalo");
        $dogadaj=Request::post("dogadaj");
        $gledatelj=Request::post("gledatelj");
        $db = Db::getInstance();
        $izraz = $db->prepare("update sjedalo set $sjedalo=$gledatelj where dogadaj=$dogadaj;");
        $izraz->execute();
    }


    public static function delete()
    {
        $dogadaj=Request::post("dogadaj");
        $sjedalo=Request::post("sjedalo");
        $db = Db::getInstance();
        $izraz = $db->prepare("update sjedalo set
        $sjedalo=null
        where dogadaj=$dogadaj;");
        $izraz->execute();
    }

    private static function podaci(){
        return [
            "redSjedalo"=>Request::post("redSjedalo"),
            "komentar"=>Request::post("komentar"),
            "gledatelj"=>Request::post("gledatelj")
        ];
    }


}