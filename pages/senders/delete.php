<?php
require('./../../config.php');
require('./../../app/middleware.php');
require('./../../app/function/function.php');

checkAdmin();

$id = $_GET['id'];

if (delete('senders', $id) > 0) {
  header('Location: index.php?message=delete');
}
