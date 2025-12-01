<?php
require __DIR__ . '/../connection.php';

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

function store($table, $data)
{
    global $conn;

    $columns = [];
    $values = [];

    foreach ($data as $column => $value) {
        $columns[] = $column;
        $values[] = "'" . mysqli_real_escape_string($conn, $value) . "'";
    }

    $columnString = implode(", ", $columns);
    $valueString = implode(", ", $values);

    $sql = "INSERT INTO $table ($columnString) VALUES ($valueString)";

    mysqli_query($conn, $sql);

    return mysqli_affected_rows($conn);
}

function update($table, $data, $id, $idColumn = 'id')
{
    global $conn;

    $set = [];
    foreach ($data as $column => $value) {
        $value = mysqli_real_escape_string($conn, $value);
        $set[] = "$column = '$value'";
    }

    $setQuery = implode(", ", $set);

    $sql = "UPDATE $table SET $setQuery WHERE $idColumn = '$id'";

    mysqli_query($conn, $sql);

    return mysqli_affected_rows($conn);
}

function delete($table, $id, $idColumn = "id")
{
    global $conn;

    mysqli_query($conn, "DELETE FROM $table WHERE $idColumn = '$id'");

    return mysqli_affected_rows($conn);
}