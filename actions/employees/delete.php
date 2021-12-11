<?php

$conn = conn();
$db   = new Database($conn);

$db->delete('employees',[
    'id' => $_GET['id']
]);

set_flash_msg(['success'=>'Pegawai berhasil dihapus']);
header('location:index.php?r=employees/index');
die();