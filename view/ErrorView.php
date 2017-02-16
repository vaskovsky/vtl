<!DOCTYPE html>
<!-- Copyright © 2017 Alexey Vaskovsky -->
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content='<?php echo htmlspecialchars(_("ERROR")); ?>: <?php echo htmlspecialchars($code); ?>'>
    <title>
        <?php echo htmlspecialchars(_("ERROR")); ?>:
        <?php echo htmlspecialchars($code); ?>
    </title>
    <link href="./vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="./vendor/twbs/bootstrap/dist/css/bootstrap-theme.min.css" rel="stylesheet">
    <!--[if lt IE 9]><script type="text/javascript" src="./vendor/afarkas/html5shiv/dist/html5shiv.min.js"></script><script type="text/javascript" src="./vendor/foxou33/respond/dest/respond.min.js"></script><![endif]-->
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
                <?php echo htmlspecialchars(_("ERROR")); ?>:
                <?php echo htmlspecialchars($code); ?>
            </h1>
        </div>

        <div class="alert <?php if($code >= 500) { ?>alert-danger<?php } else { ?>alert-warning<?php } ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>

    </div>
    <script src="./vendor/components/jquery/jquery.min.js"></script>
    <script src="./vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="./vendor/grimmlink/bootstrap-filestyle/bootstrap-filestyle.min.js"></script>
</body>

</html>