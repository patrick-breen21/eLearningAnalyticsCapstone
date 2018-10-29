<div class="login-page <?php if ($error) echo 'error'?>">
  <div class="form">
    <!--form class="register-form">
      <input type="text" placeholder="name"/>
      <input type="password" placeholder="password"/>
      <input type="text" placeholder="email address"/>
      <button>create</button>
      <p class="message">Already registered? <a href="#">Sign In</a></p>
    </form-->
    <form class="login-form" method='post' action=''>
      <input type="text" name='username' placeholder="username"/>
      <input type="password" name='password' placeholder="password"/>
      <button>login</button>
      <p class="message error"><?= $error ?></p>
      <!--p class="message">Not registered? <a href="#">Create an account</a></p-->
    </form>
  </div>
</div>