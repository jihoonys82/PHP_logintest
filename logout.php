<?php
    /**
     * logout.php
     * It destory serverside session.
     * !!!!TEST PURPOSE!!!!
     * @Since 2019 Jun. 06
     * @Author Jihoon Jeong 
     */
    session_start();

    session_unset();

    session_destroy();

?>