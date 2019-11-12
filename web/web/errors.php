<?php
/* reports errors associated to:

 * validating logging in and logging out

 * query results for dashboard

 * query results for schedule

 * query results for list

*/




 if (count($errors) > 0) : ?>
  <div class="error">
  	<?php foreach ($errors as $error) : ?>
  	  <p><?php echo $error ?> <span class="text-warning btn-md-link">Warning<i class=" text-warning btn-md-link fa fa-warning pl-10"></i><span></p>
  	<?php endforeach ?>
  </div>
<?php  endif ?>


<?php if (count($errors_dashboard) > 0) : ?>
  <div class="error">
  	<?php foreach ($errors_dashboard as $error) : ?>
  	  <p><?php echo $error ?> <span class="text-warning btn-md-link"> <i class=" text-warning btn-md-link fa fa-warning pl-10"></i><span></p>
  	<?php endforeach ?>
  </div>
<?php  endif ?>


<?php if (count($errors_list) > 0) : ?>
  <div class="error">
  	<?php foreach ($errors_list as $error) : ?>
  	  <p><?php echo $error ?> <span class="text-warning btn-md-link"> <i class=" text-warning btn-md-link fa fa-warning pl-10"></i><span></p>
  	<?php endforeach ?>
  </div>
<?php  endif ?>

<?php if (count($errors_schedule) > 0) : ?>
  <div class="error">
    <?php foreach ($errors_schedule as $error) : ?>
      <p><?php echo $error ?> <span class="text-warning btn-md-link"> <i class=" text-warning btn-md-link fa fa-warning pl-10"></i><span></p>
    <?php endforeach ?>
  </div>
<?php  endif ?>