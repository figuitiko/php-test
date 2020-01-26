<?php

include('database.php');



class PhoneBook{


    private static $instance = null;



    public static function getInstance()
    {
        if (self::$instance == null)
        {
            self::$instance = new PhoneBook();
        }

        return self::$instance;
    }
    public function getAllPoneBookList()
    {
        $pdo = Database::connect();

        $sql = "SELECT * FROM phone_book";

        try {

            $query = $pdo->prepare($sql);
            $query->execute();
            $all_phone_books = $query->fetchAll(PDO::FETCH_ASSOC);
//            var_dump($all_phone_books);  exit;
            $i = 0;
            foreach ($all_phone_books as $all_phone_book){


//                var_dump($all_phone_book['idphone_book']);
//                echo $all_phone_book['idphone_book']; exit;
                $sql_phones = "SELECT * FROM phone_number where idphone_book = '{$all_phone_book['idphone_book']}'";
                $query_phones = $pdo->prepare($sql_phones);
                $query_phones->execute();
                $phones =  $query_phones->fetchAll(PDO::FETCH_ASSOC);
                $all_phone_book['phones'] = $phones;
                $all_phone_books[$i] = $all_phone_book;
                $i++;

            }

        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }

        Database::disconnect();
        return $all_phone_books;
    }

    public function getSinglePhoneBook($id)
    {
        $pdo = Database::connect();
//        echo $id; exit;
        $sql = "SELECT * FROM phone_book where idphone_book = '{$id}'";
        $sql_phones = "SELECT * FROM phone_number where idphone_book = '{$id}'";

        try {
            $query = $pdo->prepare($sql);
            $query->execute();
            $phone_book = $query->fetchAll(PDO::FETCH_ASSOC);

           if($sql_phones){
               $query_phones = $pdo->prepare($sql_phones);
               $query_phones->execute();
               $phones =  $query_phones->fetchAll(PDO::FETCH_ASSOC);
               $phone_book['phones'] = $phones;
           }




        } catch (PDOException $e) {

            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
        Database::disconnect();
        return $phone_book;
    }
    public function updateSinglePhoneBook($id, $first_name, $surname, $email,$phones)
    {

        $pdo = Database::connect();
        $sql = "UPDATE phone_book SET first_name = '{$first_name}', surname ='{$surname}',email = '{$email}' where idphone_book = '{$id}'";
        $status = [];



        try {


            $query = $pdo->prepare($sql);
            $result = $query->execute();
            $sql_phones = "SELECT * FROM phone_number where idphone_book = '{$id}'";
            $query_phones = $pdo->prepare($sql_phones);
            $query_phones->execute();
            $phones_saved =  $query_phones->fetchAll(PDO::FETCH_ASSOC);
            $i = 0;
            foreach ($phones as $phone){
                if($phones_saved){
                    foreach ($phones_saved as $saved ){

                        $sql_phone_one = "UPDATE phone_number SET number_phone = '{$phone}' where idphone_number = '{$saved['idphone_number']}'";

                        $phones_query = $pdo->prepare($sql_phone_one);
                        $phones_result = $phones_query->execute();

                    }
                }

            }
            if ($result && $phones_result) {
                $status['message'] = "Data updated";
            } else {
                $status['message'] = "Data is not updated";
            }

        } catch (PDOException $e) {

            $status['message'] = $e->getMessage();
        }

        Database::disconnect();
        return $status;
    }
    public function addSinglePhoneBook($first_name, $surname, $email,$phones)
    {

        $pdo = Database::connect();

        $sql = "INSERT INTO phone_book(`first_name`,`surname`,`email`) VALUES('" . $first_name . "', '" . $surname . "', '" . $email . "')";
        $status = [];


        try {

            $query = $pdo->prepare($sql);
            $result = $query->execute();
            $last_id = $pdo->lastInsertId();

           if($phones){
               foreach ($phones as $phone){


                   $sql_phones = "INSERT INTO phone_number(`number_phone`,`idphone_book`) VALUES('" . $phone . "', '" .$last_id. "')";

                   $phones_query = $pdo->prepare($sql_phones);
                   $phones_result = $phones_query->execute();
               }
           }



            if ($result && $phones_result) {
                $status['message'] = "Data inserted";
            } else {
                $status['message'] = "Data is not inserted";
            }

        } catch (PDOException $e) {

            $status['message'] = $e->getMessage();
        }

        Database::disconnect();
        return $status;
    }
    public function deletePhoneBook($id)
    {

        $pdo = Database::connect();
        $sql = "DELETE FROM phone_book where idphone_book = '{$id}'";
        $status = [];
        $sql_phones = "SELECT * FROM phone_number where idphone_book = '{$id}'";
        $query_phones = $pdo->prepare($sql_phones);
        $query_phones->execute();
        $phones_saved =  $query_phones->fetchAll(PDO::FETCH_ASSOC);

//        var_dump($phones_saved); exit;

        try {

            $query = $pdo->prepare($sql);
            $result = $query->execute();

            if($phones_saved){

                foreach ($phones_saved as $saved){
                    $sql_phone_one = "DELETE FROM phone_number where idphone_number = '{$saved['idphone_number']}'";
                    $phones_query = $pdo->prepare($sql_phone_one);
                    $phones_result = $phones_query->execute();
                }
            }
            if ($result &&  $phones_result) {
                $status['message'] = "Data deleted";
            } else {
                $status['message'] = "Data is not deleted";
            }

        } catch (PDOException $e) {

            $status['message'] = $e->getMessage();
        }

        Database::disconnect();
        return $status;
    }
}












