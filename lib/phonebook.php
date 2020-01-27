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

        $sql = "SELECT * FROM phone_books";

        try {

            $query = $pdo->prepare($sql);
            $query->execute();
            $all_phone_books = $query->fetchAll(PDO::FETCH_ASSOC);

            $i = 0;

            foreach ($all_phone_books as $all_phone_book){



                $sql_phones = "SELECT * FROM phone_numbers where id_phone_book = '{$all_phone_book['id']}'";
                $query_phones = $pdo->prepare($sql_phones);
                $query_phones->execute();
                $phones =  $query_phones->fetchAll(PDO::FETCH_ASSOC);



                if(!empty($phones)){

                    $all_phone_book['phones'] = $phones;
                    $all_phone_books[$i] = $all_phone_book;
                }

                $sql_emails = "SELECT * FROM emails where id_phone_book = '{$all_phone_book['id']}'";
                $query_emails = $pdo->prepare($sql_emails);
                $query_emails->execute();
                $emails =  $query_emails->fetchAll(PDO::FETCH_ASSOC);



                if($emails){

                    $all_phone_book['emails'] = $emails;
                    $all_phone_books[$i] = $all_phone_book;
                }
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

        $sql = "SELECT * FROM phone_books where id = '{$id}'";
        $sql_phones = "SELECT * FROM phone_numbers where id_phone_book = '{$id}'";
        $sql_emails = "SELECT * FROM emails where id_phone_book = '{$id}'";

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
            if($sql_emails){
                $query_emails = $pdo->prepare($sql_emails);
                $query_emails->execute();
                $emails =  $query_emails->fetchAll(PDO::FETCH_ASSOC);
                $phone_book['emails'] = $emails;

            }




        } catch (PDOException $e) {

            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
        Database::disconnect();
        return $phone_book;
    }

    public function updateSinglePhoneBook($id, $first_name, $surname,$emails, $phones, $tmp_img, $upload_dir)
    {

        $pdo = Database::connect();

        $sql = "UPDATE phone_books SET first_name = '{$first_name}', surname ='{$surname}',img_url = '{$upload_dir}, ' where id = '{$id}'";
        $status = [];

        try {

            if(!empty($tmp_img) && !empty($upload_dir)){
                move_uploaded_file($tmp_img, $upload_dir);
            }

            $query = $pdo->prepare($sql);
            $result = $query->execute();
            $sql_phones = "SELECT * FROM phone_numbers where id_phone_book = '{$id}'";
            $query_phones = $pdo->prepare($sql_phones);
            $query_phones->execute();
            $phones_saved =  $query_phones->fetchAll(PDO::FETCH_ASSOC);

            $sql_emails = "SELECT * FROM emails where id_phone_book = '{$id}'";
            $query_emails = $pdo->prepare($sql_emails);
            $query_emails->execute();
            $emails_saved =  $query_emails->fetchAll(PDO::FETCH_ASSOC);

            $i = 0;

            foreach ($phones as $phone){

                if($phones_saved){
                        $sql_phone_one = "UPDATE phone_numbers SET number_phone = '{$phone}' where id = '{$phones_saved[$i]['id']}'";

                        $phones_query = $pdo->prepare($sql_phone_one);
                        $phones_result = $phones_query->execute();
                        $i++;
                }
                else {
                    $sql_phones = "INSERT INTO phone_numbers(`number_phone`,`id_phone_book`) VALUES('" . $phone . "', '" .$id. "')";
                    $phones_query = $pdo->prepare($sql_phones);
                    $phones_result = $phones_query->execute();

                }

            }
            $j = 0;
            foreach ($emails as $email){
                if($emails_saved){

                        $sql_email_one = "UPDATE emails SET email_address = '{$email}' where id = '{$emails_saved[$j]['id']}'";

                        $email_query = $pdo->prepare($sql_email_one);
                        $email_result = $email_query->execute();
                        $j++;

                }
                else {

                    $sql_email_one = "INSERT INTO emails (`email_address`,`id_phone_book`) VALUES('" . $email . "', '" .$id. "')";
                    $email_query = $pdo->prepare($sql_email_one);
                    $email_result = $email_query->execute();
                }

            }


            if ($result || $phones_result|| $email_result ) {
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
    public function addSinglePhoneBook($first_name, $surname, $emails,$phones, $tmp_img, $upload_dir)
    {

        $pdo = Database::connect();

        $sql = "INSERT INTO phone_books(`first_name`,`surname`,`img_url`) VALUES('" . $first_name . "', '" . $surname . "','" . $upload_dir . "')";

        $status = [];


        try {

            $query = $pdo->prepare($sql);
            $result = $query->execute();
            $last_id = $pdo->lastInsertId();


            if(!empty($tmp_img) && !empty($upload_dir)){
                move_uploaded_file($tmp_img, $upload_dir);
            }

           if($phones){
               foreach ($phones as $phone){

                   $sql_phones = "INSERT INTO phone_numbers(`number_phone`,`id_phone_book`) VALUES('" . $phone . "', '" .$last_id. "')";
                   $phones_query = $pdo->prepare($sql_phones);
                   $phones_result = $phones_query->execute();
               }
           }
            if($emails){
                foreach ($emails as $email){

                    $sql_emails = "INSERT INTO emails (`email_address`,`id_phone_book`) VALUES('" . $email . "', '" .$last_id. "')";
                    $emails_query = $pdo->prepare($sql_emails);
                    $emails_result = $emails_query->execute();

                }
            }


            if ($result && $phones_result && $emails_result) {

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
        $sql = "DELETE FROM phone_books where id = '{$id}'";
        $status = [];
        $sql_phones = "SELECT * FROM phone_numbers where id_phone_book = '{$id}'";
        $query_phones = $pdo->prepare($sql_phones);
        $query_phones->execute();
        $phones_saved =  $query_phones->fetchAll(PDO::FETCH_ASSOC);

//        var_dump($phones_saved); exit;

        try {

            $query = $pdo->prepare($sql);
            $result = $query->execute();

            if($phones_saved){

                foreach ($phones_saved as $saved){
                    $sql_phone_one = "DELETE FROM phone_numbers where id = '{$saved['id']}'";
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












