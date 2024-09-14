<section class="review-section" id="review-section">
    <div class="grid">
        <div class="all">
            <div class="review-title">
                <div class="top">
                    <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/icons/review_icon.png" alt="">
                    <h2> <?php echo single_translate('product_review_title' , $language); ?> </h2>
                    <p> <?php echo single_translate('product_review_subtitle' , $language); ?> </p>
                </div>
                
                <div class="section_form">
                    <?php
                    if(wc_review_ratings_enabled()){
                    if(is_user_logged_in() && wc_customer_bought_product('', get_current_user_id(), $single_product_data['main_data']->get_id())){
                    ?>
                        <div class = "success-review" style = "display:none;"> <?php echo single_translate('success_review' , $language); ?> </div>
                        <p class="button-submit-review"><?php echo single_translate('product_write_review' , $language); ?> </p>
                        <form id="reviews_form">
                            <div id="reviews_form_alerts" class="ajax_alerts"></div>
                            <div class="field full">
                                <ul class="review_rat">
                                    <li>
                                        <div class="box">
                                            <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/review_icon/review_5.png" alt="">
                                            <p> <?php echo single_translate('grade_A' , $language); ?> </p>
                                        </div>
                                       
                                    </li>
                                    <li>
                                        <div class="box">
                                            <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/review_icon/review_4.png" alt="">
                                            <p> <?php echo single_translate('grade_B' , $language); ?> </p>
                                    </li>
                                    <li>
                                        <div class="box">
                                            <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/review_icon/review_3.png" alt="">
                                            <p> <?php echo single_translate('grade_C' , $language); ?> </p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="box">
                                            <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/review_icon/review_2.png" alt="">
                                            <p> <?php echo single_translate('grade_D' , $language); ?></p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="box">
                                            <img src="<?php echo $theme_settings['theme_url'];?>/assets/img/review_icon/review_1.png" alt="">
                                            <p>  <?php echo single_translate('grade_F' , $language); ?></p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <!-- <div class="field full select_arrow">
                                <label for="rating">Rate This Product</label>
                                <div class="rate">
                                    <input type="radio" id="star5" name="rate" value="5" />
                                    <label onclick="select_star(5);" for="star5" title="ممتاز">5 stars</label>
                                    <input type="radio" id="star4" name="rate" value="4" />
                                    <label onclick="select_star(4);" for="star4" title="جيد">4 stars</label>
                                    <input type="radio" id="star3" name="rate" value="3" />
                                    <label onclick="select_star(3);" for="star3" title="متوسط">3 stars</label>
                                    <input type="radio" id="star2" name="rate" value="2" />
                                    <label onclick="select_star(2);" for="star2" title="ليس سئ">2 stars</label>
                                    <input type="radio" id="star1" name="rate" value="1" />
                                    <label onclick="select_star(1);" for="star1" title="سئ جدا">1 star</label>
                                </div>
                                <select name="rating" id="rating" style="display:none">
                                    <option value="">Rate</option>
                                    <option value="5">Perfect</option>
                                    <option value="4">Good</option>
                                    <option value="3">Average</option>
                                    <option value="2">Not that bad</option>
                                    <option value="1">Very poor</option>
                                </select>
                            </div> -->
                            <div class="field half">
                                <label> <?php echo single_translate('name' , $language); ?> </label>
                                <input type="text" name="name">
                            </div>
                            <div class="field half">
                                <label> <?php echo single_translate('email' , $language); ?></label>
                                <input type="email" name="email">
                            </div>
                            
                            <div class="field full">
                                <label for="">  <?php echo single_translate('leave_review' , $language); ?></label>
                                <textarea name="comment" rows="4"></textarea>
                            </div>
                            <input type="hidden" name="product_id" value="<?php echo $single_product_data['main_data']->get_id();?>">
                            <button class="btn btn-primary">  <?php echo single_translate('add_review' , $language); ?></button>
                        </form>
                        <?php }else{ ?>
                        <div class="alert alert-danger">
                            <p> 
                            <?php echo single_translate('not_allowed_review' , $language); ?>
                            </p>
                            <!-- Only customers who have purchased this product and who are logged in can leave a review. -->
                        </div>
                        <?php } } ?>
                </div>
                <div class="list-of-reviews">
                        <?php
                        $all_comments   = get_comments(array('post_id' => $single_product_data['main_data']->get_id(), 'status' => '1'));
                        if(!empty($all_comments)){
                            foreach($all_comments as $all_comment){
                            // var_dump($all_comment);
                            // $current_time = strtotime(current_time('Y-m-d')); // or your date as well
                            // $comment_date = strtotime($all_comment->comment_date);
                            // $datediff     = $current_time - $comment_date;
                            // $days_no      = round($datediff / (60 * 60 * 24));
                            // if($days_no < 0){
                            //   $days_no = 0;
                            // }
                        ?>
                        <div class="single-review">
                            <div class="top">
                                <div class="pic">
                                    <img class="reviews-img-avatar" src="<?php echo get_avatar_url($all_comment->comment_author_email);?>" alt="">
                                </div>
                                <div class="review-text">
                                    <div class="name">
                                        <p><?php echo $all_comment->comment_author;?></p>
                                        <?php mitch_get_reviews_stars(get_comment_meta($all_comment->comment_ID, 'rating', true));?>
                                    </div>
                                    <span class="time">
                                    <?php echo date('Y-m-d', strtotime($all_comment->comment_date));?>
                                    <!-- منذ <?php //echo $days_no;?> أيام -->
                                    </span>
                                </div>
                            </div>
                            <div class="bottom">
                            <p><?php echo $all_comment->comment_content;?></p>
                            </div>
                        </div>
                        <?php } } ?>
                        <!-- <div class="flex-button">
                        <a class="showButton">عرض اكثر<i class="fas fa-chevron-down"></i></a>
                        </div> -->
                        <!--<div class="showMore">
                            <div class="single-review">
                                <div class="top">
                                    <div class="pic">
                                        <img src="./container-3 image/review-1.png" alt="">
                                    </div>
                                    <div class="review-text">
                                        <div class="name">
                                            <p>Mohamed Mamdouh</p>
                                            <div>
                                                <span class="material-icons"> star_half</span>
                                                <span class="material-icons">star_rate</span>
                                                <span class="material-icons">star_rate</span>
                                                <span class="material-icons">star_rate</span>
                                                <span class="material-icons">star_rate</span>
                                            </div>
                                        </div>
                                        <span class="time">5 days ago</span>
                                    </div>
                                </div>
                                <div class="bottom">
                                    <p>Excellent product quality.</p>
                                </div>
                            </div>
                            <div class="single-review">
                                <div class="top">
                                    <div class="pic">
                                        <img src="./container-3 image/review-2.png" alt="">
                                    </div>
                                    <div class="review-text">
                                        <div class="name">
                                            <p>Fahd Al Qahtany</p>
                                            <div>
                                                <span class="material-icons"> star_half</span>
                                                <span class="material-icons">star_rate</span>
                                                <span class="material-icons">star_rate</span>
                                                <span class="material-icons">star_rate</span>
                                                <span class="material-icons">star_rate</span>
                                            </div>
                                        </div>
                                        <span class="time">قبل 5 أيام</span>
                                    </div>
                                </div>
                                <div class="bottom">
                                    <p>Beautiful fabric, perfect quality and super fast delivery.</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex-button">
                        <a class="lessButton">عرض اقل<i class="fas fa-chevron-up"></i></a>
                        </div>-->
                </div>
            </div>
            <div class="review-box">
                <!-- <h3><span><?php //echo $single_product_data['main_data']->get_name();?></span></h3> -->
                <div class="review-top">
                    <div class="stars-out">
                    <?php
                    $five_rating_comments = get_comments(array(
                    'status'     => '1',
                    'post_id'    => $single_product_data['main_data']->get_id(),
                    'meta_query' => array(
                        array(
                        'key'     =>'rating',
                        'value'   => '5',
                        'compare' => '='
                        )
                    )
                    ));
                    $four_rating_comments = get_comments( array(
                        'status'     => '1',
                        'post_id' => $single_product_data['main_data']->get_id(),
                        'meta_query' => array(
                            array(
                            'key' =>'rating',
                            'value' => '4',
                            'compare' => '='
                            )
                        )
                    ) );
                    $three_rating_comments = get_comments( array(
                        'status'     => '1',
                        'post_id' => $single_product_data['main_data']->get_id(),
                        'meta_query' => array(
                            array(
                            'key' =>'rating',
                            'value' => '3',
                            'compare' => '='
                            )
                        )
                    ) );
                    $two_rating_comments = get_comments( array(
                        'status'     => '1',
                        'post_id' => $single_product_data['main_data']->get_id(),
                        'meta_query' => array(
                            array(
                            'key' =>'rating',
                            'value' => '2',
                            'compare' => '='
                            )
                        )
                    ) );
                    $one_rating_comments = get_comments( array(
                        'status'     => '1',
                        'post_id' => $single_product_data['main_data']->get_id(),
                        'meta_query' => array(
                            array(
                            'key' =>'rating',
                            'value' => '1',
                            'compare' => '='
                            )
                        )
                    ) );
                    $all_comments   = get_comments(array('post_id' => $single_product_data['main_data']->get_id(), 'status' => '1'));
                    $comments_count = count($five_rating_comments) + count($four_rating_comments) + count($three_rating_comments) + count($two_rating_comments) + count($one_rating_comments);
                    $rating_avg     = $single_product_data['main_data']->get_average_rating();
                    $rating_count   = $single_product_data['main_data']->get_rating_count();
                    // var_dump($rating_avg);
                    if($comments_count != 0){
                        $five_rate_number  = count($five_rating_comments) / $comments_count * 100;
                        $four_rate_number  = count($four_rating_comments) / $comments_count * 100;
                        $three_rate_number = count($three_rating_comments) / $comments_count * 100;
                        $two_rate_number   = count($two_rating_comments) / $comments_count * 100;
                        $one_rate_number   = count($one_rating_comments) / $comments_count * 100;
                    }else{
                        $five_rate_number  = 0;
                        $four_rate_number  = 0;
                        $three_rate_number = 0;
                        $two_rate_number   = 0;
                        $one_rate_number   = 0;
                    }
                    $rating_avg_value = mitch_remove_decimal_from_rating($rating_avg);
                    if($rating_avg_value != 0){
                        ?>
                        <p class="bold"><?php echo $rating_avg_value;?> </p>
                        <?php 
                    }
                    ?>
                        <?php
                        // $rating_avg = 4.2;
                        mitch_get_reviews_stars($rating_avg);
                        ?>
                        <span>(<?php echo get_comments_number();?> Review)</span>
                    </div>
                    <div class="all-starts">
                        <ul>
                            <li>
                                <div class="perc-rating">
                                    <span class="text">5 Stars</span>
                                    <div class="proccess-bar"><span style="width: <?php echo round($five_rate_number);?>%;"></span></div>
                                    <span class="text"><?php echo round($five_rate_number);?>%</span>
                                </div>
                            </li>
                            <li>
                                <div class="perc-rating">
                                    <span class="text">4 Stars</span>
                                    <div class="proccess-bar"><span style="width: <?php echo round($four_rate_number);?>%;"></span></div>
                                    <span class="text"><?php echo round($four_rate_number);?>%</span>
                                </div>
                            </li>
                            <li>
                                <div class="perc-rating">
                                    <span class="text">3 Stars</span>
                                    <div class="proccess-bar"><span style="width: <?php echo round($three_rate_number);?>%;"></span></div>
                                    <span class="text"><?php echo round($three_rate_number);?>%</span>
                                </div>
                            </li>
                            <li>
                                <div class="perc-rating">
                                    <span class="text">2 Stars</span>
                                    <div class="proccess-bar"><span style="width: <?php echo round($two_rate_number);?>%;"></span></div>
                                    <span class="text"><?php echo round($two_rate_number);?>%</span>
                                </div>
                            </li>
                            <li>
                                <div class="perc-rating">
                                    <span class="text">1 Stars</span>
                                    <div class="proccess-bar"><span style="width: <?php echo round($one_rate_number);?>%;"></span></div>
                                    <span class="text"><?php echo round($one_rate_number);?>%</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                  
                </div>          
            </div>
        </div>
    </div>
</section>
