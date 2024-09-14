<div class="hero_slider">
    <?php
    if($home_content['hero_section']['video_or_images'] == false ){  // Means Image Slider 

      foreach($home_content['hero_section']['images'] as $one_image ) {
        // Image URL 
        ?>
        <a class="single_hero" href="<?php echo $one_image['banner_link'] ; ?>">
            <img src="<?php  echo $one_image['banner_mobile'] ;  ?>" alt="">
        </a>
        <?php 
      }
    }else { //Means Video

      echo $one_image['video'] ;
      
    }



    ?>
</div>

