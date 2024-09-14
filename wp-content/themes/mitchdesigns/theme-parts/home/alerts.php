<?php 
if(isset($_GET['add_subscriber'])){
    if($_GET['add_subscriber'] == 'success'){
        ?>
        <div class="alert alert-success">Subscription done successfully.</div>
        <?php
    }elseif($_GET['add_subscriber'] == 'error'){
        ?>
        <div class="alert alert-danger">Sorry, There is an issue during subscription, please try again!</div>
        <?php
    }
}