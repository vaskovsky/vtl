<!DOCTYPE html>
<!-- Copyright © 2017 Alexey Vaskovsky -->
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content='<?php echo htmlspecialchars(_("Hello World!")); ?>'>
    <title>
        <?php echo htmlspecialchars(_("Hello World!")); ?>
    </title>
    <link rel="stylesheet" href="./css/application.css">
    <!--[if lt IE 9]><script type="text/javascript" src="./js/application-ie8.js"></script><![endif]-->
</head>

<body role="document">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button><a class="navbar-brand" href="./">Vaskovsky Web Application</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="./">
                            <?php echo htmlspecialchars(_("Home")); ?>
                        </a>
                    </li>
                    <li>
                        <a href="./install.php" target="_blank">
                            <?php echo htmlspecialchars(_("Install")); ?>
                        </a>
                    </li>
                    <li>
                        <a href="./accounts.php">
                            <?php echo htmlspecialchars(_("Accounts")); ?>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container" role="main">

        <div class="page-header">
            <h1>
                <?php echo htmlspecialchars(_("Hello World!")); ?>
            </h1>
        </div>

        <p>
            <?php echo htmlspecialchars(_("To install the database go to the \"Install\" page.")); ?>
        </p>

        <p>
            <?php echo htmlspecialchars(_("To edit accounts go to the \"Accounts\" page.")); ?>
        </p>

        <p>
            <?php echo htmlspecialchars(_("The administrator username")); ?>: admin</p>

        <p>
            <?php echo htmlspecialchars(_("The administrator password")); ?>: admin</p>

    </div>
    <script type="text/javascript" src="./js/application.js"></script>
</body>

</html>