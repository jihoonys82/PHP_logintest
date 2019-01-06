<?php
    /**
     * loginCheck.php
     * This file is to check the logged in user is valid.
     * !!!!TEST PURPOSE!!!!
     * @Since 2019 Jun. 06
     * @Author Jihoon Jeong 
     */
    session_start();

    if($_POST['userId'] != null && $_POST['password'] !=null ) {
        $userInfo->userId = $_POST['userId'];
        $userInfo->password = $_POST['password'];

        // TODO : Databass check 
        // temporarily, hard coding is applied for the testcase  
        if($userInfo->userId == "hr@auphansoftware.com" && $userInfo->password =="hello") {
            $userInfo->result = 1;
            $_SESSION['login'] = true;
        } else { 
            $userInfo->result = -1;
        }
        
    }
    $jsonResult = json_encode($userInfo);
    echo $jsonResult;

?>