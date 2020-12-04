<?php

/*stringi łączymy za pomocą kropki*/

require_once 'AppController.php'; /*importujemy klasę z której będziemy dziedziczyc*/
require_once __DIR__.'/../models/User.php'; /*musimy importować user ale by to zrobic musimy wyjsc z tego katalogu i wejsc do katalogu models*/
require_once __DIR__.'/../repository/UserRepository.php';

class SecurityController extends AppController
{
    public function login()
    {
        /*pobieramy dane, które zostaną wysłane z formularza z indeksu ze strony startowej indeksu za pomocą formularza, którego mamy umieszczonego w login - tagu form odebrac go w seruritycontrolerze, pobrać takie dane czyli email oraz hasło a następnie zweryfikować czy taki użytkownik istnieje w naszym systemie*/
        /*stworzenie fikcyjnego użytkownika - bo nie mamy bazy danych na tym etapie*/

        //$user = new User('jsnow@pk.edu.pl', 'admin', 'Johnny', 'Snow');/*stworzony obiekt użytkownika - SZTUCZNY*/

        $userRepository = new UserRepository();

        /*var_dump($_POST); // debagujemy zmienna post
        die();*/

        if (!$this->isPost()) { //jeżeli dane nie zostały przesłane
            return $this->render('login');
        }

        $email = $_POST['email'];  //emaile w bazie danych są unikalne dla danego użytkownika
        $password = $_POST['password'];

        $user = $userRepository->getUser($email); //przechwycony email z powyższego kodu

        if(!$user){ //sprawdzam czy taki użytkownik istnieje
            return $this->render('login', ['messages' =>['User not exist!']]);
        }

        /*sprawdzamy czy dane emaili password pokrywają się z danymi, które znajdują się w bazie danych userv- fikcyjny */
        if ($user -> getEmail() !== $email){
            return $this->render('login', ['messages' =>['User with this email not exist!']]);
        }


        /*sprawdzamy czy hasło dla tego użytownika jest różne od tego hasła które zapisaliśmy wyżej - password, jeżeli tak jest to zwracamy nasz formularz logowania  */
        if ($user->getPassword() !== $password){
            return $this->render('login', ['messages' => ['Wrong password']]);
        }
        /*jeżeli dane będą poprawne tzn ze zaden z komunikatów nie zostanie wyrzucony i nie wejdziemy do żadnego warunku if z powyzszych to chcemy wyjsc sobie na nasza str project używając return*/
        //   return $this->render('project');

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/projects");
    }
}