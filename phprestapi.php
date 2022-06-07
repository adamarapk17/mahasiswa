<?php
require_once "koneksi.php";
if (function_exists($_GET['function'])) {
    $_GET['function']();
}
function get_mahasiswa()
{
    global $connect;
    $query = $connect->query("SELECT * FROM mahasiswa");
    while ($row = mysqli_fetch_object($query)) {
        $data[] = $row;
    }
    $response = array(
        'status' => 1,
        'message' => 'Success',
        'data' => $data
    );
    header('Content-Type: application/json');
    echo json_encode($response);
}

function get_mahasiswa_id()
{
    global $connect;
    if (!empty($_GET["id"])) {
        $id = $_GET["id"];
    }
    $query = "SELECT * FROM mahasiswa WHERE id= $id";
    $result = $connect->query($query);
    while ($row = mysqli_fetch_object($result)) {
        $data[] = $row;
    }
    if ($data) {
        $response = array(
            'status' => 1,
            'message' => 'Success',
            'data' => $data
        );
    } else {
        $response = array(
            'status' => 0,
            'message' => 'No Data Found'
        );
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}
function insert_mahasiswa()
{
    global $connect;
    $check = array('id' => '', 'nama' => '', 'alamat' => '', 'jurusan' => '', 'nilai_ipk' => '');
    $check_match = count(array_intersect_key($_POST, $check));
    if ($check_match == count($check)) {
        $result = mysqli_query($connect, "INSERT INTO mahasiswa SET
               id = '$_POST[id]',
               nama = '$_POST[nama]',
               alamat = '$_POST[alamat]',
               jurusan = '$_POST[jurusan]',
               nilai_ipk = '$_POST[nilai_ipk]',
               grade = '$_POST[grade]'");

        if ($result) {
            $response = array(
                'status' => 1,
                'message' => 'Insert Success'
            );
        } else {
            $response = array(
                'status' => 0,
                'message' => 'Insert Failed.'
            );
        }
    } else {
        $response = array(
            'status' => 0,
            'message' => 'Wrong Parameter'
        );
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}
function update_mahasiswa()
{
    global $connect;
    if (!empty($_GET["id"])) {
        $id = $_GET["id"];
    }
    $check = array('nama' => '', 'alamat' => '', 'jurusan' => '', 'nilai_ipk' => '');
    $check_match = count(array_intersect_key($_POST, $check));
    if ($check_match == count($check)) {

        $result = mysqli_query($connect, "UPDATE mahasiswa SET               
               nama = '$_POST[nama]',
               alamat = '$_POST[alamat]',
               alamat = '$_POST[alamat]',
               nilai_ipk = '$_POST[nilai_ipk]',
               grade = '$_POST[grade]' WHERE id = $id");

        if ($result) {
            $response = array(
                'status' => 1,
                'message' => 'Update Success'
            );
        } else {
            $response = array(
                'status' => 0,
                'message' => 'Update Failed'
            );
        }
    } else {
        $response = array(
            'status' => 0,
            'message' => 'Wrong Parameter',
            'data' => $id
        );
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}
function delete_mahasiswa()
{
    global $connect;
    $id = $_GET['id'];
    $query = "DELETE FROM mahasiswa WHERE id=" . $id;
    if (mysqli_query($connect, $query)) {
        $response = array(
            'status' => 1,
            'message' => 'Delete Success'
        );
    } else {
        $response = array(
            'status' => 0,
            'message' => 'Delete Fail.'
        );
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}