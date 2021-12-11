<?php

$conn = conn();
$db   = new Database($conn);

$db->delete('groups',[
    'id' => $_GET['id']
]);

set_flash_msg(['success'=>'Grup berhasil dihapus']);
header('location:index.php?r=groups/index');
die();