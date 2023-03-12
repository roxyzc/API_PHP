<?php
function getMahasiswa()
{
    global $connection;
    $query = "SELECT * FROM tb_mahasiswa";
    $response = array();

    $result = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_array($result)) {
        $response[] = array("id_mahasiswa" => $row["id"], "nama_mahasiswa" => $row["nama"], "kelas_mahasiswa" => $row["kelas"], "nim_mahasiswa" => $row["nim"]);
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}

function getMahasiswaById($id = 0)
{
    global $connection;
    $query = "SELECT * FROM tb_mahasiswa";
    if ($id != 0) {
        $query .= " WHERE id=" . $id . " LIMIT 1";
    }
    $response = array();
    $result = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_array($result)) {
        $response[] = array("id" => $row["id"], "nama_mahasiswa" => $row["nama"], "kelas_mahasiswa" => $row["kelas"], "nim_mahasiswa" => $row["nim"]);
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}

function insert_mahasiswa()
{
    global $connection;
    $data = json_decode(file_get_contents('php://input'), true);
    $nama = $data["nama"];
    $kelas = $data["kelas"];
    $nim = $data["nim"];
    $query = "INSERT INTO tb_mahasiswa SET
nama='" . $nama . "', kelas='" . $kelas . "', nim='" . $nim . "'";
    if (mysqli_query($connection, $query)) {
        $response = array(
            'status' => 1,
            'status_message' => 'Employee Added Successfully.'
        );
    } else {
        $response = array(
            'status' => 0,
            'status_message' => 'Employee Addition Failed.'
        );
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}

function update_mahasiswa($id)
{
    global $connection;
    $data = json_decode(file_get_contents('php://input'), true);
    $nama = $data["nama"];
    $kelas = $data["kelas"];
    $nim = $data["nim"];
    $query = "UPDATE tb_mahasiswa SET nama='" . $nama . "', 
     kelas='" . $kelas . "', 
    nim='" . $nim . "' WHERE id=" . $id;
    if (mysqli_query($connection, $query)) {
        $response = array(
            'status' => 1,
            'status_message' => 'mahasiswa Updated Successfully.'
        );
    } else {
        $response = array(
            'status' => 0,
            'status_message' => 'mahasiswa Updation Failed.'
        );
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}

function delete_mahasiswa($id)
{
    global $connection;
    $query = "DELETE FROM tb_mahasiswa WHERE id=" . $id;
    if (mysqli_query($connection, $query)) {
        $response = array(
            'status' => 1,
            'status_message' => 'mahasiswa Deleted Successfully.'
        );
    } else {
        $response = array(
            'status' => 0,
            'status_message' => 'mahasiswa Deletion Failed.'
        );
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}
