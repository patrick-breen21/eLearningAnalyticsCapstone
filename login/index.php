<html class="gr__cms-edit_qut_edu_au">
<head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <base href="//smallprojects.info/capstone/">
    <title>Login - QUT eLearning</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cms-edit.qut.edu.au/__lib/web/images/icons/favicon.ico" rel="shortcut icon">
    <link rel="stylesheet" type="text/css" href="_css/login_styles.css">
</head>

  <body class="login-design" data-gr-c-s-loaded="true" cz-shortcut-listen="true">

            <form action="index.php" id="login_form_login_prompt" method="post" class="<?php if ($error) echo 'error'?>">
          
        <div class="login-logo"><img src="_images/qut-login.png" alt="QUT Logo"></div>

        <p class="login-message">You need to login before you can access this page.</p>
        <p class="login-message error"><!--?= $error ?--></p>
        <div id="message" class="message" style="display: none;">
                  </div>

        <div class="credentials-section">
          <div class="field-wrapper">
            <label for="SQ_LOGIN_USERNAME">Username</label> 
            
            <input type="text" name="username" value="" size="10" onfocus="this.select();" class="data" required="required" autofocus="autofocus" id="SQ_LOGIN_USERNAME">
          </div>
          <div class="field-wrapper">
            <label for="SQ_LOGIN_PASSWORD">Password</label> 
            <input type="password" name="password" value="" size="10" onfocus="this.select();" class="data" required="required" autocomplete="off" id="SQ_LOGIN_PASSWORD">
          </div>
        </div>

        <div class="commit-section">
          <input type="submit" name="log_in_out_button" value="Login" class="data" id="log_in_out_button">
        </div>

        
          </form>
</body></html>