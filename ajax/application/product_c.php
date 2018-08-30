<?php
namespace muse; require_once __dir__."/config.php"; require_once __dir__."/basic_auth.php"; try { $a = $GLOBALS["ACCOUNT"]->is_admin? 2: 1; if(isset($_POST["*"])) { $b = $_POST["*"]; for($c = 1; $c <= $b; $c++) { $d = new \stdClass(); if(isset($_POST["product_name"])) $d->product_name = trim($_POST["product_name"][$c]); else $d->product_name = trim(@$_GET["product_name"]); if(isset($_POST["image"])) $d->image = trim($_POST["image"][$c]); else $d->image = trim(@$_GET["image"]); if(isset($_POST["description"])) $d->description = is_null($_POST["description"][$c])? null: trim($_POST["description"][$c]); else $d->description = is_null(@$_GET["description"])? null: trim(@$_GET["description"]); if(isset($_POST["price"])) $d->price = trim($_POST["price"][$c]); else $d->price = trim(@$_GET["price"]); if($a >= 2) { $GLOBALS["DBH"]->exec("insert into product (product_name, image, description, price) values (".$GLOBALS["DBH"]->quote($d->product_name).", ".$GLOBALS["DBH"]->quote($d->image).", ".(is_null($d->description)? "null": $GLOBALS["DBH"]->quote($d->description)).", ".$GLOBALS["DBH"]->quote($d->price).")"); } else { http_response_code(403); echo "Доступ запрещён. Пройдите авторизацию."; } } } else if(isset($_POST["/"])) { if(isset($_GET["product_id"])) { $e = (int) trim($_GET["product_id"]); $d = new \stdClass(); if(isset($_POST["product_id"])) $d->product_id = (int) trim($_POST["product_id"][1]); else $d->product_id = (int) trim(@$_GET["product_id"]); if(isset($_POST["product_name"])) $d->product_name = trim($_POST["product_name"][1]); else $d->product_name = trim(@$_GET["product_name"]); if(isset($_POST["image"])) $d->image = trim($_POST["image"][1]); else $d->image = trim(@$_GET["image"]); if(isset($_POST["description"])) $d->description = is_null($_POST["description"][1])? null: trim($_POST["description"][1]); else $d->description = is_null(@$_GET["description"])? null: trim(@$_GET["description"]); if(isset($_POST["price"])) $d->price = trim($_POST["price"][1]); else $d->price = trim(@$_GET["price"]); if($a >= 2) { $GLOBALS["DBH"]->exec("update product set product_id = ".(int) $d->product_id.", product_name = ".$GLOBALS["DBH"]->quote($d->product_name).", image = ".$GLOBALS["DBH"]->quote($d->image).", description = ".(is_null($d->description)? "null": $GLOBALS["DBH"]->quote($d->description)).", price = ".$GLOBALS["DBH"]->quote($d->price)." where product_id = ".(int) $e); } else { http_response_code(403); echo "Доступ запрещён. Пройдите авторизацию."; } } else { http_response_code(400); echo "Неверный запрос к серверу"; } } else if(isset($_POST["-"])) { if(isset($_GET["product_id"])) { $e = (int) trim($_GET["product_id"]); if($a >= 2) { $GLOBALS["DBH"]->exec("delete from product where product_id = ".(int) $e); } else { http_response_code(403); echo "Доступ запрещён. Пройдите авторизацию."; } } else { http_response_code(400); echo "Неверный запрос к серверу"; } } else if(isset($_GET["product_id"])) { $e = (int) trim($_GET["product_id"]); if($a >= 1) { echo json_encode(["product" => $GLOBALS["DBH"]->query("select * from product where product_id = ".(int) $e)->fetchAll(\PDO::FETCH_OBJ)]); } else { http_response_code(403); echo "Доступ запрещён. Пройдите авторизацию."; } } else { if($a >= 1) { echo json_encode(["product" => $GLOBALS["DBH"]->query("select * from product order by product_id desc")->fetchAll(\PDO::FETCH_OBJ)]); } else { http_response_code(403); echo "Доступ запрещён. Пройдите авторизацию."; } } } catch(\Throwable $f) { http_response_code(500); echo $f->getMessage(); } 