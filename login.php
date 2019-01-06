<?php
    /**
     * login.php
     * This file provide VIEW for client.
     * !!!!TEST PURPOSE!!!!
     * @Since 2019 Jun. 06
     * @Author Jihoon Jeong 
     */
    session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login for test - Jihoon</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css?family=Acme" rel="stylesheet">
    <style>
        * {
            color: #FFFFFF;
            font-family: 'Acme', sans-serif;
        }

        #videoClip {
            position: fixed;
            right: 0;
            bottom: 0;
            min-width: 100%; 
            min-height: 100%;
        }

        .container {
            height: 100%;
            width: 100%;
            top: 0;
            left: 0;
            display:table;
            position: absolute;
            z-index: 100;
        }

        .middle {
            display: table-cell;
            vertical-align: middle;
        }

        #login-box { 
            background-color: rgba(33,33,33,0.8);
            margin: auto;
            width: 50%;
            border: 3px solid yellow;
            border-radius: 10px;
            padding : 10px; 
            text-align: center;
        }

        .greeting {
            display: none;
        }

        .inputfield {
            display :block;
        }

        .inputfield label {
            display: inline-block;
            width: 80px;
            text-align: right;
        }
        .input-inline { 
            background-color: #666666;
            color: #FFFFFF;
            width: 150px;
            height: 30px; 
            border: 2px solid  yellow;
            border-radius: 10px;
            margin: 5px;
            padding : 3px 10px;
        }

        .buttons  {
            margin-top: 10px;
        }

        .logout-buttons{
            display: none;
        }

        .btn {
            width: 80px; 
            height: 30px;
            padding : 3px;
            margin : 5px;
            text-align: center; 
            background-color: #999999;
            border: 1px solid yellow;
            border-radius: 10px;
        }

        .message-box {
            border : 5px dashed #000000;
            background : yellow;
            width: 80%;
            height: 1.5em;
            margin : 10px auto;
            padding : 10px;
            display: none;
        }

        #message {
            font-weight: bold;
            color: black;
        }
    </style>
</head>
<body>
    
    <div class="container">
        <div class="middle">

            <div id="login-box">
                <h1>Login for test</h1>
                <div class="greeting">Login Sucessful.</div>
                <div class="login-label">
                    <div class="inputfield">
                        <label for="userId">UserID</label>
                        <input type="text" class="input-inline" name="userId" id="userId" onfocusout="verifyEmail();" />
                    </div>
                    <div class="inputfield">
                        <label for="password">Password</label>
                        <input type="password" class="input-inline" name="password" id="password" />
                    </div>  
                    <div class="buttons login-buttons">
                        <button type="button" class="btn" id="btnLogin">Login</button>
                        <button type="button" class="btn" id="btnSignup">Sign up</button>
                    </div>  
                    <div class="buttons logout-buttons">
                        <button type="button" class="btn" id="btnLogout">Logout</button>
                    </div>
                </div>
                <div class="message-box">    
                    <span id="message" class="blink"></span>
                </div>
            </div>
        </div>
    </div>

    <video autoplay muted loop id="videoClip">
        <source src="img/backgroundclip.mp4" type="video/mp4">
    </video>




<?php
    // page initialization when logged in
    if($_SESSION['login']){
    echo <<<HEREDOC
<script>
    $(".inputfield").hide();
    $(".login-buttons").hide();
    $(".logout-buttons").show();
    $(".greeting").show();
    $("input#userId").val("");
    $("input#password").val("");
</script>
HEREDOC;
    }
?>
    
<script>
$(document).ready(function(){
    // page initialization
    setInterval(function() {
        $(".blink").fadeOut(350);
        $(".blink").fadeIn(250);

    }, 1500);

    //verify field via regex
    verifyEmail = function(){
        var userId = $("input#userId").val();
        var regEx = /^[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*.[a-zA-Z]{2,3}$/i;

        if(userId.match(regEx)!= null) { 
            $("input#userId").css("border", "2px solid yellow");
            $(".message-box").hide();
            $("#message").text("");
            return true;

        } else {
            $("#message").text("Please insert valid email address in UserID");
            $(".message-box").show();
            return false;
        }
    }

    //****button events****
    //login button - ajax
    $("button#btnLogin").on('click',function (){
        if(!verifyEmail()){
            return false;
        }

        var userId = $("input#userId").val();
        var password = $("input#password").val();
        console.log(userId);
        $.ajax({
            type: "post"
            , url: "loginCheck.php"
            , data: { "userId" : userId, "password" : password }
            , dataType: "json"
            , beforeSend : function(){
                $("#message").text("");
                $(".message-box").hide();
            }
            , success: function(data){
                console.log(data);	
                //check login success 
                if(data.result == 1) { 
                    //login -success
                    $(".inputfield").hide();
                    $(".login-buttons").hide();
                    $(".logout-buttons").show();
                    $(".greeting").show();
                    $("input#userId").val("");
                    $("input#password").val("");
                } else {
                    //login fail - alert in message box
                    $("#message").text("CAUTION: Incorrect Username/Password ");
                    $(".message-box").show();
                    $("input#password").val("");
                }
                
            }
            , error : function(e){
                $("#message").text("CAUTION: Ajax Error! Please contact to site admin.");
                $(".message-box").show();
                console.log(e.responseText);
            }
        });
    });

    //signup button - under construction
    $("button#btnSignup").on('click', function(){
        $("#message").text("CAUTION: Sorry, Sign up function is under construction");
        $(".message-box").show();
    });
    
    //logout button
    $("button#btnLogout").on('click', function(){
        $.ajax({
            type: "post"
            , url: "logout.php"
            , success: function(data){	
                $(".inputfield").show();
                $(".login-buttons").show();
                $(".logout-buttons").hide();
                $(".greeting").hide();
                $("input#userId").val("");
                $("input#password").val("");
            }
            , error : function(e){
                $("#message").text("CAUTION: Ajax Error! Please contact to site admin.");
                $(".message-box").show();
                console.log(e.responseText);
            }
        });
    });
});
</script>
</body>
</html>