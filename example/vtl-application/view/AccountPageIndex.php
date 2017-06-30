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
    <meta name="description" content='<?php echo htmlspecialchars(_("Accounts")); ?>'>
    <title>
        <?php echo htmlspecialchars(_("Accounts")); ?>
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
                <?php echo htmlspecialchars(_("Accounts")); ?>
            </h1>
        </div>

        <table class="table table-bordered table-striped" style="max-width: 30em;">
            <thead>
                <tr>
                    <th>
                        <?php echo htmlspecialchars(_("User name")); ?>
                    </th>
                    <th>
                        <?php echo htmlspecialchars(_("Permissions")); ?>
                    </th>
                    <th>
                        <a href="?action=add" class="btn btn-default">
                            <?php echo htmlspecialchars(_("Add")); ?>
                        </a>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($list as $item) { ?>
                <tr>
                    <td>
                        <?php echo htmlspecialchars($item->username); ?>
                    </td>
                    <td>
                        <?php if($item->role_admin) { ?>
                        <?php echo htmlspecialchars(_("Administrator") . "; "); ?>
                        <?php } ?>
                    </td>
                    <td>
                        <a href="?id=<?php echo htmlspecialchars($item->id); ?>" class="btn btn-default">
                            <?php echo htmlspecialchars(_("Edit")); ?>
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <script src="./vendor/components/jquery/jquery.min.js"></script>
    <script src="./vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="./vendor/grimmlink/bootstrap-filestyle/bootstrap-filestyle.min.js"></script>
</body>

</html>
