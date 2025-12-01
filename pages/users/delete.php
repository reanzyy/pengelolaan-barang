<?php
require('./../../config.php');
require('./../../app/middleware.php');
require('./../../app/function/function.php');

checkAdmin();

$id = $_GET['id'];

if (delete('users', $id) > 0) {
  header('Location: index.php?message=delete');
}
