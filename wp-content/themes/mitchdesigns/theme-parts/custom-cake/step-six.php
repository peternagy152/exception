        <?php global $language; ?>
        <h3 class="section_title"> <?php if($language == 'en'){echo 'Write on the cake' ; }else{echo 'اكتب علي الكيكة ' ;} ?></h3>
        <div class="options write_text" id="writing_option">                
                <div class="s_option  ">
                        <div class="option">
                                <input  value="without-writing" type="radio" name="writing_options" checked="">
                                <label for="writing_options"> <?php if($language == 'en'){echo 'without writing' ; }else{echo 'بدون كتابة' ;} ?></label>
                        </div>
                </div>
                <div class="s_option open_write">
                        <div class="option">
                                <input  value="with-writing" type="radio" name="writing_options" >
                                <label for="writing_options"> <?php if($language == 'en'){echo 'with writing' ; }else{echo 'مع كتابة' ;} ?></label>
                        </div>
                </div>
                <div class="all_notes">
                        <div class="single_note">
                                <div class="sec_top">
                                        <h6> <?php if($language == 'en'){echo 'Add words on the cake' ; }else{echo 'أضف كلام على الكيكة' ;} ?>  </h6>
                                        <p><?php if($language == 'en'){echo 'Free' ; }else{echo 'مجاناً' ;} ?></p>
                                </div>
                                <div class="textarea">
                                        <textarea id="cake_text" name=""></textarea>
                                </div>
                        </div>
                        <div class="single_note more_text">
                                <div class="sec_top ">
                                        <h6> 
                                                <?php //if($language == 'en'){echo 'Add words on the cake' ; }else{echo 'كتابة على القاعدة' ;} ?>  
                                                <input type="checkbox" id="addtext" name="addtext" data-price = "" value="">
                                                <label for="addtext">  <?php if($language == 'en'){echo 'Add words on the cake' ; }else{echo 'كتابة على القاعدة' ;} ?>  </label>
                                        </h6>

                                        <p id="write_base"><?php if($language == 'en'){echo '30.00 EGP' ; }else{echo '30.00 ج م' ;} ?></p>
                                </div>
                                <div class="textarea">
                                        <textarea id="cake_text_base" class="test" name="" ></textarea>
                                </div>
                                
                               
                        </div>
                </div>
               

        </div>
