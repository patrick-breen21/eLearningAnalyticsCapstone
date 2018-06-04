<?php

    $hashes = [
        'a92aa38a05297c2960c37c75699c41a8',
        '872b7d573c52a73896be9c0ea6bdc6b3',
        '54d001105729d32c90e5ce47012df6ca',
        'ae595039b3670d1c67faa074b0aa05fc',
        '362b08cbef18e826ea663d30b5d04d40',
        '6356be2af8942824196216aee572c073',
        '6681bb0816a7d9234a1e348ddcc570e2',
        'af6bd8fe7e909679540a3406f78cacd3',
        '92f0e64800fc85ea4c3882c3a9eb50e0',
        'f97850ef12876c3e0c353685c3382bb4',
        '900c83b1d545bea4e1e480f4d7737110',
        '8d865e922d6850fd73a6b04e29cc4c99',
        'e5d6c91f6b778a465c305f67c4fda62e',
        'fa4c74d424c83ab22c3d062d1efa2777',
        '4fa361cff7617c7534ee7adc47fe00bd',
    ];
    
    $users = [
        'n9708707'=> [
            'username' => 'n9708707',
            'hash' => $hashes[0],
            'email' => 'kiara.davison@connect.qut.edu.au',
            'firstname' => 'Kiara',
            'lastname' => 'Davison',
            'password' => password_hash("kiara", PASSWORD_DEFAULT)
        ],
        
        'n9441638'=> [
            'username' => 'n9441638',
            'hash' => $hashes[1],
            'email' => 'george.walkerfitzgerald@connect.qut.edu.au',
            'firstname' => 'George',
            'lastname' => 'Fitzgerald',
            'password' => password_hash("george", PASSWORD_DEFAULT)
        ],
        
        'n9820132'=> [
            'username' => 'n9820132',
            'hash' => $hashes[2],
            'email' => 'b.giles@connect.qut.edu.au',
            'firstname' => 'Ben',
            'lastname' => 'Giles',
            'password' => password_hash("ben", PASSWORD_DEFAULT)
        ],
        
        'n9726306'=> [
            'username' => 'n9726306',
            'hash' => $hashes[3],
            'email' => 'patrick.breen@connect.qut.edu.au',
            'firstname' => 'Patrick',
            'lastname' => 'Breen',
            'password' => password_hash("patrick", PASSWORD_DEFAULT)
        ],

        'demo'=> [
            'username' => 'demo',
            'hash' => $hashes[1],
            'email' => 'demo@connect.qut.edu.au',
            'firstname' => 'Demo',
            'lastname' => 'User',
            'password' => password_hash("demo", PASSWORD_DEFAULT)
        ],
    ];
    
    if(isset($_POST) & !empty($_POST)){
        $username = $_POST['username'];
        $password = $_POST['password'];
    } else {
        $username = false;
        $password == false;
    }
    
    if ($dev) $_SESSION['user'] = $users[ 'n9708707' ];
    

    if ($username && $password && !isset($_SESSION['user'])){
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

<?php if (!isset($_SESSION['user'])): ?>
    <? echo '<script type="text/javascript">
           window.location = "login.php"
      </script>'; ?>
<?php endif; ?>