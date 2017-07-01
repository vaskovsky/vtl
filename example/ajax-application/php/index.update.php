<?php
/*!
 * Copyright © 2017 Alexey Vaskovsky.
 *
 * This file is part of VTL.
 *
 * VTL is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License
 * as published by the Free Software Foundation, either version 3
 * of the License, or (at your option) any later version.
 *
 * VTL is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with VTL. If not, see <http://www.gnu.org/licenses/>.
 * @file
 */
namespace Example;
try {
	require_once "config.php";
	$dividend = (int) trim(@$_POST["dividend"]);
	$divisor = (int) trim(@$_POST["divisor"]);
	if($divisor == 0) {
		http_response_code(400);
		header("Content-Type: text/plain");
		die("Divisor == 0");
	} else {
		$quotient = floor($dividend / $divisor);
		$remainder = $dividend % $divisor;
		header("Content-Type: application/json");
		echo json_encode([
			"dividend" => $dividend,
			"divisor" => $divisor,
			"quotient" => $quotient,
			"remainder" => $remainder
		]);
	}
} catch(\Exception $ex) {
	http_response_code(500);
	header("Content-Type: text/plain");
	die($ex->getMessage());
}
