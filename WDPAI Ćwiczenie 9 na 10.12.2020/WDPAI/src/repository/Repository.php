<?php

//klasa podstawowa dziedziczona przez UserRepository oraz otiera nam ona połączenie z bazą danych

require_once  __DIR__.'/../../Database.php';

class Repository
{
    protected $database;

    public function __construct()
    {
        $this->database = new Database();
    }
}
