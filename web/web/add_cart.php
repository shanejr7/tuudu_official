<?php 
 
 /* DOCS

  * 
  * [cart] <inserts selected items into cart>
  * [temporary_tag_schedule] <adds user order in schedule>
  * [csv_web_payouts] <stores order purchased for payouts>
  * [organization] <order amount is subtracted if purchased>
  * order_page.php --> add_cart.php <stores order selected>
  * 
  *
  *
  
*/
 
 
	if (isset($_POST["add_cart"])) {

     // Create connection
   
 
     $db = pg_connect(getenv("DATABASE_URL"));

     // Check connection
     if (!$db) {
        die("Connection failed: " . pg_connect_error());
        header('location:oops.php');
      }

  

     date_default_timezone_set($zone);

     $O = explode("-", $timezone[5]);
 

   $id = 0;

   if (isset($_SESSION['id'])) {
       $id = pg_escape_string($db, $_SESSION['id']);
     }elseif (isset($_SESSION['guestID'])) {
       $id = pg_escape_string($db, $_SESSION['guestID']);
     }


   $organization_publickey = trim(pg_escape_string($db, $_POST['publickey']));
   $org_id = pg_escape_string($db, $_POST['org_id']);
   $ticket_amt = pg_escape_string($db, $_POST['ticket_amount']);
   $title = trim(pg_escape_string($db, $_POST['eventTitle']));
   $price = doubleval(pg_escape_string($db, $_POST['price']));
   $size = trim(pg_escape_string($db, $_POST['size']));
   $price = $price * doubleval($ticket_amt);

   $tax = doubleval(pg_escape_string($db,0.06));
   $total =0;
   if ($price>=1) {
    $tax = $tax * $price;
   }else{
    $tax = 0;
   }
    
    $total = $price + $tax;

    $total = number_format($total,2);


 // removes duplicate from refreshing page 
 $query = "DELETE FROM cart WHERE user_id = $id AND publickey = '$organization_publickey'";
 pg_query($db, $query);

// insert selected value

 // product with size

if (isset($_POST['size'])) {
   $query = "INSERT INTO cart (user_id,org_id,publickey,ticket_amount,price,product_title,date_submitted,size) 
          VALUES($id,$org_id,'$organization_publickey',$ticket_amt,$total,'$title',NOW(),'$size')";
}else{


 $query = "INSERT INTO cart (user_id,org_id,publickey,ticket_amount,price,product_title,date_submitted) 
          VALUES($id,$org_id,'$organization_publickey',$ticket_amt,$total,'$title',NOW())";
}


   pg_query($db, $query);


 

pg_close($db);
}

if (isset($_GET["purchased"])) {

      // Create connection
   

   $db = pg_connect(getenv("DATABASE_URL"));

   // Check connection
  if (!$db) {
     die("Connection failed: " . pg_connect_error());
     header('location:oops.php');
  }


   $id = pg_escape_string($db, $_GET['purchased']);

   $query = "SELECT * FROM cart WHERE user_id = $id  ";
   $result = pg_query($db, $query);   
   $user_cart = pg_fetch_assoc($result);
 

 
  
   $organization_publickey = trim(pg_escape_string($db,$user_cart["publickey"]));
   $org_id = pg_escape_string($db,$user_cart["org_id"]);
   $ticket_amt = intval(pg_escape_string($db,$user_cart["ticket_amount"]));
   $title = trim(pg_escape_string($db,$user_cart["product_title"]));
   $price = doubleval(pg_escape_string($db,$user_cart["price"]));
   $size = trim(pg_escape_string($db,$user_cart["size"]));
 
   $price = number_format($price,2);

   if (isset($_SESSION['id'])) {


    // product with size
    if (isset($_POST['size'])) {

      $query = "INSERT INTO temporary_tag_schedule (user_id, org_id,publickey,ticket_amount,price,product_title,size) 
          VALUES($id,$org_id,'$organization_publickey',$ticket_amt,$price,'$title','$size')";
    }else{

      $query = "INSERT INTO temporary_tag_schedule (user_id, org_id,publickey,ticket_amount,price,product_title) 
          VALUES($id,$org_id,'$organization_publickey',$ticket_amt,$price,'$title')";
    }

     

   pg_query($db, $query);

   }
 
   


 

   // insert unique ID 
   $query = "SELECT email,payment_type,amount FROM organization WHERE publickey = '$organization_publickey'";
   $result = pg_query($db, $query);   
   $organization_info = pg_fetch_assoc($result);

  $email = trim(pg_escape_string($db,$organization_info["email"]));
  $total = $price - ($price *.5);
  $currency = 'USD';
  $message = 'payment received';
  $amount = trim(pg_escape_string($db,$organization_info["amount"]));
  $amount = intval($amount);
  $payment_type = trim(pg_escape_string($db,$organization_info["payment_type"]));
  date_default_timezone_set('UTC');
  $time = date('c');

      $query = "INSERT INTO csv_web_payouts (email,total,currency,message,payment_type,date_submitted,id) 
          VALUES('$email',$total,'$currency','$message','$payment_type','$time','$organization_publickey')";

      pg_query($db, $query);






   if (strcmp(trim($organization_info["amount"]), 'unlimited') == 0) {
     // do nothing
   }else{

      $amount = $amount -1;
   pg_query($db, "UPDATE public.organization SET amount= '$amount'  WHERE publickey = '$organization_publickey'");
   }

 


 


   $query = "DELETE FROM cart WHERE user_id = $id";
   pg_query($db, $query);


   pg_close($db);


  header("location:dashboard.php");

}


?>