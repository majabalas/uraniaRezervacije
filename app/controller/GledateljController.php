<?php

class GledateljController extends ProtectedController
{
    function add()
    {
        
        $kontrola = $this->kontrola();
        if($kontrola===true){
            Gledatelj::add();
            $this->index();
        }else{
            $view = new View();
            $view->render(
                'gledatelji/new',
                [
                "poruka"=>$kontrola
                ]
            );
        }

    }
    

    function traziGledatelj(){
        echo json_encode(Gledatelj::traziGledatelj($_GET["term"]));
    }




    function edit()
    {
        $id=$_POST["sifra"];
        $kontrola = $this->kontrola();
        if($kontrola===true){
            Gledatelj::update($id);
            $this->index();
        }else{
            $view = new View();
            $view->render(
                'gledatelj/edit',
                [
                "poruka"=>$kontrola
                ]
            );
        }

    }

    function delete($id)
    {
        Gledatelj::delete($id);
            $this->index();
    }

    function kontrola()
    {
        if(Request::post("prezime")===""){
            return "Obavezno unijeti prezime gledatelja";
        }

        if(Request::post("telefon")==="" && Request::post("eMail")===""){
            return "Obavezno upisati E-mail ili telefon gledatelja";
        }

        $db = Db::getInstance();
        $izraz = $db->prepare("select count(sifra) from gledatelj where eMail=:eMail and sifra<>:sifra");
        $izraz->execute(["eMail"=>Request::post("eMail"), "sifra" => Request::post("sifra")]);
        $ukupno = $izraz->fetchColumn();
        if($ukupno>0){
            return "E-mail se već koristi, odaberite drugi";
        }

        $db = Db::getInstance();
        $izraz = $db->prepare("select count(sifra) from gledatelj where telefon=:telefon and sifra<>:sifra");
        $izraz->execute(["telefon"=>Request::post("telefon"), "sifra" => Request::post("sifra")]);
        $ukupno = $izraz->fetchColumn();
        if($ukupno>0){
            return "Telefon se već koristi, odaberite drugi";
        }

        return true;
    }

    function prepareadd()
    {
        $view = new View();
        $view->render(
            'gledatelji/new',
            [
            "poruka"=>""
            ]
        );
    }

    function prepareedit($id)
    {
        $view = new View();
        $gledatelj = Gledatelj::find($id);
        $_POST["ime"]=$gledatelj->ime;
        $_POST["prezime"]=$gledatelj->prezime;
        $_POST["eMail"]=$gledatelj->eMail;
        $_POST["telefon"]=$gledatelj->telefon;
        $_POST["gdpr"]=$gledatelj->gdpr;
        $_POST["napomena"]=$gledatelj->napomena;
        $_POST["sifra"]=$gledatelj->sifra;


        $view->render(
            'gledatelji/edit',
            [
            "poruka"=>""
            ]
        );
    }


    function index(){
        $view = new View();
        $view->render(
            'gledatelji/index',
            [
            "gledatelji"=>Gledatelj::read()
            ]
        );
    }
}