<div class="section_repeater">
    <div class="content">
    <?php
        if(!empty($page_content['section_repeater'])){
        foreach($page_content['section_repeater'] as $slide){
        ?>
        <a class="single_content" href="<?php echo $slide['url'];?>">
            <img src="<?php echo $slide['image'];?>" alt="">
            <div class="text">
                    <h3>
                    <?php echo $slide['title'];?>
                    </h3>
                    <p><?php echo $slide['description'];?></p>
            </div>
        </a>
        <?php 
        }
    } 
    ?>
    </div>
</div>