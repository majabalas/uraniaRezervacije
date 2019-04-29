<?php

class AdminController
{
    function prijava()
    {
        $view = new View();
        $view->render('prijava',["poruka"=>""]);
    }

    function login()
    {
        

        $db=Db::getInstance();
        $izraz = $db->prepare("select korisnickoIme, eMail, lozinka from administrator where korisnickoIme=:korisnickoIme");
        $izraz->execute(["korisnickoIme"=>Request::post("korisnickoIme")]);

        $view = new View();

        if($izraz->rowCount()>0){
            $red=$izraz->fetch();
            if(password_verify(Request::post("lozinka"),$red->lozinka)){
                $user = new stdClass();
                $user->korisnickoIme=$red->korisnickoIme;
                $user->eMail=$red->eMail;
                $user->lozinka=$red->lozinka;
                $user->korisnickoImeeMail=$red->korisnickoIme . " " . $red->eMail;

                Session::getInstance()->login($user);

                $view->render('index',["poruka"=>"Uspješno prijavljen"]);
            }else{
                $view->render('prijava',["poruka"=>"Kombinacija korisničko ime i lozinka ne odgovara!"]);
            }
        }else{
            $view->render('prijava',["poruka"=>"Ne postojeće korisničko ime"]);
        }

        

        //
        
    }

    function odjava()
    {

        Session::getInstance()->odjava();
        $view = new View();
        $view->render('index',["poruka"=>"See ya next time!"]);
    }
}