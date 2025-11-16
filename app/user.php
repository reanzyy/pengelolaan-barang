<?php
require('connection.php');

function query($query)
{
  global $conn;

  $result = mysqli_query($conn, $query);
  $rows = [];
  while ($row = mysqli_fetch_object($result)) {
    $rows[] = $row;
  }
  return $rows;
}

function store($data)
{
  global $conn;

  $name = $data['name'];
  $username = $data['username'];
  $password = $data['password'];

  $sql = "INSERT INTO users (name, username, password) VALUES ('$name', '$username', '$password')";
  mysqli_query($conn, $sql);

  return mysqli_affected_rows($conn);
}

function update($data, $id)
{
  global $conn;

  $name = $data['name'];
  $username = $data['username'];
  $password = $data['password'];

  $isEditedPassword = $password ? ", password ='$password'" : '';

  $sql = "UPDATE users SET name = '$name', username = '$username' $isEditedPassword WHERE id = $id";
  mysqli_query($conn, $sql);

  return mysqli_affected_rows($conn);
}

function delete($id)
{
  global $conn;

  mysqli_query($conn, "DELETE FROM users where id = $id");

  return mysqli_affected_rows($conn);
}
