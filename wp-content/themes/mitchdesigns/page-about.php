<?php
require_once 'header.php';
global $language;

  if( $language == 'en') {
    $page_content = get_field('page_about_en');
  } else {
    $page_content = get_field('page_about');
    
  }
// var_dump($page_content);
?>


<div id="page" class="site">
  <?php require_once 'theme-parts/main-menu.php';?>
  <!--start page-->
    <div class="site-content">
          <div class="section_page page_about">
              <div class="section_hero">
                <?php  if($page_content['video_or_images'] == false ){ ?>
                    <img src="<?php echo $page_content['image_hero'];?>" alt="">
                <?php   }else { //Means Video ?>
                  <div class="sec_video fade-in ">
                    <video  autoplay playsinline  muted loop class="player__video viewer">
                        <source src="<?php echo $page_content['video_hero'];?>" type="" />
                    </video>
                  </div>
                    <!-- <div class="video_hero" >
                        <iframe src="<?php  //echo $page_content['video_hero'] ; ?>&autoplay=1&loop=1&title=0&byline=0&portrait=0&autopause=false&background=1" width="2000" height="1125"  frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div> -->
                <?php } ?>

                  <div class="section_title">
                      <h1><?php echo $page_content['title_hero'];?></h1>
                      <p><?php echo $page_content['subtitle_hero'];?></p>
                  </div>
              </div>
              <div class="grid">
                <div class="section_slide">
                    <?php if(!empty($page_content['subhero_repeater'])){ foreach($page_content['subhero_repeater'] as $other_section){ ?>
                      <div class="single_slide">
                          <div class="img">
                              <img src="<?php echo $other_section['icon'];?>" alt="">
                          </div>
                          <div class="text">
                              <h3><?php echo $other_section['number'];?></h3>
                              <p class="content"><?php echo $other_section['text'];?></p>
                          </div>
                      </div>
                    <?php } } ?>
                </div>
                <div class="section_content">
                      <div class="sec_img first">
                        <div class="image">
                          <img src="<?php echo $page_content['image_one'];?>" alt="">
                        </div>
                        <div class="text">
                            <h4><?php echo $page_content['title_one'];?></h4>
                            <p><?php echo $page_content['description_one'];?></p>
                        </div>
                      </div>
                      <div class="sec_text">
                          <div class="text">
                              <span><?php echo ($language == 'en')? 'Mission':'مهمتنا' ?></span>
                              <?php echo $page_content['text'];?>
                          </div>
                      </div>

                      <?php if(!empty($page_content['content_image_repeater']))  { $count=1; foreach($page_content['content_image_repeater'] as $repeater_img_section){ ?>
                          <div class="sec_img  <?php echo($count%2==0)?'row_reverse':'';?>">
                            <div class="text">
                                <h4><?php echo $repeater_img_section['title_second'];?></h4>
                                <p><?php echo $repeater_img_section['description_second'];?></p>
                            </div>
                            <?php  if($repeater_img_section['image_has_slider'] == false ){ ?>
                                <div class="image">
                                  <img src="<?php echo $repeater_img_section['image_second'];?>" alt="">
                                </div>
                            <?php   }else { //Means Video ?>
                                <div class="image slick_about">
                                  <?php if(!empty($repeater_img_section['slider_image'])){ foreach($repeater_img_section['slider_image'] as $slider_image){ ?>
                                    <img src="<?php echo $slider_image['image_repeat'];?>" alt="">
                                  <?php } } ?>
                                </div>
                            <?php } ?>
                          </div>
                      <?php $count++;  } } ?>

                </div>
              </div>
              <div class="section_values">
                  <div class="grid">
                    <h3 class="sec_title"><?php echo $page_content['title_values'];?></h3>
                    <div class="all_values">
                        <?php if(!empty($page_content['all_values'])){ foreach($page_content['all_values'] as $values_section){ ?>
                          <div class="single_values">
                            <div class="box_value">
                                <div class="img">
                                      <img src="<?php echo $values_section['image'];?>" alt="">
                                  </div>
                                  <div class="text">
                                      <h3><?php echo $values_section['title'];?></h3>
                                      <p class="content"><?php echo $values_section['description'];?></p>
                                  </div>
                            </div>
                             
                          </div>
                        <?php } } ?>
                    </div>
                    
                  </div>
              </div>
              <div class="section_other_page">
                <div class="all_page">
                  <?php if(!empty($page_content['page_repeater'])){ foreach($page_content['page_repeater'] as $other_page){ ?>
                      <div class="single_section_page">
                          <img src="<?php echo $other_page['image'];?>" alt="">
                          <div class="text">
                            <h4><?php echo $other_page['title'];?></h4>
                            <p><?php echo $other_page['description'];?></p>
                            <a href="<?php echo $other_page['link']['url'];?>"><?php echo $other_page['link']['title'];?></a>
                          </div>
                      </div>
                  <?php } } ?>
                </div>
              </div>
          </div>
    </div>
</div>
  <!--end page-->
</div>
<?php require_once 'footer.php';?>
