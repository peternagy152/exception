<?php 

// Points Admin Dashboard 

// Add a new menu item to the WordPress admin dashboard
function Admin_Points_Controller() {
    add_menu_page(
        'Manage User Points ', // Page title
        'Manage User Points', // Menu title
        'manage_options', // Capability required to access the page
        'admin-points-controller', // Page slug
        'Admin_points_controller_callback' // Callback function that displays the page
    );
}

// Register the menu item
add_action( 'admin_menu', 'Admin_Points_Controller' );

// Callback function that displays the page
function Admin_points_controller_callback() { 
    $points_settings  = get_field('points_settings' , "options");
    ?>
    <div>
        <h1> MitchDesigns Points System </h1>
    </div>
    <?php 

    // List All Users record 
    if(isset($_GET['user_id']) && $_GET['user_id'] != 0){

        if(get_userdata( $_GET['user_id'] ) == false || MD_get_user_points_info($_GET['user_id']) == false   ){
            ?>
            <div class = "user-not-found">
                <h2> User Not Found !</h2>

            </div>
        <?php 
        }else {
           // Get User Info 
           global $wpdb;
           $user_points_info = MD_get_user_points_info($_GET['user_id']);
           $points_settings  = get_field('points_settings' , "options");
           $user_points_history = $wpdb->get_results("SELECT * FROM wp_mitch_points_history WHERE user_id = {$_GET['user_id']} " );
   
        ?>

        <?php 
            // Apply Points Modification 
            if( isset( $_POST['user_points_add'])){
                
                //Globals 
                //global $wpdb ;
                $Points_table = 'wp_mitch_points_system';
                $History_table = 'wp_mitch_points_history';
                // Handling Data 
                if(empty($_POST['msg'])){
                    $msg = "Points Add By Admin";
                }else {
                    $msg = $_POST['msg'];
                }

                // Insert in User History 
                
                $wpdb->insert(
                    $History_table, 
                    array(
                        'user_id' => $_GET['user_id'] ,
                        'type' => 'Increase',
                        'points_number' => $_POST['user_points_add'] ,
                        'msg' => $msg ,
                        'points_before' =>  $user_points_info->current_points , 
                        'points_after' =>  $user_points_info->current_points + $_POST['user_points_add'],
                    )
                );

                // Update User Point 

                $wpdb->update( $Points_table ,
                array( 
                'current_points' => $user_points_info->current_points + $_POST['user_points_add'],
                'current_cash' =>  $user_points_info->current_cash + $_POST['user_points_add'] / $points_settings['groups'][$user_points_info -> level_number]['points_to_currency'],
                'total_points' => $user_points_info->total_points + $_POST['user_points_add'],
                ),
                
                    array( 'user_id' =>  $_GET['user_id'] )
                    
                    ) ;

                    header("Refresh:0");

            }

            // Remove Points From User 
            if( isset( $_POST['user_points_remove'])){
                
                //Globals 
                //global $wpdb ;
                $Points_table = 'wp_mitch_points_system';
                $History_table = 'wp_mitch_points_history';
                // Handling Data 
                if(empty($_POST['msg'])){
                    $msg = "Points Removed By Admin";
                }else {
                    $msg = $_POST['msg'];
                }

                // Insert in User History 
                
                $wpdb->insert(
                    $History_table, 
                    array(
                        'user_id' => $_GET['user_id'] ,
                        'type' => 'Decrease',
                        'points_number' => $_POST['user_points_remove'] ,
                        'msg' => $msg ,
                        'points_before' =>  $user_points_info->current_points , 
                        'points_after' =>  $user_points_info->current_points - $_POST['user_points_remove'],
                    )
                );

                // Update User Point 

                // User New Current Points 
                if($user_points_info->current_points <= $_POST['user_points_remove'] ){
                    $wpdb->update( $Points_table ,
                    array( 
                    'current_points' => 0,
                    'current_cash' => 0,
                    'total_points' => $user_points_info->total_points - $_POST['user_points_remove'],
                    ),
                    
                        array( 'user_id' =>  $_GET['user_id'] )
                        
                        ) ;
    
                }else {
                    $wpdb->update( $Points_table ,
                    array( 
                    'current_points' => $user_points_info->current_points - $_POST['user_points_remove'],
                    'current_cash' =>  $user_points_info->current_cash - $_POST['user_points_remove'] / $points_settings['groups'][$user_points_info -> level_number]['points_to_currency'],
                    'total_points' => $user_points_info->total_points + $_POST['user_points_remove'],
                    ),
                    
                        array( 'user_id' =>  $_GET['user_id'] )
                        
                        ) ;
    
                }
               
                    header("Refresh:0");

            }

        ?>
        <div>
            <h2> User Info </h2>
        </div>
        <?php 
     
        echo '<table class = "custom-table">';
        echo '<tr>
        <th style="padding: 0 20px;" >User ID</th>
        <th style="padding: 0 20px;" >Name </th>
        <th style="padding: 0 20px;" >User Email </th>
        <th style="padding: 0 20px;" >Current Points </th>
        <th style="padding: 0 20px;" >Current Cash </th>
        <th style="padding: 0 20px;" >Sold </th>
        </tr>';
        echo '<tr>';
        echo '<td  style="padding: 0 20px;">' . $_GET['user_id']. '</td>';
        echo '<td  style="padding: 0 20px;">' . get_user_meta($_GET['user_id'] , 'first_name', true) . ' ' . get_user_meta($_GET['user_id'] , 'last_name', true) . '</td>';
        $user_info = get_userdata($_GET['user_id']);
        echo '<td>' . $user_info->user_email . '</td>';
        echo '<td style="padding: 0 20px;" >' . $user_points_info->current_points . ' Point </td>';
        echo '<td style="padding: 0 20px;" >' . number_format( $user_points_info->current_cash  ). ' EGP </td>';
        echo '<td style="padding: 0 20px;" >' . number_format( $user_points_info->total_money ). ' EGP </td>';
        echo '</tr>';
        echo '</table>';
        ?>
        <div class="class-info">
            <h2> User Class Info </h2>
            <table class = "custom-table">
            <tr>
                <th> Class Name  </th>
                <th>Start From [EGP]</th> 
                <th> 1 EGP To X Points [Gain]</th>
                <th> X Points to EGP [Redeem]</th>
            </tr>
            <tr>
                <td style="padding: 0 60px;" > <?php echo ucfirst($points_settings['groups'][$user_points_info->level_number ]['level_name'] );  ?>  </td>
                <td style="padding: 0 60px;" > <?php echo $points_settings['groups'][$user_points_info->level_number ]['start_from'] ?>  EGP  </td>
                <td style="padding: 0 60px;" > <?php echo $points_settings['groups'][$user_points_info->level_number ]['currency_to_points'] ?> Points  </td>
                <td style="padding: 0 60px;" > <?php echo $points_settings['groups'][$user_points_info->level_number ]['points_to_currency'] ?> EGP  </td>
            </tr>
            </table>

        </div>

        <button id= "add-button" class = "add-points-button"> Add Points To User </button>
        <button id = "remove-button"> Remove Points From User </button>

        <div class = "add-points" style = "display:none;">
            <h2> Add Points To <?php echo get_user_meta($_GET['user_id'] , 'first_name', true)  ?>  </h2>
            <h2> Current User Points : <?php echo $user_points_info->current_points   ?>  </h2>
            <?php
                //Display the form
                echo '<form method="post">';
                echo '<label for="user_points"> Points :</label>';
                echo '<input type="number" name="user_points_add">';
                echo '<label for="user_message"> Message :</label>';
                echo '<input type="txt" name="msg">';
                echo '<input type="submit" value="Add">';
                echo '</form>';
            ?>
        </div>

        <div class = "remove-points" style = "display:none;">
            <h2> Remove Points From <?php echo get_user_meta($_GET['user_id'] , 'first_name', true)  ?>  </h2>
            <h2> Current User Points : <?php echo $user_points_info->current_points   ?>  </h2>
            <?php
                //Display the form
                echo '<form method="post">';
                echo '<label for="user_points"> Points :</label>';
                echo '<input type="number" name="user_points_remove">';
                echo '<label for="user_message"> Message :</label>';
                echo '<input type="txt" name="msg">';
                echo '<input type="submit" value="Remove">';
                echo '</form>';
            ?>
        </div>
        
        <div>
            <h2> User History Details </h2>
        </div>
        <?php 
        global $wpdb ;
        $user_points_history = array_reverse($user_points_history);
        ?>
        <table class = "custom-table">
            <tr>
                <th> Points  </th>
                <th>Date</th> 
                <th> Reason</th>
                <th> Total Points</th>
            </tr>
            <?php foreach($user_points_history as $one_history){ ?>
                <tr class="<?php if($one_history -> type == 'Increase'){echo "green";}else{echo "red" ;} ?>">
                    <td style="padding: 0 20px;" class="points-details"> <?php echo $one_history -> points_number ?> Points</td>
                    <td style="padding: 0 20px;" > <?php echo  $one_history-> date  ?></td>
                    <td style="padding: 0 20px;" > <?php echo $one_history -> msg ?> </td>
                
                    <td style="padding: 0 20px;" > <?php echo $one_history -> points_after ?> Points</td>
                </tr>
                <?php }  ?>     
        </table>
        
     
            
        <?php
     }
    }else {
        global $wpdb;

        $results = $wpdb->get_results("SELECT * FROM wp_mitch_points_system");
        $actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    
        if (!empty($results)) {
            echo '<table class = "custom-table">';
            echo '<tr>
            <th style="padding: 0 20px;" >User ID</th>
            <th style="padding: 0 20px;" > Name</th>
            <th style="padding: 0 20px;" >User Email </th>
            <th style="padding: 0 20px;" >Current Points </th>
            <th style="padding: 0 20px;" >Current Cash </th>
            <th style="padding: 0 20px;" >Sold </th>
            <th style="padding: 0 20px;" >User Class </th>
            <th style="padding: 0 20px;" > </th>
            </tr>';
    
            foreach ($results as $result) {
                echo '<tr>';
                echo '<td  style="padding: 0 20px;">' . $result->user_id . '</td>';
                echo '<td  style="padding: 0 20px;">' . get_user_meta($result->user_id , 'first_name', true) . ' ' . get_user_meta($result->user_id , 'last_name', true) . '</td>';

                $user_info = get_userdata($result->user_id);
                if(!empty($user_info->user_email)){
                    echo '<td>' . $user_info->user_email . '</td>';
                }else{
                    echo '<td> </td>';
                }
                echo '<td style="padding: 0 20px;" >' . $result->current_points . ' </td>';
                echo '<td style="padding: 0 20px;" >' . number_format($result->current_cash) . ' EGP </td>';
                echo '<td style="padding: 0 20px;" >' . number_format($result->total_money) . ' EGP </td>';
                echo '<td style="padding: 0 20px;" >' . ucfirst($result->user_type) . '</td>';
                ?>
                <td style="padding: 0 20px;" ><a href="<?php echo $actual_link . '&user_id=' . $result->user_id ?>"> View User History </a></td>
                <?php 
                echo '</tr>';
            }
            echo '</table>';
        } else {
            echo '<p>No records found.</p>';
        }
    
    }
    


// Add Or Remove Points Script 
global $theme_settings ;
?>
<script src="<?php echo $theme_settings['theme_url'];?>/assets/js/jquery-3.2.1.min.js"></script>
<script>
    //alert("hi");
    $("#add-button").on("click", function () {
        $('.add-points').show();
        $('.remove-points').hide();
    });

    $("#remove-button").on("click", function () {
        $('.add-points').hide();
        $('.remove-points').show();
    });

</script>
   <?php
}

add_action( 'admin_enqueue_scripts', 'load_admin_style' );
function load_admin_style() {
    wp_register_style( 'admin_css', get_template_directory_uri() . '/admin-wallet.css', false, '1.0.0' );
    //OR
    wp_enqueue_style( 'admin_css', get_template_directory_uri() . '/admin-wallet.css', false, '1.0.0' );
}