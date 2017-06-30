<!--
	Copyright © 2017 Alexey Vaskovsky.

	This file is part of VTL.

	VTL is free software: you can redistribute it and/or modify
	it under the terms of the GNU Lesser General Public License
	as published by the Free Software Foundation, either version 3
	of the License, or (at your option) any later version.

	VTL is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
	GNU Lesser General Public License for more details.

	You should have received a copy of the GNU Lesser General Public
	License along with VTL. If not, see <http://www.gnu.org/licenses/>.
-->
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content='<?php echo htmlspecialchars(_("Hello World!")); ?>'>
    <title>
        <?php echo htmlspecialchars(_("Hello World!")); ?>
    </title>
    <link href="./vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="./vendor/twbs/bootstrap/dist/css/bootstrap-theme.min.css" rel="stylesheet">
    <!--[if lt IE 9]><script type="text/javascript" src="./vendor/afarkas/html5shiv/dist/html5shiv.min.js"></script><script type="text/javascript" src="./vendor/foxou33/respond/dest/respond.min.js"></script><![endif]-->
</head>

<body role="document">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button><a class="navbar-brand" href="./">VTL Application Example</a>
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
    <script src="./vendor/components/jquery/jquery.min.js"></script>
    <script src="./vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="./vendor/grimmlink/bootstrap-filestyle/bootstrap-filestyle.min.js"></script>
</body>

</html>
