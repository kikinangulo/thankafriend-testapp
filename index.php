<?php 

   $app_id = "390782660963770";
   $app_secret = "378cc6340c90c1e0b4b10c498ff66120";
   $my_url = "https://apps.facebook.com/mbdevapp/";

   session_start();
   $code = $_REQUEST["code"];

   if(empty($code)) {
     $_SESSION['state'] = md5(uniqid(rand(), TRUE)); //CSRF protection
     $dialog_url = "http://www.facebook.com/dialog/oauth?client_id=" 
       . $app_id . "&redirect_uri=" . urlencode($my_url) . "&state="
       . $_SESSION['state'];

     echo("<script> top.location.href='" . $dialog_url . "'</script>");
   }

   if($_REQUEST['state'] == $_SESSION['state']) {
     $token_url = "https://graph.facebook.com/oauth/access_token?"
       . "client_id=" . $app_id . "&redirect_uri=" . urlencode($my_url)
       . "&client_secret=" . $app_secret . "&code=" . $code;

     $response = file_get_contents($token_url);
     $params = null;
     parse_str($response, $params);

     $graph_url = "https://graph.facebook.com/me?access_token=" 
       . $params['access_token'];

     $user = json_decode(file_get_contents($graph_url));

   }
   else {

   }

 ?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Dev App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="/css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }
      .cursor {
          cursor: pointer;
      }
    </style>
    <link href="/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="/img/favicon.ico">
    <link rel="apple-touch-icon" href="/img/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/img/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/img/apple-touch-icon-114x114.png">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script type="text/javascript" src="/js/bootstrap.min.js"></script>
    
  </head>

  <body>
    <div id="fb-root"></div>

	<script>
      // Load the SDK Asynchronously
      (function(d){
         var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
         if (d.getElementById(id)) {return;}
         js = d.createElement('script'); js.id = id; js.async = true;
         js.src = "//connect.facebook.net/en_US/all.js";
         ref.parentNode.insertBefore(js, ref);
       }(document));

      // Init the SDK upon load
      window.fbAsyncInit = function() {
        FB.init({
          appId      : '390782660963770', // App ID
          channelUrl : '//'+window.location.hostname+'/channel', // Path to your Channel File
          status     : true, // check login status
          cookie     : true, // enable cookies to allow the server to access the session
          xfbml      : true,  // parse XFBML
          oauth      : true,
        });

        // listen for and handle auth.statusChange events
        FB.Event.subscribe('auth.statusChange', function(response) {
          if (response.authResponse) {
            // user has auth'd your app and is logged into Facebook

            
            FB.api('/me/friends', { limit: 10 }, function(response) {
                if(response.data) {
                    $.each(response.data,function(index,friend) {
                        $('#friends').append('<div id="' + friend.id  + '" class="span2 cursor"><img class="profile" alt="' + friend.name + '" src="https://graph.facebook.com/' + friend.id + '/picture" /><p>' + friend.name + '</p></div>');
                    });
                } else {
                    alert("Error!");
                }
            });
            

            
          } else {

          }
        });
      } 
    </script>

    <div class="container">
    	<h2>Display 10 random friends and on click give dialog to thank them</h2>
    	<p></p>
      <div class="row">

        <div class="span10">
<script src='https://connect.facebook.net/en_US/all.js'></script>


          <p></p>
          <div id="friends" class="row">

          </div><!--/row-->

        </div><!--/span-->
      </div><!--/row-->
      <button id="invite" class="btn-success">Invite Your Friends</button>
      
    <script type="text/javascript">
        $(function(){
            $(".profile").live("click", function(){
                var username = $(this).attr("alt");
                var obj = {
                    method: 'feed',
                    link: 'https://apps.facebook.com/mbdevapp/',
                    picture: '',
                    name: 'Thank You ' + username + '!',
                    caption: 'I just want to say thank you',
                    description: 'I just want to say thank you'
                    
                };
                function callback(response) {
                    document.getElementById('msg').innerHTML = "Post ID: " + response['post_id'];
                }
                FB.ui(obj, callback);
            });
        });
    </script>
    
        <script type="text/javascript">
        $(function(){ 
            $("#invite").on("click", function(event) {
                

                FB.ui({method: 'apprequests',
                    message: 'Howdy friend, I would like you to see my work at Stuzo and thank me for it'
                }, requestCallback);
                function requestCallback(response) {
                    // Handle callback here
                }

            });
        });
    </script>
    


      <hr>

      <footer>
        
      </footer>

    </div><!--/.fluid-container-->
    
    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script type="text/javascript" src="/app/app.js"></script>

  </body>
</html>