<?php

class UputeController{
    function index(){
        $view = new View();
        $view->render('upute');
    }
}