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
        'd60379e6bf7e7ecb767e337bb7685888',
        '95d53fc95b4461325a0b78ab40d228d1',
        'a6b6d022df0cc0eab11228fef61703a8',
        '78aaa676e1feee296b6c5670ee34c9bd',
        '6f99e98dbc813044a9692dfd003d36fe',
        '40b4a0b6a2f53e58a51fbc6327d5b287',
        'a51a13f406ee1572696c47fdf0f2dd2d',
        '28719c9931270ad08ae4c5c3b1442e78',
        '10c84f981dbb8ec043e20047e5c35863',
        '2298ceb1b8786831e6f68aab2c9e55ac',
        'ece448ff001e253864a737ff69f3a7aa',
        'dc132777938086d0029e5472b5f9e4ad',
        '760d117fe643abdad707ffcf40ffb0d7',
        '5c5f54fd3605d401fdf0c55f512a98ac',
        'fdb919d5bcfed3774f0525fd0e9ac0d5',
        'aad9b5ee4ce172f7438807b6101a8d38',
        '5c3ec5ca4f2dfb435895bbae1103af46',
        'dbd75d91d16da1bcae3f96cb3f17cb84',
        'c68f272fd4b15f49b88d15c3d00fccee'

    ];
    
    $users = [
        'n9708707'=> [
            'username' => 'n9708707',
            'hash' => $hashes[0],
            'email' => 'kiara.davison@connect.qut.edu.au',
            'firstname' => 'Kiara',
            'lastname' => 'Davison',
            'password' => password_hash("kiara", PASSWORD_DEFAULT),
            'units' => ['cab202', 'cab432', 'cab340', 'cab230'],
            'level' => 'PLF',
            'endorse' => true
        ],
        
        'n9441638'=> [
            'username' => 'n9441638',
            'hash' => $hashes[1],
            'email' => 'george.walkerfitzgerald@connect.qut.edu.au',
            'firstname' => 'George',
            'lastname' => 'Fitzgerald',
            'password' => password_hash("george", PASSWORD_DEFAULT),
            'units' => ['cab202', 'cab201', 'ifb130', 'cab240'],
            'level' => 'Tutor',
            'endorse' => true
        ],
        
        'n9820132'=> [
            'username' => 'n9820132',
            'hash' => $hashes[2],
            'email' => 'b.giles@connect.qut.edu.au',
            'firstname' => 'Ben',
            'lastname' => 'Giles',
            'password' => password_hash("ben", PASSWORD_DEFAULT),
            'units' => ['cab202', 'cab201', 'ifb130', 'cab240'],
            'level' => 'Student'
        ],
        
        'n9726306'=> [
            'username' => 'n9726306',
            'hash' => $hashes[3],
            'email' => 'patrick.breen@connect.qut.edu.au',
            'firstname' => 'Patrick',
            'lastname' => 'Breen',
            'password' => password_hash("patrick", PASSWORD_DEFAULT),
            'units' => ['cab202', 'cab201', 'ifb130', 'cab240'],
            'level' => 'Student'
        ],

        'demo'=> [
            'username' => 'demo',
            'hash' => $hashes[0],
            'email' => 'demo@connect.qut.edu.au',
            'firstname' => 'Demo',
            'lastname' => 'User',
            'password' => password_hash("demo", PASSWORD_DEFAULT),
            'units' => ['cab202', 'ifb104', 'ifb130', 'cab240'],
            'level' => 'Student'
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
           window.location = "login/"
      </script>'; ?>
<?php endif; ?>