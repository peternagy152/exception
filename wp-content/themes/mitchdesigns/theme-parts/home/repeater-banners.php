<div class="section_repeater grid">
    <?php $counter_col= 1; foreach($home_content['all_banners'] as $one_banner){ ?>
        <div class="single_box <?php echo($counter_col%2==0)?'reverse':'';?>">
            <div class="text">
                <h3> <?php echo $one_banner['banner'] ?></h3>
                <?php echo $one_banner['banner_subtitle'] ?>
                <a  class="read_more" href=" <?php echo $one_banner['button']['url'] ?>"> <?php echo $one_banner['button']['title']  ?></a>
            </div>
            <div class="image">
                <a href="<?php echo $one_banner['button']['url'] ?>">
                    <img src="<?php echo $one_banner['banner_image'] ?>" alt="">
                </a>
            </div>
        </div>
    <?php  $counter_col++; }  ?>
</div>