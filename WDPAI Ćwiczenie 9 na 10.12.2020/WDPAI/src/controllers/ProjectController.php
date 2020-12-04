<?php

/*stringi łączymy za pomocą kropki*/

require_once 'AppController.php'; /*importujemy klasę z której będziemy dziedziczyc*/
require_once __DIR__.'/../models/Project.php'; /*musimy importować user ale by to zrobic musimy wyjsc z tego katalogu i wejsc do katalogu models*/

class ProjectController extends AppController{

    const MAX_FILE_SIZE = 1024*1024;//stała zmienna abyśmy mogli - sprawdzić czy rzeslany plik nie przekracza dozwolonego limitu
    const SUPPORTED_TYPES=['image/png', 'image/jpeg']; //typy plików do przesłania
    const UPLOAD_DIRECTORY = '/../public/uploads/';


    private $messeges = []; //zmienna do której będziemy dodawać nasze komunikaty
    public function addProject()
    {
        //sprawdzam czy została wyknana metoda post oraz czy dany plik moge zaladowac na serwer oraz poprawne dane pliku przesylanego - wielkość i typ
        if ($this->isPost() && is_uploaded_file($_FILES['file']['tmp_name']) && $this->validate($_FILES['file'])) { //zagnieżdżona tablica asocjacyjna
            //przenosimy plik na serwer
            move_uploaded_file(
                $_FILES['file']['tmp_name'],  //nazwa przekazywanego pliku
                dirname(__DIR__).self::UPLOAD_DIRECTORY.$_FILES['file']['name'] //ścieżka z doklejoną nazwą tego pliku zaczynając od ścieżi głównego katalogu __DIR__ w którym aktualnie się znajdujemy
            );

            $project = new Project($_POST['title'], $_POST['description'], $_FILES['file']['name']);//tworzę zmienna project
            return $this->render('projects', ['messages' => $this->messeges, 'project' => $project]); //zwracamy stronę z projektami i dodajemy wiadomości jeśli takie się pojawią oraz wyświetlamy świeżo dodany projekt
        }
        //logika naszego upload'u, naszego przesłania wiadomości wraz z tytułem, opisem a także plikiem przez nasz formularz z add-project.php
        $this ->render('add-project', ['messages' => $this->messeges]); //też przekazujemy komunikaty
    }

    private function validate(array $file):bool //bool - zwracamy true and false
    {
        if($file['size'] > self::MAX_FILE_SIZE){ //sprawdzam czy wielkośc pliku jest mniejsza niż określony max_file_size
            $this->messages[]='File is too large fordestrination file system.'; //jeżeli tak sie dzieje jak linijka wyżej to nie moge załadować oliku i do naszej zmiennej messages wrzucam komunikat
            return false;
        }

        if(isset ($file['type']) && !in_array($file['type'], self::SUPPORTED_TYPES)){ //sprawdzam czy typ został ustawiony na począyku && czy typ pliku jest odpowiedni png i jpeg
            $this->messeges[] = 'File type is not supported';
            return false;
        }
        return true; //jeśli oba warunki są poprawne i nie wejdziemy do nich
    }
}