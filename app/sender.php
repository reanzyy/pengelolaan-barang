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
    $phone = $data['phone'];
    $address = $data['address'];
    $city = $data['city'];


    $sql = "INSERT INTO senders (name, phone, address, city) VALUES ('$name', '$phone', '$address', '$city')";
    mysqli_query($conn, $sql);

    return mysqli_affected_rows($conn);
}

function update($data, $id)
{
    global $conn;

    $name = $data['name'];
    $phone = $data['phone'];
    $address = $data['address'];
    $city = $data['city'];

    $sql = "INSERT INTO senders (name, phone, address, city) VALUES ('$name', '$phone', '$address', '$city')";
    mysqli_query($conn, $sql);

    return mysqli_affected_rows($conn);
}

function delete($id)
{
    global $conn;

    mysqli_query($conn, "DELETE FROM users where id = $id");

    return mysqli_affected_rows($conn);
}
