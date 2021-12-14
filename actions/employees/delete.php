<?php

$conn = conn();
$db   = new Database($conn);
$employee = $db->single('employees',[
    'id' => $_GET['id']
]);

$db->delete('employees',[
    'id' => $_GET['id']
]);

$db->delete('users',[
    'id' => $employee->user_id
]);

set_flash_msg(['success'=>'Pegawai berhasil dihapus']);
header('location:index.php?r=employees/index');
die();