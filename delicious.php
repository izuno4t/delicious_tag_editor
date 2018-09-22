<?php
require_once 'Log.php';

if (phpversion() < 5) {
	 require('delicious/delicious.php4.php');

	 if (function_exists("overload")) {
		  overload("Delicious");
	 }
} else {
	 require('delicious/delicious.php5.php');
}
