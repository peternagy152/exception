<?php
$global_size_guide  = get_field('size_guide_info', 'options');
// echo '<pre>';
// var_dump($global_size_guide);
// echo '</pre>';
?>
<div class="section_size">
  <div class="section_img">
    <img id="single_img" class="image <?php echo $active;?>" src="<?php echo $global_size_guide['size_guide_image'];?>" alt="">
  </div>
  <div class="section_size_detalis">
    <h3>Size Guide</h3>
    <?php
    $size_guide_list = $global_size_guide['size_guide_list'];
    if(!empty($size_guide_list)){
      $count = 0;
      ?>
      <div id="single_table_1" class="sec_table active">
        <table>
          <tr>
            <th></th>
            <th>XS</th>
            <th>S</th>
            <th>M</th>
            <th>L</th>
            <th>XL</th>
            <th>XXL</th>
            <th>XXXL</th>
          </tr>
          <?php
          foreach($size_guide_list as $size_guide){
            if($count % 2 == 0){
              $class = 'even';
            }else{
              $class = '';
            }
            ?>
            <tr class="<?php echo $class;?>">
              <td><?php echo $size_guide['part_name'];?></td>
              <td><?php echo $size_guide['xs'];?></td>
              <td><?php echo $size_guide['s'];?></td>
              <td><?php echo $size_guide['m'];?></td>
              <td><?php echo $size_guide['l'];?></td>
              <td><?php echo $size_guide['xl'];?></td>
              <td><?php echo $size_guide['xxl'];?></td>
              <td><?php echo $size_guide['xxxl'];?></td>
            </tr>
            <?php
            $count++;
          }
          ?>
        </table>
      </div>
      <?php
    }
    ?>
  </div>
</div>
