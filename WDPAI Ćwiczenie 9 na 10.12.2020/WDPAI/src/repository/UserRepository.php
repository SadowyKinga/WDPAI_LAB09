<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/User.php';

class UserRepository extends Repository
{
    public function getUser(string $email): ?User  //funkcja znajdująca użytkownika po jego emailu
    { //w tej metodzie tworzymy nowy obiekt użytkownika, wypełniamy go danymi pobranymi z bazy danych a na koniec zwracamy go
        /*zapytanie sql'owe w prepare*/
        $stmt = $this->database->connect()->prepare(' 
        SELECT * FROM public.users WHERE email =:email
        ');
        //podłączamy parametry pod nasz stmt
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute(); //wykonuje $stmt

        $user = $stmt->fetch(PDO::FETCH_ASSOC); //użytkownika z bazy pobieram do zmiennej tymczasowej i zapisuje do tabeli asocjacyjnej

        if($user == false){ //zabezpieczam gdy użytkownik nie zostanie znaleziony, gdy użytkownik nie zostanie znaleziony wtedy $stmt zwróci nam wartośc false
            return null;
        }

        return new User( //zwracam użytkownika z tabeli asocjacyjnej podając nazwy kolumn z danych które odbieramy
            $user['email'],
            $user['password'],
            $user['name'],
            $user['surname']
        );
    }
}