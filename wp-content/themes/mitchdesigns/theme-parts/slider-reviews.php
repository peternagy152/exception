<section class="slider-reviews">
    <div class="grid">
        <div class="section_title">
            <h2 class="products-reviews">Reviews</h2>
            <div class="reviews-home">
            <div class="starssss"> <span class="material-icons">star</span>
                        <span class="material-icons">star</span>
                        <span class="material-icons">star</span>
                        <span class="material-icons">star</span>
                        <span class="material-icons">star</span>
                    </div>
                <h2>Customers’ Reviews</h2>
                <p>Our valuable customers’ experience with exception</p>
            </div>

        </div>
        <?php if( have_rows('customer_reviews', 'options') ): ?>
        <div class="reviews">
            <?php 
                    while( have_rows('customer_reviews', 'options') ) : the_row();
                ?>
            <div class="single-review">
                <div class="top">
                    <p class="name"><?php echo get_sub_field('name');?></p>
                    <div class="starssss"> <span class="material-icons">star_outline</span>
                        <span class="material-icons">star_outline</span>
                        <span class="material-icons">star_outline</span>
                        <span class="material-icons">star_outline</span>
                        <span class="material-icons">star_outline</span>
                    </div>
                </div>
                <div class="middle">
                    <p><?php echo get_sub_field('comment');?></p>
                </div>
                <div class="bottom">
                    <p class="time"><?php echo get_sub_field('time');?></p>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
        <?php endif; ?>
    </div>
</section>