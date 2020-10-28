
    document.getElementById("refresh").onclick = function () {
        location.href = "profile.php";
    };
    
     document.getElementById("pAccount").onclick = function () {
        location.href = "profile.php#profileAccount";
    };



$(document).ready(function() {


  $(document).on('click', '.unfollow_user_follow_btn', function () {

var key=$(this).data("key");
var id=$(this).data("userid");

unfollow_button(id,key);


 function unfollow_button(id,publickey)
 {
  

            $.ajax({
   url:"unfollow_user_follow.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){

       $.ajax({
   url:"fetch_user_connection_tab.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#connection_follow_tab').html(data);
   
     
   }
  })

    $('#following').html(data);
   
             $.ajax({
   url:"fetch_user_followers.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#followers').html(data);
     
   }
  })
   }
  })


       $.ajax({
   url:"fetch_user_profile_tab.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#profile_tab_data').html(data);
   
     
   }
  })

 }

 


    });

  $(document).on('click', '.unfollow_user_btn', function () {

var key=$(this).data("key");
var id=$(this).data("userid");

unfollow_button(id,key);


 function unfollow_button(id,publickey)
 {
  

            $.ajax({
   url:"unfollow_user.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){

       $.ajax({
   url:"fetch_user_connection_tab.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#connection_follow_tab').html(data);
   
     
   }
  })

    $('#following').html(data);
   
             $.ajax({
   url:"fetch_user_followers.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#followers').html(data);
     
   }
  })
   }
  })


       $.ajax({
   url:"fetch_user_profile_tab.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#profile_tab_data').html(data);
   
     
   }
  })

 }

 


    });

    $(document).on('click', '.post_unsubscribe', function () {

var key=$(this).data("publickey");
var id=$(this).data("id");
var pid=$(this).data("pid");


unfollow(pid,id,key);


 function unfollow(pid,id,publickey)
 {


    $.ajax({
   url:"subscription.php",
   method:"POST",
   data : {
        publickey : publickey,
        unsubscribe : publickey 
                    },
   success:function(data){

  
      $.ajax({
   url:"fetch_user_post.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : pid 
                    },
   success:function(data){
    $('#user_post').html(data);


        $.ajax({
   url:"fetch_users_post.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : pid 
                    },
   success:function(data){
    $('#users_post').html(data);



   }
  })
     
   }
  })
   
   }
  })
      $.ajax({
   url:"fetch_user_profile_tab.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#profile_tab_data').html(data);

      $.ajax({
   url:"fetch_user_connection_tab.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#connection_follow_tab').html(data);

      $.ajax({
   url:"fetch_user_followers.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#followers').html(data);
     
   }
  })
     
   }
  })
     
   }
  })

 }


    });

  $(document).on('click', '.post_subscribe', function () {

var key=$(this).data("publickey");
var id=$(this).data("id");
var pid=$(this).data("pid");


follow(pid,id,key);


 function follow(pid,id,publickey)
 {


    $.ajax({
   url:"subscription.php",
   method:"POST",
   data : {
        publickey : publickey,
        subscribe : publickey 
                    },
   success:function(data){
 

      $.ajax({
   url:"fetch_user_post.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : pid 
                    },
   success:function(data){
    $('#user_post').html(data);


        $.ajax({
   url:"fetch_users_post.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : pid 
                    },
   success:function(data){
    $('#users_post').html(data);



   }
  })
     
   }
  })
   
   }
  })
      $.ajax({
   url:"fetch_user_profile_tab.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#profile_tab_data').html(data);

      $.ajax({
   url:"fetch_user_connection_tab.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#connection_follow_tab').html(data);

      $.ajax({
   url:"fetch_user_followers.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#followers').html(data);
     
   }
  })
     
   }
  })
     
   }
  })

 }


    });

  $(document).on('click', '.post_unfollow_user', function () {

var key=$(this).data("publickey");
var id=$(this).data("id");


unfollow(id,key);


 function unfollow(id,publickey)
 {


    $.ajax({
   url:"unfollow_user.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){

      $('#following').html(data);


      $.ajax({
   url:"fetch_user_post.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#user_post').html(data);


        $.ajax({
   url:"fetch_users_post.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#users_post').html(data);
   }
  })
     
   }
  })



      $.ajax({
   url:"fetch_user_profile_tab.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#profile_tab_data').html(data);

      $.ajax({
   url:"fetch_user_connection_tab.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#connection_follow_tab').html(data);

      $.ajax({
   url:"fetch_user_followers.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#followers').html(data);
     
   }
  })
     
   }
  })
     
   }
  })


     



   
   }
  })


 }


    });


$(document).on('click', '.post_follow_user', function () {

var key=$(this).data("publickey");
var id=$(this).data("id");


follow(id,key);


 function follow(id,publickey)
 {


    $.ajax({
   url:"follow_user.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
   
    $('#following').html(data);

    $.ajax({
   url:"fetch_user_post.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#user_post').html(data);
     
   }
  })


    $.ajax({
   url:"fetch_users_post.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#users_post').html(data);
   }
  })



 
      $.ajax({
   url:"fetch_user_profile_tab.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){

    $('#profile_tab_data').html(data);
         $.ajax({
   url:"fetch_user_connection_tab.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#connection_follow_tab').html(data);

          $.ajax({
   url:"fetch_user_followers.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#followers').html(data);
     
   }
  })
     
   }
  })
     
   }
  })



  


   }
  })



 




 }


    });

$(document).on('click', '.remove_comment', function () {

    var key=$(this).data("key");
    var id=$(this).data("id");
    var uid=$(this).data("userid");
    var time=$(this).data("time");
     

  remove_post(uid,id,key,time);




 function remove_post(uid,id,publickey,time)
 {

        $.ajax({
   url:"remove_user_post.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : uid,
        time : time 
                    },
   success:function(data){

  $.ajax({
   url:"fetch_users_post.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#users_post').html(data);
   }
  })


    $.ajax({
   url:"fetch_user_comment_form.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id ,
        uid : uid
                    },
   success:function(data){
    $('#comment_post').html(data);
   }
  })

   }
  })


       $.ajax({
   url:"fetch_user_profile_tab.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : uid 
                    },
   success:function(data){
    $('#profile_tab_data').html(data);
    
            $.ajax({
   url:"fetch_user_followers.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : uid 
                    },
   success:function(data){
    $('#followers').html(data);
            $.ajax({
   url:"fetch_user_following.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : uid 
                    },
   success:function(data){
    $('#followers').html(data);
     
   }
  })
   }
  })
   }
  })
   

 

 }

 


    });






$(document).on('click', '.edit_comment', function () {

    var key=$(this).data("key");
    var uid=$(this).data("userid");
    var id=$(this).data("id");
    var time=$(this).data("time");
    var username=$(this).data("username");
    var replyid=$(this).data("replyid");
    var post=$("#postText").val();




edit_comment(uid,id,key,time,username,replyid,post);


 function edit_comment(uid,id,publickey,time,username,replyid,post)
 {





  $.ajax({
   url:"user_post_comment.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : uid,
        post : post,
        username : username,
        time : time,
        username : username,
        replyid : replyid,
        post : post
                    },
   success:function(data){
    $('#cleanPost').html(data);


        $.ajax({
   url:"fetch_users_post.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id
                    },
   success:function(data){
    $('#users_post').html(data);
   }
  })




    $.ajax({
   url:"fetch_user_comment_form.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id ,
        uid : uid
                    },
   success:function(data){
    $('#comment_post').html(data);
   }
  })


       $.ajax({
   url:"fetch_user_profile_tab.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : uid 
                    },
   success:function(data){
    $('#profile_tab_data').html(data);
             $.ajax({
   url:"fetch_user_followers.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : uid 
                    },
   success:function(data){
    $('#followers').html(data);
            $.ajax({
   url:"fetch_user_following.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : uid 
                    },
   success:function(data){
    $('#followers').html(data);
     
   }
  })
   }
  })
     
   }
  }) 
   
   }
  })


 

 }
 


    });


$(document).on('click', '.back_post', function () {

var key=$(this).data("key");
var id=$(this).data("id");
var uid=$(this).data("uid");



back_post(uid,id,key);


 function back_post(uid,id,publickey)
 {


    $.ajax({
   url:"fetch_user_comment_form.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id,
        uid : uid 
                    },
   success:function(data){
    $('#comment_post').html(data);
   }
  })


          $.ajax({
   url:"fetch_user_profile_tab.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : uid 
                    },
   success:function(data){
    $('#profile_tab_data').html(data);
    
              $.ajax({
   url:"fetch_user_followers.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : uid 
                    },
   success:function(data){
    $('#followers').html(data);
            $.ajax({
   url:"fetch_user_following.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : uid 
                    },
   success:function(data){
    $('#followers').html(data);
     
   }
  })
   }
  })
   }
  })

 }


    });

$(document).on('click', '.reply_comment', function () {

var key=$(this).data("key");
var id=$(this).data("userid");



reply_post(id,key);


 function reply_post(id,publickey)
 {


    $.ajax({
   url:"fetch_user_comment_form.php",
   method:"POST",
   data : {
        publickey : publickey,
        replyid : id,
        id : id 
                    },
   success:function(data){
    $('#comment_post').html(data);
   }
  })

 }

       $.ajax({
   url:"fetch_user_profile_tab.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#profile_tab_data').html(data);
             $.ajax({
   url:"fetch_user_followers.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#followers').html(data);
            $.ajax({
   url:"fetch_user_following.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#followers').html(data);
     
   }
  })
   }
  })
     
   }
  })


    });


  $(document).on('click', '.edit_post', function () {
         


          var key=$(this).data("key");
          var id=$(this).data("id");
          var uid=$(this).data("uid");
          var username=$(this).data("username");
          var post=$(this).data("message");
          var time=$(this).data("time");


          edit_post(uid,id,key,post,username,time);

           function edit_post(uid,id,publickey,post,username,time){

           


                  $.ajax({
                        url:"fetch_user_comment_form.php",
                        method:"POST",
                        data : {
                        publickey : publickey,
                        id : id,
                        uid : uid,
                        time : time,
                        username : username,
                        message : post
                    },
                        success:function(data){
                         $('#comment_post').html(data);
                          }
                   })


                        $.ajax({
   url:"fetch_user_profile_tab.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : uid 
                    },
   success:function(data){
    $('#profile_tab_data').html(data);
    
              $.ajax({
   url:"fetch_user_followers.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : uid 
                    },
   success:function(data){
    $('#followers').html(data);
            $.ajax({
   url:"fetch_user_following.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : uid 
                    },
   success:function(data){
    $('#followers').html(data);
     
   }
  })
   }
  })
   }
  })


           }
        

    });




    $(document).on('click', '.favPost', function () {
         


          var key=$(this).data("key");
          var id=$(this).data("userid");
          var username=$(this).data("username");
          var time=$(this).data("time");
          

          fav_post(id,key,username,time);

           function fav_post(id,publickey,username,time){


                  $.ajax({
                        url:"fav_message.php",
                        method:"POST",
                        data : {
                        publickey : publickey,
                        id : id,
                        time : time,
                        username : username
                    },
                        success:function(data){
                             

                           $.ajax({
     url:"fetch_users_post.php",
      method:"POST",
        data : {
        publickey : publickey,
        id : id 
        },
       success:function(data){
        $('#users_post').html(data);
         }
    })
      $.ajax({
   url:"fetch_user_profile_tab.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#profile_tab_data').html(data);
             $.ajax({
   url:"fetch_user_followers.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#followers').html(data);
            $.ajax({
   url:"fetch_user_following.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#followers').html(data);
     
   }
  })
   }
  })
     
   }
  })


                          }
                   })


 
           }
        

    });

     $(document).on('click', '.post_comment', function () {

 

var key=$(this).data("key");
var id=$(this).data("userid");
var pid =$(this).data("id");
var username=$(this).data("username");
var replyid=$(this).data("replyid");
var post=$("#postText").val();

 
user_post(pid,id,key,post,username,replyid);


 function user_post(pid,id,publickey,post,username,replyid)
 {
 
 
  $.ajax({
   url:"user_post_comment.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id,
        post : post,
        username : username,
        replyid : replyid 
                    },
   success:function(data){

    $('#cleanPost').html(data);

        $.ajax({
   url:"fetch_users_post.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : pid 
                    },
   success:function(data){
    $('#users_post').html(data);
   }
  })

          $.ajax({
   url:"fetch_user_profile_tab.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#profile_tab_data').html(data);
             $.ajax({
   url:"fetch_user_followers.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#followers').html(data);
            $.ajax({
   url:"fetch_user_following.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#followers').html(data);
     
   }
  })
   }
  })
     
   }
  })
   
   }
  })


 



 }

});

$(document).on('click', '.post_chat', function () {

 
var key=$(this).data("key");
var id=$(this).data("id");

 
fetch_user(id,key);


 function fetch_user(id,publickey)
 {

 
 
  $.ajax({
   url:"fetch_user_post.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#user_post').html(data);
     
   }
  })


    $.ajax({
   url:"fetch_users_post.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#users_post').html(data);
        $.ajax({
   url:"fetch_user_comment_form.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#comment_post').html(data);
   }
  })
   }
  })



          $.ajax({
   url:"fetch_user_profile_tab.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#profile_tab_data').html(data);
    
              $.ajax({
   url:"fetch_user_followers.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#followers').html(data);
            $.ajax({
   url:"fetch_user_following.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#followers').html(data);
     
   }
  })
   }
  })
   }
  })

 }

});


   });
 
