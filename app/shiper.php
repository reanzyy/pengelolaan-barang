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

    $tracking_number = $data['tracking_number'];
    $item_id = $data['item_id'];
    $status = $data['status'];
    $sender_id = $data['sender_id'];
    $receiver_id = $data['receiver_id'];

    $sql = "INSERT INTO shipments (
            tracking_number, 
            item_id, 
            sender_id,
            receiver_id,
            status
        ) VALUES (
            '$tracking_number',
            '$item_id',
            '$sender_id',
            '$receiver_id',
            '$status'
        )";

    mysqli_query($conn, $sql);

    return mysqli_affected_rows($conn);
}


function update($data, $id)
{
    global $conn;

    $tracking_number = $data['tracking_number'];
    $item_id = $data['item_id'];
    $status = $data['status'];
    $sender_id = $data['sender_id'];
    $receiver_id = $data['receiver_id'];

    $sql = "UPDATE shipments SET
                tracking_number = '$tracking_number',
                item_id = '$item_id',
                status = '$status',
                sender_id = '$sender_id',
                receiver_id = '$receiver_id'
            WHERE id = $id";

    mysqli_query($conn, $sql);

    return mysqli_affected_rows($conn);
}


function delete($id)
{
    global $conn;

    mysqli_query($conn, "DELETE FROM shipments WHERE id = $id");

    return mysqli_affected_rows($conn);
}
