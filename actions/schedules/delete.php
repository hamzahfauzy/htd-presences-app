<?php

$conn = conn();
$db   = new Database($conn);

$db->delete('schedules',[
    'id' => $_GET['id']
]);

set_flash_msg(['success'=>'Jadwal berhasil dihapus']);
header('location:index.php?r=schedules/index');
die();