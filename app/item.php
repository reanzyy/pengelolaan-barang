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
    $weight = $data['weight'];
    $category = $data['category'];

    $sql = "INSERT INTO items (name, weight, category) VALUES ('$name', '$weight', '$category')";
    mysqli_query($conn, $sql);

    return mysqli_affected_rows($conn);
}

function update($data, $id)
{
    global $conn;

    $name = $data['name'];
    $weight = $data['weight'];
    $category = $data['category'];

    $sql = "UPDATE items SET
                name = '$name',
                weight = '$weight',
                category = '$category',
            WHERE id = $id";

    mysqli_query($conn, $sql);

    return mysqli_affected_rows($conn);
}

function delete($id)
{
    global $conn;

    mysqli_query($conn, "DELETE FROM items where id = $id");

    return mysqli_affected_rows($conn);
}
