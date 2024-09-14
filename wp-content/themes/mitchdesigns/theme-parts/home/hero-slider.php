<div class="hero_slider">
    <?php 
            if($home_content['hero_section']['video_or_images'] == false ){  // Means Image Slider 
           foreach($home_content['hero_section']['images'] as $one_image ) {  // Image URL 
      ?>

          <a class="single_hero" href="<?php echo $one_image['banner_link'] ; ?>">
              <img src="<?php  echo $one_image['banner'] ;  ?>" alt="">
          </a>
      <?php  } }else { //Means Video ?>

          <div class="video_hero" >
              <iframe src="=<?php  echo $one_image['video'] ; ?>"  frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
          </div>
      
      <?php } ?>
</div>

