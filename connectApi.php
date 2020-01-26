<?php

include('lib/phonebook.php');

class ConnectApi{
    private static $instance = null;



    public static function getInstance()
    {
        if (self::$instance == null)
        {
            self::$instance = new ConnectApi();
        }

        return self::$instance;
    }
    public function isGetRequest(){

        if(isset($_GET['id']))
        {

            $phone_book = PhoneBook::getInstance();
            $id =  $_GET['id'];
            $json =$phone_book->getSinglePhoneBook($id);
            if(empty($json)){
                header("HTTP/1.1 404 Not Found");
            }

            echo json_encode($json);
        }
        else{

            $phone_books = PhoneBook::getInstance();
            $json = $phone_books->getAllPoneBookList();


            echo json_encode($json);
        }


    }
    public function isPostRequest(){

        $data = json_decode( file_get_contents( 'php://input' ), true );



        $first_name = $data['first_name'];
        $surname = $data['surname'];
        $email = $data['email'];
        $phones = $data['phones'];
//            echo $phones; exit;
//            var_dump($phones);

        $phone_book = PhoneBook::getInstance();
        $json = $phone_book->addSinglePhoneBook($first_name, $surname, $email,$phones);
        echo json_encode($json);

    }
    public function isPutRequest(){

        $data = json_decode( file_get_contents( 'php://input' ), true );

        $id = $data['idphone_book'];
        $first_name = $data['first_name'];
        $surname = $data['surname'];
        $email = $data['email'];
        $phones = $data['phones'];

        $phone_book = PhoneBook::getInstance();
        $json = $phone_book->updateSinglePhoneBook($id,$first_name, $surname, $email, $phones);
        echo json_encode($json);
    }
    public function  isDeleteRequest(){

        if(isset($_GET['id'])){
            $id =  $_GET['id'];
            $phone_book = PhoneBook::getInstance();

            $json = $phone_book->deletePhoneBook($id);

            echo json_encode($json);
        }




    }
    public function run(){
        if($_SERVER['REQUEST_METHOD']=="GET"){
            $this->isGetRequest();
        }
        if($_SERVER['REQUEST_METHOD']=="POST"){
            $this->isPostRequest();
        }
        if($_SERVER['REQUEST_METHOD']=="PUT"){
            $this->isPutRequest();
        }
        if($_SERVER['REQUEST_METHOD']=="DELETE"){
            $this->isDeleteRequest();
        }
    }
}