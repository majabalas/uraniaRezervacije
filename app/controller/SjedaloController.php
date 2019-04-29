<?php

class SjedaloController extends ProtectedController
{

    function dodajGledatelja()
    {

        echo Sjedalo::dodajGledatelja(Request::post("sjedalo"),Request::post("gledatelj"));

    }

    function obrisiGledatelja()
    {

        echo Sjedalo::obrisiGledatelja(Request::post("sjedalo"),Request::post("gledatelj"));

    }



    function edit()
    {
        Sjedalo::update();
        $dogadaj=Request::post("dogadaj");
        $this->index($dogadaj);
 
    }

    function prepareedit($id){
        $view = new View();
        $sjedalo = Sjedalo::find($id);
        $_POST = (array)$sjedalo;
        $view->render(
            'sjedala/edit',
            [
            "poruka"=>""
            ]
        );
    }


    function delete()
    {
        Sjedalo::delete();
        $dogadaj=Request::post("dogadaj");
        $this->index($dogadaj);
    }

    function index($id){
        $view = new View();
        $view->render(
            'sjedala/index',
            [
            "sjedala"=>Sjedalo::read($id)
            ]
        );
    }




    function prepareEditSjedalo(){
        $view = new View();
        $sjedalo=Request::post("sjedalo");
        $dogadaj=Request::post("dogadaj");
        $gledatelj=Request::post("gledatelj");
        $naziv = Sjedalo::naziv($dogadaj);

    
        $view->render(
            'sjedala/editSjedalo',
            [
            "sjedalo"=>$sjedalo,
            "dogadaj"=>$dogadaj,
            "naziv"=>$naziv,
            "gledatelj"=>Sjedalo::gledatelj()
            ]
        );
    }





}