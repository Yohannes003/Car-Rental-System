<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login form</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <section class="forms-section">
        <h1 class="section-title">Embark mobility sign-up</h1>
        <div class="forms">
          <div class="form-wrapper is-active">
            <button type="button" class="switcher switcher-login">
              Login
              <span class="underline"></span>
            </button>
            <form class="form form-login" method="POST">
              <fieldset>
                <legend>Please, enter your email and password for login.</legend>
                <div class="input-block">
                  <label for="login-email">E-mail</label>
                  <input id="login-email" type="email" required name="email">
                </div>
                <div class="input-block">
                  <label for="login-password">Password</label>
                  <input id="login-password" type="password" required name="password">
                </div>
              </fieldset>
              <button type="submit" class="btn-login" name="login">Login</button>
              <?php include("login.php"); ?>
            </form>
          </div>
          <div class="form-wrapper">
            <button type="button" class="switcher switcher-signup">
              Sign Up
              <span class="underline"></span>
            </button>
            <form class="form form-signup" method="POST">
              <fieldset>
                <legend>Please, enter your email, password and password confirmation for sign up.</legend>
                <div class="input-block">
                  <label for="signup-username">first name</label>
                  <input id="signup-email" type="text" required name="first_name">
                </div>
                <div class="input-block">
                    <label for="signup-username">last name</label>
                    <input id="signup-email" type="text" required name="last_name">
                  </div>
                <div class="input-block">
                  <label for="signup-email">E-mail</label>
                  <input id="signup-email" type="email" required name="email">
                </div>
                <div class="input-block">
                  <label for="signup-password">Password</label>
                  <input id="signup-password" type="password" required name="password">
                </div>
              </fieldset>
              <button type="submit" class="btn-signup" name="sign_up">Sign Up</button>
              <?php include("insert_user.php"); ?>
            </form>
          </div>
        </div>
      </section>
    <script src="login.js"></script>
</body>
</html>
