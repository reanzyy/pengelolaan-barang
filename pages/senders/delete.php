<?php
require('./../../app/function/function.php');

$id = $_GET['id'];

if (delete('senders', $id) > 0) {
  header('location: index.php?pesan=delete');
}
