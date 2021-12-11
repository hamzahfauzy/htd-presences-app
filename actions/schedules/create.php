<?php

if(request() == 'POST')
{
    $conn = conn();
    $db   = new Database($conn);

    $db->insert('schedules',$_POST['schedules']);

    set_flash_msg(['success'=>'Jadwal berhasil ditambahkan']);
    header('location:index.php?r=schedules/index');
}