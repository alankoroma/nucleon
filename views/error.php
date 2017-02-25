<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>App &bull; <?php echo $status_code; ?></title>

        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="./public/assets/css/bootstrap.min.css" type="text/css" media="screen" />

        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <link rel="stylesheet" href="./public/assets/css/ie10-viewport-bug-workaround.css" />

        <!-- Styles -->
        <link rel="stylesheet" href="./public/assets/css/main.css"/>

        <style>
            body {
                font-family: 'Lato';
            }

            .fa-btn {
                margin-right: 6px;
            }
        </style>

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">App</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="./">Home</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- end of Navigation -->

        <!-- /container -->
        <div class="container">

            <div class="jumbotron">
                <div class="panel-heading"><h1><?php echo $error_name; ?></h1></div>
        		<div class="panel-body"><p><?php echo $error_message; ?></p></div>
            </div>

        </div>

        <!--  end of container -->

        <script src="./public/assets/js/jquery.min.js"></script>
        <script src="./public/assets/js/bootstrap.min.js"></script>
        <script src="./public/assets/js/script.js"></script>
    </body>
</html>
