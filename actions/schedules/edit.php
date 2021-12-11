<?php

$conn = conn();
$db   = new Database($conn);

$data = $db->single('schedules',[
    'id' => $_GET['id']
]);

if(request() == 'POST')
{
    $db->update('schedules',$_POST['schedules'],[
        'id' => $_GET['id']
    ]);

    set_flash_msg(['success'=>'Role berhasil diupdate']);
    header('location:index.php?r=schedules/index');
}

return [
    'data' => $data
];