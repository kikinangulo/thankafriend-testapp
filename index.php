<?php

    require_once("/facebook/facebook.php");

    require_once('utils.php');

    $config = array();
    $config['appId'] = '390782660963770';
    $config['secret'] = '378cc6340c90c1e0b4b10c498ff66120';
    $config['fileUpload'] = false; // optional

    $facebook = new Facebook($config);
    
    $user_id = $facebook->getUser();
    if ($user_id) {
        try {
            // Fetch the viewer's basic information
            $basic = $facebook->api('/me');
        } catch (FacebookApiException $e) {
            // If the call fails we check if we still have a user. The user will be
            // cleared if the error is because of an invalid accesstoken
            if (!$facebook->getUser()) {
            header('Location: '. AppInfo::getUrl($_SERVER['REQUEST_URI']));
            exit();
            }
        }

        // This fetches 10 of your friends.
        $friends = idx($facebook->api('/me/friends?limit=10'), 'data', array());
        foreach ($friends as &$friend) {
                $url = 'https://graph.facebook.com/' . $friend->id . '/picture';
                $img = '/userimages/' . $friend->id . '.jpg';
                file_put_contents($img, file_get_contents($url));
        }

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
    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
            <h1>Test FB Page</h1>
          <div class="nav-collapse">
            <ul class="nav">

            </ul>

        </div>
      </div>
    </div>

    <div class="container-fluid">
    	<h2>Display 10 random friends and onclick give dialog to thank them</h2>
    	<p></p>
      <div class="row">

        <div class="span12">
<script src='https://connect.facebook.net/en_US/all.js'></script>


          <p></p>
          <div id="friends" class="row">

          </div><!--/row-->

        </div><!--/span-->
      </div><!--/row-->
      
    <script type="text/javascript">
        $(function(){ 
            $(".profile").live("click",(function() {
                var userId = $(this).attr("id");
                var obj = {
                    method: 'feed',
                    link: 'https://high-leaf-9955.herokuapp.com/',
                    picture: 'https://graph.facebook.com/' + userId + '/picture',
                    name: 'Thank You Friend!',
                    caption: 'I just want to say thank you',
                    description: 'I just want to say thank you'
                };
                function callback(response) {
                    document.getElementById('msg').innerHTML = "Post ID: " + response['post_id'];
                }

                FB.ui(obj, callback);
            }));
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