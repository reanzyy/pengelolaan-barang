<?php
require_once __DIR__ . '/../connection.php';

function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

function query($sql, $params = [])
{
    global $conn;

    if (empty($params)) {
        $result = mysqli_query($conn, $sql);

        if (!$result) return [];

        $rows = [];
        while ($row = mysqli_fetch_object($result)) {
            $rows[] = $row;
        }
        return $rows;
    }

    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) return [];

    $types = '';
    foreach ($params as $value) {
        if (is_int($value)) $types .= 'i';
        elseif (is_float($value)) $types .= 'd';
        else $types .= 's';
    }

    mysqli_stmt_bind_param($stmt, $types, ...$params);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $rows = [];
    while ($row = mysqli_fetch_object($result)) {
        $rows[] = $row;
    }

    mysqli_stmt_close($stmt);
    return $rows;
}

function store($table, $data)
{
    global $conn;

    $columns = array_keys($data);
    $placeholders = array_fill(0, count($data), '?');

    $sql = "INSERT INTO `$table` (`"
        . implode("`,`", $columns)
        . "`) VALUES ("
        . implode(",", $placeholders)
        . ")";

    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) return false;

    $types = '';
    $values = [];
    foreach ($data as $value) {
        if (is_int($value)) $types .= 'i';
        elseif (is_float($value)) $types .= 'd';
        else $types .= 's';

        $values[] = $value;
    }

    mysqli_stmt_bind_param($stmt, $types, ...$values);
    $ok = mysqli_stmt_execute($stmt);
    $affected = mysqli_stmt_affected_rows($stmt);
    mysqli_stmt_close($stmt);

    return $ok ? $affected : false;
}

function update($table, $data, $id)
{
    global $conn;

    $columns = array_keys($data);
    $setQuery = implode(" = ?, ", $columns) . " = ?";

    $sql = "UPDATE `$table` SET $setQuery WHERE id = ?";

    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) return false;

    $types = '';
    $values = [];

    foreach ($data as $value) {
        if (is_int($value)) $types .= 'i';
        elseif (is_float($value)) $types .= 'd';
        else $types .= 's';

        $values[] = $value;
    }

    $types .= is_int($id) ? 'i' : 's';
    $values[] = $id;

    mysqli_stmt_bind_param($stmt, $types, ...$values);

    $ok = mysqli_stmt_execute($stmt);
    $affected = mysqli_stmt_affected_rows($stmt);
    mysqli_stmt_close($stmt);

    return $ok ? $affected : false;
}

function delete($table, $id)
{
    global $conn;

    $sql = "DELETE FROM `$table` WHERE id = ?";

    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) return false;

    if (is_int($id)) mysqli_stmt_bind_param($stmt, "i", $id);
    else mysqli_stmt_bind_param($stmt, "s", $id);

    $ok = mysqli_stmt_execute($stmt);
    $affected = mysqli_stmt_affected_rows($stmt);
    mysqli_stmt_close($stmt);

    return $ok ? $affected : false;
}
