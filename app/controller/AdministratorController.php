<?php

class AdministratorController extends ProtectedController
{
    function add()
    {
        
        $kontrola = $this->kontrola();
        if($kontrola===true){
            Administrator::add();
            $this->index();
        }else{
            $view = new View();
            $view->render(
                'administratori/new',
                [
                "poruka"=>$kontrola
                ]
            );
        }

    }

    function edit($id)
    {
        $_POST["sifra"]=$id;
        $kontrola = $this->kontrola();
        if($kontrola===true){
            Administrator::update($id);
            $this->index();
        }else{
            $view = new View();
            $view->render(
                'administratori/edit',
                [
                "poruka"=>$kontrola
                ]
            );
        }

    }

    function delete($id)
    {
            Administrator::delete($id);
            $this->index();
    }

    function kontrola()
    {
        if(Request::post("korisnickoIme")===""){
            return "Obavezno unijeti korisničko ime administratora";
        }

        if(Request::post("eMail")===""){
            return "Obavezno unijeti e-mail administratora";
        }

        if(Request::post("lozinka")===""){
            return "Obavezno unijeti lozinku administratora";
        }

        $db = Db::getInstance();
        $izraz = $db->prepare("select count(sifra) from administrator where korisnickoIme=:korisnickoIme and sifra<>:sifra");
        $izraz->execute(["korisnickoIme"=>Request::post("korisnickoIme"), "sifra" => Request::post("sifra")]);
        $ukupno = $izraz->fetchColumn();
        if($ukupno>0){
            return "Korisničko ime zauzeto, odaberite drugo";
        }

        $db = Db::getInstance();
        $izraz = $db->prepare("select count(sifra) from administrator where lozinka=:lozinka and sifra<>:sifra");
        $izraz->execute(["lozinka"=>Request::post("lozinka"), "sifra" => Request::post("sifra")]);
        $ukupno = $izraz->fetchColumn();
        if($ukupno>0){
            return "Lozinka zauzeta, odaberite drugu";
        }

        $db = Db::getInstance();
        $izraz = $db->prepare("select count(sifra) from administrator where eMail=:eMail and sifra<>:sifra");
        $izraz->execute(["eMail"=>Request::post("eMail"), "sifra" => Request::post("sifra")]);
        $ukupno = $izraz->fetchColumn();
        if($ukupno>0){
            return "E-mail je zauzet, odaberite drugi";
        }

        return true;
    }

    function prepareadd()
    {
        $view = new View();
        $view->render(
            'administratori/new',
            [
            "poruka"=>""
            ]
        );
    }

    function prepareedit($id)
    {
        $view = new View();
        $administrator = Administrator::find($id);
        $_POST["korisnickoIme"]=$administrator->korisnickoIme;
        $_POST["eMail"]=$administrator->eMail;
        $_POST["lozinka"]=$administrator->lozinka;
        $_POST["sifra"]=$administrator->sifra;

        $view->render(
            'administratori/edit',
            [
            "poruka"=>""
            ]
        );
    }


    function index(){
        $view = new View();
        $view->render(
            'administratori/index',
            [
            "administratori"=>Administrator::read()
            ]
        );
    }
}