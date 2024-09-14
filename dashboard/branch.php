<?php  require_once '../wp-content/themes/mitchdesigns/header.php'; ?> 

<?php session_start();  ?>

  <script>
        setTimeout(function () {
            location.reload();
        }, 300000); // 300,000 milliseconds = 5 minutes
    </script>

<div class="section_dashboard_branch">

          <?php  
          //Check if User Logged In 
          if(isset($_SESSION['admin_dashboard'])){

            // if Not Master -> Access only Specific Branch 
            if(str_contains($_SESSION['admin_dashboard'] , 'notmaster')){

              require_once 'components/specific-branch.php';

              // if Master -> Access Both master branch and specific branch
            }else if(str_contains($_SESSION['admin_dashboard'] , 'master')){


              $session_info = explode('-', $_SESSION['admin_dashboard']);  
              // if Master -> [if branch_id = 0 -> access master branch else -> Access the specific ]
              if($session_info[2] == 0){
                require_once 'components/master-branch.php';
              }else{
                require_once 'components/specific-branch.php';
              }
              

            }
          }else{
            //Not Logged In So Redirect to Login Page 
            global $theme_settings;
            header('Location:' . $theme_settings['site_url'] . '/dashboard/login-branch.php');
            exit();

          }

          ?>

          <?php require_once '../wp-content/themes/mitchdesigns/footer.php';?>
          <script>
          $('html, body').animate({ scrollTop: 0 }, 'fast');
        </script>

</div>

<script src="dashboard.js"></script>
