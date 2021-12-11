<?php

if(request() == 'POST')
{
    $conn = conn();
    $db   = new Database($conn);

    $db->insert('groups',$_POST['groups']);

    set_flash_msg(['success'=>'Grup berhasil ditambahkan']);
    header('location:index.php?r=groups/index');
}