<?php

$conn = conn();
$db   = new Database($conn);

$data = $db->single('groups',[
    'id' => $_GET['id']
]);

if(request() == 'POST')
{
    $db->update('groups',$_POST['groups'],[
        'id' => $_GET['id']
    ]);

    set_flash_msg(['success'=>'Grup berhasil diupdate']);
    header('location:index.php?r=groups/index');
}

return [
    'data' => $data
];