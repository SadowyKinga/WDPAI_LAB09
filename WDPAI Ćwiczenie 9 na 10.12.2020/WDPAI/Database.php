<?php

/*klasa na utworzenie połączenia z naszą bazą danych*/
require_once 'config.php';
class Database
{
    private $username;
    private $password;
    private $host;
    private $database;

    /*inicjalizujemy z konstruktorze powyższe 4 pola prywatne*/

    public function __construct()
    {
        $this->username = USERNAME;
        $this->password = PASSWORD;
        $this->host = HOST;
        $this->database = DATABASE;
    }

    public function connect()
    {
        /*sprawdzamy czy połączenie wykona się poprawnie czy też nie dlatego całość umieszczamy w bloku try*/
        try{ //łączymy sie z bazą danych
            $conn = new PDO( //PRZEKAZUJEMY OBIEKTY KTÓRE POMOGĄ SIĘ NAM POŁĄCZYĆ Z BAZĄ DANYCH
                "pgsql:host=$this->host;port=5432;dbname=$this->database",  //pierwszy paramentr
                $this->username,
                $this->password,
                ["sslmode" => "prefer"]
            );

            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION); //ZWRACAMY POJAWIAJĄCE SIĘ EWENTUALNE BŁĘDY POJAWIAJĄCE SIĘ PODCZAS ŁĄCZENIA NASZEGO PROGRAMU Z BAZĄ DANYCH
            return $conn; //zwracamy to połączenie
        }catch(PDOException $e){ //łapiemy błąd biblioteki PDO exception zapisana pod zmienna e
            die("Connection failed: ".$e->getMessage());  //wyświetlamy ten komunikat przekazując błąd do funkcji die
        }
    }
}