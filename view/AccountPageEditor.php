<!DOCTYPE html>
<!-- Copyright © 2017 Alexey Vaskovsky -->
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content='<?php echo htmlspecialchars(_("Account")); ?>'>
    <title>
        <?php echo htmlspecialchars(_("Account")); ?>
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
                <?php echo htmlspecialchars(_("Account")); ?>
            </h1>
        </div>
        <form action="?" method="post">
            <input name="id" value="<?php echo htmlspecialchars($model->id); ?>" type="hidden">
            <div class="form-group">
                <label><?php echo htmlspecialchars(_("User name")); ?></label>
                <input name="username" value="<?php echo htmlspecialchars($model->username); ?>" type="text" class="form-control" required="required">
            </div>
            <?php if($permissions->can_insert) { ?>
            <div class="form-group">
                <label><?php echo htmlspecialchars(_("Password")); ?></label>
                <input name="password" value="" type="password" class="form-control" required="required">
            </div>
            <?php } ?>
            <div class="checkbox">
                <label>
			<?php if($model->role_admin) { ?>
			<input name="role_admin" checked type="checkbox">
			<?php } else { ?>
			<input name="role_admin" type="checkbox">
			<?php } ?>
			<?php echo htmlspecialchars(_("Administrator")); ?>
		</label>
            </div>
            <div class="btn-group">
                <?php if($permissions->can_insert) { ?><button name="action" value="insert" type="submit" class="btn btn-success"><?php echo htmlspecialchars(_("Save")); ?></button>
                <?php } ?>
                <?php if($permissions->can_update) { ?><button name="action" value="update" type="submit" class="btn btn-success"><?php echo htmlspecialchars(_("Save")); ?></button>
                <?php } ?>
                <?php if($permissions->can_delete) { ?><button name="action" value="delete" type="submit" class="btn btn-danger" onclick="return confirm('<?php echo htmlspecialchars(_(" Confirm the deletion ")); ?>')"><?php echo htmlspecialchars(_("Delete")); ?></button>
                <?php } ?>
                <a href="?" class="btn btn-default">
                    <?php echo htmlspecialchars(_("Cancel")); ?>
                </a>
            </div>
        </form>

        <?php if($permissions->can_update) { ?>
        <div class="page-header">
            <h2>
                <?php echo htmlspecialchars(_("Change password")); ?>
            </h2>
        </div>
        <form action="?" method="post">
            <input name="id" value="<?php echo htmlspecialchars($model->id); ?>" type="hidden">
            <div class="form-group">
                <label><?php echo htmlspecialchars(_("Password")); ?></label>
                <input name="password" value="" type="password" class="form-control" required="required">
            </div>
            <button name="action" value="update" type="submit" class="btn btn-success"><?php echo htmlspecialchars(_("Save")); ?></button>
        </form>
        <?php } ?>

    </div>
    <script type="text/javascript" src="./js/application.js"></script>
</body>

</html>