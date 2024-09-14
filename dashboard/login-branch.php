<?php  require_once '../wp-content/themes/mitchdesigns/header.php'; ?> 

<div class="section_dashboard_branch login">
    <div class="grid">
          <div class="content">
            <div class="head">
              <img src="../wp-content/themes/mitchdesigns/assets/img/web_logo.png" alt="">
              <h2><?php echo Myaccount_translation('Sign_login_keyword' , $language) ?></h2>
            </div>
            <div class="message error_msg"></div>
            <form id = "login-branch"action="" method="post">
              <div class="login-form">
                  <div class="field">
                      <label for=""><?php echo Myaccount_translation('account_email' , $language) ?><span>*</span></label>
                      <input type="text" placeholder="Enter Username" name="uname" required>
                  </div>
                  <div class="field">
                      <label for=""><?php echo Myaccount_translation('account__password' , $language) ?><span>*</span></label>
                      <input type="password" placeholder="Enter Password" name="psw" required>
                  </div>
                  <button class="btn" type="submit" value=""> <?php echo Myaccount_translation('Sign_login_keyword' , $language) ?></button>
              </div>
            </form>
          </div>
    </div>
  <?php require_once '../wp-content/themes/mitchdesigns/footer.php';?>
  <script src="dashboard.js"></script>
</div>
