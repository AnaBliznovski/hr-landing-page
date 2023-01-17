<?php

session_start();
date_default_timezone_set("Europe/Skopje");

require_once 'config.php';

error_reporting(E_ALL);

$fullname = $email = $phone = $position = $resume = $message =  "";

// $firstname_err = $lastname_err = $email_err = $telephone_err = $city_err = $company_err = $wherefrom_err = "";

//writing to DB form info

// initilizacing empty array
// $values = ['firstname' => '', 'lastname' => '', 'email' => '', 'phone' => '', 'city' => '', 'company' => '', 'wherefrom' => ''];
// $formValues = $values;

//initialize at start that we dont have errors yet
// $errors = [];

// $formValues = array_merge($values, $_POST);

// if (empty($_POST['firstname']) || empty(trim($_POST['firstname']))) {
//     $firstname_err = "firstname is required";
// } else {
//     $firstname = trim($_POST['firstname']);
// }

// if (empty($_POST['lastname']) || empty(trim($_POST['lastname']))) {
//     $lastname_err = "lastname is required";
// } else {
//     $lastname = trim($_POST['lastname']);
// }

// if (empty($_POST['email']) || empty(trim($_POST['email']))) {
//     $email_err = "email is required";
// } else {
//     $email = trim($_POST['email']);
// }

// if (empty($_POST['telephone']) || empty(trim($_POST['telephone']))) {
//     $telephone_err = "telephone is required";
// } else {
//     $telephone = trim($_POST['telephone']);
// } 

// if (empty($_POST['city']) || empty(trim($_POST['city']))) {
//     $city_err = "city is required";
// } else {
//     $city = trim($_POST['city']);
// } 

// if (empty($_POST['company']) || empty(trim($_POST['company']))) {
//     $company_err = "company is required";
// } else {
//     $company = trim($_POST['company']);
// } 

// if (empty($_POST['wherefrom']) || empty(trim($_POST['wherefrom']))) {
//     $wherefrom_err = "wherefrom is required";
// } else {
//     $wherefrom = trim($_POST['wherefrom']);
// } 

// if (empty($firstname_err) && empty($lastname_err) && empty($email_err) && empty($telephonephone_err) && empty($city_err) && empty($company_err) && empty($wherefrom_err)) {
// $firstname = $formValues['firstname'];
// $lastname = $formValues['lastname'];
// $email = $formValues['email'];
// $phone = $formValues['phone'];
// $city = $formValues['city'];
// $company = $formValues['company'];
// $wherefrom = $formValues['wherefrom'];

$sql = "INSERT INTO jobapplications (fullname, phone, email, position, resume, message) VALUES (:fullname, :phone, :email, :position, :resume, :message)";

// $sql = "INSERT INTO `registrations` (`firstname`, `lastname`, `email`, `phone`, `city`, `company`, `wherefrom`) 
//         VALUES (
//             '" . $firstname . "', 
//             '" . $lastname . "',
//             '" . $email . "',
//             '" . $phone . "',
//             '" . $city . "',
//             '" . $company . "',
//             '" . $wherefrom . "'
//         )";

if ($stmt = $pdo->prepare($sql)) {
    // bind
    $stmt->bindParam(":fullname", $param_fullname);
    $stmt->bindParam(":phone", $param_lastname);
    $stmt->bindParam(":email", $param_email);
    $stmt->bindParam(":position", $param_position);
    $stmt->bindParam(":resume", $param_resume);
    $stmt->bindParam(":message", $param_message);
    var_dump($stmt);
    var_dump($sql);
    var_dump($pdo);
    // set
    $param_fullname = $fullname;
    $param_phone = $phone;
    $param_email = filter_var($email, FILTER_VALIDATE_EMAIL, FILTER_SANITIZE_EMAIL);
    $param_position = $position;
    $param_resume = $resume;
    $param_message = $message;
    var_dump($stmt);
    var_dump($resume);
    var_dump($param_resume);

    if ($stmt->execute()) {
        /* Kreirajte poraka za uspeshno vnesen RESERVATION istata isprintajte ja vo index.php
             vo box koj kje stoi 4 sekundi i potoa kje ischezne */
        // $_SESSION['added'] = true;
        // $SQLRESERVE = "SELECT LAST_INSERT_ID() as id FROM reservations";
        // if ($result = $pdo->prepare($SQLRESERVE)) {
        //     if ($result->execute()) {
        //         if ($result->rowcount()) {
        //             if ($row = $result->fetch()) {
        //                 $id = $row["id"];
        //                 $_SESSION['id'] = $id;
        //             }
        //         }
        //     }
        //     unset($result);
        // }
        // redirect to index with id parametar to showcase the info for reservation
        // exit(header("Location: index.php"));
        var_dump($stmt->execute());
        echo 'sent';
        header("location: ../index.html");

        exit();
        // header("location: index.php?id=" . $id . "");
        // header("location: index.php?id=" . $id . "#reservation");
    } else {
        echo 'failed';
    }
    unset($stmt);
}

unset($pdo);

// $formValues = $values; //Reset form values to be empty, otherwise the form will still have values from the product that we already have created


?>


