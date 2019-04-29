<?php

class ArhivaController{

    function pretraga()
    {
        $uvjet=$_POST["uvjet"];
        
        $view = new View();
        $view->render(
            'arhive/rezultati',
            [
                "poruka"=>Arhiva::pretraga($uvjet)
                ]
        );

    }
    
    function vrati($id)
    {

        Arhiva::vrati($id);
            $this->index();

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
            'arhive/index',
            [
            "arhive"=>Arhiva::read($stranica)
            ]
        );
}
}