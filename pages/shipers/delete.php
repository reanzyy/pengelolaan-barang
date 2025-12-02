<?php
require('./../../config.php');
require('./../../app/middleware.php');
require('./../../app/function/function.php');

checkAuth();

$id = $_GET['id'];

if (delete('shipments', $id) > 0) {
  header('Location: index.php?message=delete');
}
