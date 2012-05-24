
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
            FB.api('/me', function(me){
              if (me.name) {
                document.getElementById('auth-displayname').innerHTML = me.name;
                document.getElementById('auth-displayname').innerHTML = me.name;
              }
            })
            
            FB.api('/me/friends', { limit: 10 }, function(response) {
                if(response.data) {
                    $.each(response.data,function(index,friend) {
                        $('#friends').append('<div id="' + friend.id  + '" class="span3"><img class="profile" src="http://graph.facebook.com/' + friend.id + '/picture" /><p>' + friend.name + '</p></div>');
                    });
                } else {
                    alert("Error!");
                }
            });
            
            document.getElementById('auth-loggedout').style.display = 'none';
            document.getElementById('auth-loggedin').style.display = 'block';
            
          } else {
            // user has not auth'd your app, or is not logged into Facebook
            document.getElementById('auth-loggedout').style.display = 'block';
            document.getElementById('auth-loggedin').style.display = 'none';
          }
        });

        // respond to clicks on the login and logout links
        document.getElementById('auth-loginlink').addEventListener('click', function(){
          FB.login();
        });
        document.getElementById('auth-logoutlink').addEventListener('click', function(){
          FB.logout();
        }); 
      } 
    </script>


    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          Test FB Page
          <div class="nav-collapse">
            <ul class="nav">

            </ul>
            <p class="navbar-text pull-right">    
      			<div id="auth-status" style="padding-top:11px;">
        			<div id="auth-loggedout">
          				<a href="#" id="auth-loginlink">Login</a>
        			</div>
        			<div id="auth-loggedin" style="display:none; color:#ffffff;">
          				Hi, <span id="auth-displayname"></span>  
        				(<a href="#" id="auth-logoutlink">logout</a>)
      				</div>
    			</div>
    		</p>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container-fluid">
    	<h2>Display 10 random friends and onclick give dialog to thank them</h2>
    	<p></p>
      <div class="row">

        <div class="span12">
<script src='http://connect.facebook.net/en_US/all.js'></script>


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
                    link: 'http://fbtestapp.dev/index.php',
                    picture: 'http://graph.facebook.com/' + userId + '/picture',
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