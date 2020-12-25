<?php

include("connection.php");
$errors = array();
if (isset($_POST["btnRegister"])) {
    if (isset($_POST["g-recaptcha-response"]) && !empty($_POST["g-recaptcha-response"])) {
        $secret = "secret";
        //$verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $_POST['g-recaptcha-response']);
        
        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => 'https://www.google.com/recaptcha/api/siteverify',
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => [
                'secret' => $secret,
                'response' => $_POST["g-recaptcha-response"],
                'remoteip' => $_SERVER['REMOTE_ADDR']
            ],
            CURLOPT_RETURNTRANSFER => true
        ]);

        $output = curl_exec($ch);
        curl_close($ch);

        $responseData = json_decode($output);

        if ($responseData->success) {
            $username = $_POST["regUsername"];
            $password = $_POST["regPassword"];
            $email = $_POST["regEmail"];

            if (!preg_match("/^[a-zA-Z0-9]{3,20}$/", $username)) {
                $errors[] = "Username is incorrect!";
            } else {
                $query_users = mysqli_query($conn, sprintf("SELECT * FROM users WHERE username='%s'", $username));
                if (mysqli_num_rows($query_users) > 0)
                    $errors[] = "That username is taken!";
            }

            if (!preg_match("/^[a-zA-Z0-9]{4,30}$/", $password) || empty($password))
                $errors[] = "Password is incorrect!";

            if (!preg_match("/^[a-zA-Z0-9]+([\.-]?[a-zA-Z0-9]+)*@[a-zA-Z0-9]+([\.-]?[a-zA-Z0-9]+)*(\.[a-zA-Z0-9]+)+$/", $email)) {
                $errors[] = "E-mail is incorrect!";
            } else {
                $query_email = mysqli_query($conn, sprintf("SELECT * FROM users WHERE email='%s'", $email));
                if (mysqli_num_rows($query_email) > 0)
                    $errors[] = "That e-mail is already used!";
            }

            if (count($errors) == 0) {
                $query_add_user = mysqli_query($conn, sprintf("INSERT INTO users (username, password, email, date_created, id_role, last_login) VALUES('%s', '%s', '%s', %d, %d, %d)", $username, md5($password), $email, time(), 2, time()));
                if ($query_add_user) {
                    $_SESSION["id_role"] = 2;
                    $_SESSION["id_user"] = mysqli_insert_id($conn);
                    $_SESSION["username"] = $username;
                    @header("Location: account.php");
                }
                $errors[] = "Database error!";
            }
        } else {
            $errors[] = "reCAPTCHA verification failed!";
        }
    } else {
        $errors[] = "Check the reCAPTCHA button!";
    }
}
?>