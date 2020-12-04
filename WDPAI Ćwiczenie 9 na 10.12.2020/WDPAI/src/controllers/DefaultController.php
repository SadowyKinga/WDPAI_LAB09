<?php

require_once 'AppController.php'; /*importujemy klasę z której będziemy dziedziczyc*/
class DefaultController extends AppController{ /*extends - dziedziczenie po klasie AppController*/

    /*funckje do otwierania login i projects - wczesniej juz utworzone widoki*/
    public function index(){
        //die("index method");  //zatrzymanie interpretera
        $this ->render('login');//wywołujemy metodę z klasy bazowej i przekazujemy do niej nazwe naszego pliku
    }

    public function projects(){

        //die("projects method");  //zatrzymanie interpretera
        $this ->render('projects');//wywołujemy metodę z klasy bazowej i przekazujemy do niej nazwe naszego pliku
    }
}
