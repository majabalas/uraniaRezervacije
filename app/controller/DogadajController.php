<?php

class DogadajController extends ProtectedController
{
    function pretraga()
    {
        $uvjet=$_POST["uvjet"];
        
        $view = new View();
        $view->render(
            'dogadaji/rezultati',
            [
                "poruka"=>Dogadaj::pretraga($uvjet)
                ]
        );

    }
    
    function arhiva($id)
    {

        Dogadaj::arhiva($id);
            $this->index();

    }
    
    function add()
    {
        
        $kontrola = $this->kontrola();
        if($kontrola===true){
            Dogadaj::add();
            $this->index();
        }else{
            $view = new View();
            $view->render(
                'dogadaji/new',
                [
                "poruka"=>$kontrola
                ]
            );
        }

    }

    function index($stranica=1){
        if($stranica<=0){
            $stranica=1;
        }
        if($stranica===1){
            $prethodna=1;
        }else{
            $prethodna=$stranica-1;
        }
        $sljedeca=$stranica+1;

        $view = new View();
        $view->render(
            'dogadaji/index',
            [
            "dogadaji"=>Dogadaj::read($stranica),
            "prethodna"=>$prethodna,
            "sljedeca"=>$sljedeca
            ]
        );
    }

    function edit($id)
    {
        $_POST["sifra"]=$id;

        $datoteka = APP::config("path") . "public/css/dogadaji/" . $id . ".png"; 
        move_uploaded_file($_FILES["slika"]["tmp_name"],$datoteka);

        $kontrola = $this->kontrola();
        if($kontrola===true){
            Dogadaj::update($id);
            $this->index();
        }else{
            $view = new View();
            $view->render(
                'dogadaji/edit',
                [
                "poruka"=>$kontrola
                ]
            );
        }

    }

    function delete($id)
    {
            Dogadaj::delete($id);
            $this->index();
    }

    function kontrola()
    {
        if(Request::post("naziv")===""){
            return "Obavezno unijeti naziv događaja";
        }

        if(Request::post("izvodac")===""){
            return "Obavezno unijeti izvođaća događaja";
        }

        if(Request::post("administrator")===""){
            return "Obavezno unijeti administrator događaja";
        }

        if(Request::post("termin")===""){
            return "Obavezno unijeti termin događaja";
        }


        return true;
    }

    function prepareadd()
    {
        $view = new View();
        $view->render(
            'dogadaji/new',
            [
            "poruka"=>""
            ]
        );
    }

    function prepareedit($id)
    {
        // var_dump($_FILES);
        // $datoteka = APP::config("path") . "public/css/dogadaji/" . $id . ".png"; 
        // move_uploaded_file($_FILES["slika"]["tmp_name"],$datoteka);

        $view = new View();
        $dogadaj = Dogadaj::find($id);
        $_POST["vrsta"]=$dogadaj->vrsta;
        $_POST["naziv"]=$dogadaj->naziv;
        $_POST["izvodac"]=$dogadaj->izvodac;
        $_POST["organizator"]=$dogadaj->organizator;
        $_POST["administrator"]=$dogadaj->administrator;
        $_POST["termin"]=$dogadaj->termin;
        $_POST["sifra"]=$dogadaj->sifra;

        $view->render(
            'dogadaji/edit',
            [
            "poruka"=>""
            ]
        );
    }
}