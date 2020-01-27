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

        $tmp_img = $_FILES["user_image"]["tmp_name"];
        $img_name = $_FILES["user_image"]["name"];
        $upload_dir = "./images/".$img_name;

        $data = json_decode( file_get_contents( 'php://input' ), true );

        $first_name = $data['first_name'];
        $surname = $data['surname'];
        $emails = $data['emails'];
        $phones = $data['phones'];



        $phone_book = PhoneBook::getInstance();
        $json = $phone_book->addSinglePhoneBook($first_name, $surname, $emails,$phones,$tmp_img, $upload_dir);
        echo json_encode($json);

    }
    public function isPutRequest(){

        $tmp_img = $_FILES["user_image"]["tmp_name"];
        $img_name = $_FILES["user_image"]["name"];
        $upload_dir = !empty($img_name) ?"./images/".$img_name: '';

        $data = json_decode( file_get_contents( 'php://input' ), true );

        $id = $data['id'];
        $first_name = $data['first_name'];
        $surname = $data['surname'];
        $emails = $data['emails'];
        $phones = $data['phones'];

        $phone_book = PhoneBook::getInstance();
        $json = $phone_book->updateSinglePhoneBook($id,$first_name, $surname, $emails, $phones, $tmp_img, $upload_dir);
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
        if(($_SERVER['REQUEST_METHOD']=="POST" && is_uploaded_file($_FILES["user_image"]["tmp_name"])) || ($_SERVER['REQUEST_METHOD']=="POST")){
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