<?php global $language; ?>
<div class="options flavor_option">
    <div class="s_option">
        <h3 class="section_title"> <?php if($language == 'en'){echo 'Flavor' ; }else{echo ' النكهة' ;} ?></h3>
        <?php $flavors = get_all_flavors(); ?>
        <select class="s_select" name="area" id="flavor_option">
            <option value="false" disabled selected > <?php if($language == 'en'){echo 'choose flavour' ; }else{echo ' اختر النكهة' ;} ?>   </option>
            <?php $flavor_name = "flavor_" . $language ; ?>
            <?php foreach($flavors as $one_flavor){ ?>
                <option value="<?php echo $one_flavor->flavor_slug?>"> <?php echo $one_flavor->$flavor_name ?>  </option>
            <?php  } ?>
        </select>

        <div class="select-dropdown" id="flavor_option" style="display:none">
            <div class="section_selected">
                <!-- <h3><?php //if($language == 'en'){echo 'choose flavour' ; }else{echo ' اختر النكهة' ;} ?> </h3> -->
               <div class="selected">
                    <img src="https://cloudhosta.com:63/wp-content/uploads/2023/09/choclate.webp" alt="">    
                    <p class="value_name"> شوكولاتة </p>        
               </div>
            </div>
            <div class="all_select">
                <div class="s_select" value="<?php echo $one_flavor->flavor_slug?>">
                    <img src="https://cloudhosta.com:63/wp-content/uploads/2023/09/choclate.webp" alt="">       
                    <p class="value_name"> شوكولاتة 
                        <span>شوكولاتة غنية و كريمية بقوام كثيف</span>
                    </p>        
                </div>
                <div class="s_select" value="<?php echo $one_flavor->flavor_slug?>">
                    <img src="https://cloudhosta.com:63/wp-content/uploads/2023/09/choclate.webp" alt="">       
                    <p class="value_name"> كريمة 
                        <span>شوكولاتة غنية و كريمية بقوام كثيف</span>
                    </p>        
                </div>
            </div>
            
        </div>
    </div>
</div>