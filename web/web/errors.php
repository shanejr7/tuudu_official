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
  	  <p><?php echo $error ?>  </p>
  	<?php endforeach ?>
  </div>
<?php  endif ?>

 <?php if (count($new_password_error) > 0) : ?>
  <div class="error">
    <?php foreach ($new_password_error as $error) : ?>
      <p><?php echo $error ?>  </p>
    <?php endforeach ?>
  </div>
<?php  endif ?>


<?php if (count($errors_dashboard) > 0) : ?>
  <div class="error">
  	<?php foreach ($errors_dashboard as $error) : ?>
  	  <p><?php echo $error ?>  </p>
  	<?php endforeach ?>
  </div>
<?php  endif ?>


<?php if (count($errors_list) > 0) : ?>
  <div class="error">
  	<?php foreach ($errors_list as $error) : ?>
  	  <p><?php echo $error ?>  </p>
  	<?php endforeach ?>
  </div>
<?php  endif ?>

<?php if (count($errors_schedule) > 0) : ?>
  <div class="error">
    <?php foreach ($errors_schedule as $error) : ?>
      <p><?php echo $error ?>  </p>
    <?php endforeach ?>
  </div>
<?php  endif ?>