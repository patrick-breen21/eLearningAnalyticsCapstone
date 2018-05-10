<?php
    $users = [
        'n9708707'=> [
            'username' => 'n9708707',
            'email' => 'kiara.davison@connect.qut.edu.au',
            'firstname' => 'Kiara',
            'lastname' => 'Davison',
            'password' => password_hash("kiara", PASSWORD_DEFAULT)
        ],
        
        'n9441638'=> [
            'username' => 'n9441638',
            'email' => 'george.walkerfitzgerald@connect.qut.edu.au',
            'firstname' => 'George',
            'lastname' => 'Fitzgerald',
            'password' => password_hash("george", PASSWORD_DEFAULT)
        ],
        
        'n9820132'=> [
            'username' => 'n9820132',
            'email' => 'b.giles@connect.qut.edu.au',
            'firstname' => 'Ben',
            'lastname' => 'Giles',
            'password' => password_hash("ben", PASSWORD_DEFAULT)
        ],
        
        'n9726306'=> [
            'username' => 'n9726306',
            'email' => 'patrick.breen@connect.qut.edu.au',
            'firstname' => 'Patrick',
            'lastname' => 'Breen',
            'password' => password_hash("patrick", PASSWORD_DEFAULT)
        ]
    ];
    
    if(isset($_POST) & !empty($_POST)){
        $username = $_POST['username'];
        $password = $_POST['password'];
    } else {
        $username = false;
        $password == false;
    }

    if ($username && $password){
        //echo $username . '<br>';
        //echo $password . '<br>';
        //echo $users[ $username ] ;
        //3.1.1 Assigning posted values to variables.
        
        //3.1.2 Checking the values are existing in the database or not
        //$query = "SELECT * FROM `user` WHERE username='$username' and password='$password'";
         
        //$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
        //$count = mysqli_num_rows($result);
        //3.1.2 If the posted values are equal to the database values, then session will be created for the user.
        if ($users[ $username ]){
            if (password_verify( $password , $users[ $username ]['password'] )) {
                $_SESSION['user'] = $users[ $username ];
                //var_dump($_SESSION['user']);
                //echo isset($_SESSION['user']);
            } else {
                $error = "Username and Password do not match";
                //echo "Username and Password do not match";
            }
        }else {
            //3.1.3 If the login credentials doesn't match, he will be shown with an error message.
            $error = "Invalid Username";
            //echo "Invalid Username";
        }
    }
?>