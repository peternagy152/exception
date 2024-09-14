<div class="section_service">
    <div class="grid">
            <h3 class="title_service"> <?php echo $home_content['service_section_title'] ;  ?></h3>
            <div class="all_service">
                <?php foreach($home_content['service_section'] as $one_service){ ?>
                    <div class="single_service">
                        <img src="<?php echo $one_service['icon'] ?>" alt="">
                        <h5> <?php echo $one_service['icon_title'] ?></h5>
                        <?php echo $one_service['icon_subtitle'] ?>
                    </div>
                <?php } ?>
            </div>
    </div>
</div>


