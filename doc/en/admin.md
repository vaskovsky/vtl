# Administrator Password

Default,
* Administrator Login: `admin`
* Administrator Password: `admin`

To change the defaults, open the file `config.php`.

Find the lines:

```
### 1.2. Administrator
$ADMIN_LOGIN = "admin";
$ADMIN_PASSWORD = "admin";
```

Replace the parameter values `$ADMIN_LOGIN` and `$ADMIN_PASSWORD`:

```
$ADMIN_LOGIN = "new_admin_login";
$ADMIN_PASSWORD = "new_admin_password";
```
where

`new_admin_login`: new default administrator login.

`new_admin_password`: new default administrator password.

After installation of the program, administrator login and password can be changed only through the web interface.
Login and password in the file `config.php` will be ignored.

Be sure to change the administrator password after installing the application.

To do this, select the menu item `Settings`.
________________________________________________________________________________
