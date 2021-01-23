<?php

    include 'dbconnect.php';

    if($_POST['action']=='add_note'){
        try{
            $name = $_POST["data"]["name"];
            $description = $_POST["data"]["description"];
            $user_id = $_POST["data"]["userID"];
            ///pdo
            $pdo->beginTransaction();
            $prepared_statement = $pdo->prepare("INSERT INTO notes_gasta(name, description, user_id, status) VALUES(?,?,?,?)");
            $prepared_statement->execute(array($name, $description, $user_id, 1));
            $pdo->commit();
        }catch(Exception $e){
            $pdo->rollBack();
            throw $e;
        }
    }else if($_POST['action']=='get_notes')
    {
        $user_id = $_POST['user_id'];
        console.log($user_id);
        try{

            $sql = "SELECT * FROM notes_gasta WHERE user_id = $user_id AND status = 1";
            $stm = $pdo->query($sql);
            $rows = $stm->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($rows);

        }catch(Exception $e){
            throw $e;
        }
    }else if($_POST['action']=='delete_note'){
        

        $note_id = intval($_POST['id']);

        try{
            $pdo->beginTransaction();
            $prepared_statement = $pdo->prepare("DELETE FROM notes_gasta WHERE id=?");
            $prepared_statement->execute(array($note_id));
            $pdo->commit();
            echo "deleted";
        }catch(Exception $e){
            $pdo->rollBack();
            throw $e;
        }
    }else if($_POST['action']=='edit_note'){
    
        try{
            $pdo->beginTransaction();
            $prepared_statement = $pdo->prepare("UPDATE notes_gasta SET name=?, description=?, updated_at=? WHERE id=?");
            $prepared_statement->execute(array($_POST['data']['name'], $_POST['data']['description'], date("Y-m-d H:i:s"), $_POST['data']['id']));
            $pdo->commit();
            echo "edited";
        }catch(Exception $e){
            $pdo->rollBack();
            throw $e;
        }
    }else if($_POST['action']=='register'){

        try{
            $fullname = $_POST['data']['fullname'];
            $username = $_POST['data']['username'];
            $password = $_POST['data']['password'];
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            
            $pdo->beginTransaction();
            $prepared_statement = $pdo->prepare("INSERT INTO user_gasta(fullname, username, password) VALUES(?, ?, ?)");
            $prepared_statement->execute(array($fullname, $username, $hashed_password));
            $pdo->commit();
        }
        catch(Exception $e){
            $pdo->rollBack();
            throw $e;
        }
    }
    // }else if($_POST['action']=='logIn'){

    //     try{
            
    //         $username = $_POST['data']['username'];
    //         $password_check = $_POST['data']['password'];

    //         // $sql = "SELECT FROM user_gasta WHERE username = $username";
    //         // $stm = $pdo->query($sql);
    //         // $compare = $stm->fetchAll(PDO::FETCH_ASSOC);

    //         if ($stmt = $pdo->prepare('SELECT id, password FROM user_gasta WHERE username = $username')) {
    //             // Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
    //             $stmt->bind_param('s', $username);
    //             $stmt->execute();
    //             // Store the result so we can check if the account exists in the database.
    //             $stmt->store_result();

    //             if ($stmt->num_rows > 0) {
    //                 $stmt->bind_result($id, $password);
    //                 $stmt->fetch();
    //                 // Account exists, now we verify the password.
    //                 // Note: remember to use password_hash in your registration file to store the hashed passwords.
    //                 if (password_verify($password_check, $password)) {
    //                     // Verification success! User has logged-in!
    //                     // Create sessions, so we know the user is logged in, they basically act like cookies but remember the data on the server.
    //                     session_regenerate_id();
    //                     $_SESSION['loggedin'] = TRUE;
    //                     $_SESSION['name'] = $_POST['username'];
    //                     $_SESSION['id'] = $id;
    //                     header('Location: home.php');
    //                 } else {
    //                     // Incorrect password
    //                     echo 'Incorrect username and/or password!';
    //                 }
    //             } else {
    //                 // Incorrect username
    //                 echo 'Incorrect username and/or password!';
    //             }
            
            
    //             $stmt->close();
    //         }

            

    //         $isUser = password_verify($password,json_encode($compare['$password']));
    //         if($isUser == 'true'){
    //             echo 'Valid';
    //         }else echo 'Invalid';

    //     }
    //     catch(Exception $e){
    //         $pdo->rollBack();
    //         throw $e;
    //     }
    

?>