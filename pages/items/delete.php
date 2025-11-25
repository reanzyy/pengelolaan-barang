<?php
// function yang berada di folder app
require('./../../app/item.php');

// untuk mengambil data id dari url parameter
$id = $_GET['id'];

if (delete($id) > 0) {
  header('location: index.php?pesan=delete');
}
