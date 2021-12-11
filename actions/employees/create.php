<?php
$conn = conn();
$db   = new Database($conn);

if(request() == 'POST')
{
    $pic  = $_FILES['employees'];
    $ext  = pathinfo($pic['name']['pic'], PATHINFO_EXTENSION);
    $name = strtotime('now').'.'.$ext;
    $file = 'uploads/employees/'.$name;
    copy($pic['tmp_name']['pic'],$file);
    $_POST['employees']['pic'] = $file;
    $_POST['users']['name'] = $_POST['employees']['name'];
    $_POST['users']['password'] = md5($_POST['users']['password']);

    $user = $db->insert('users',$_POST['users']);
    $role = $db->single('roles',['name'=>'pegawai']);

    $db->insert('user_roles',[
        'user_id' => $user->id,
        'role_id' => $role->id,
    ]);

    $_POST['employees']['user_id'] = $user->id;

    $db->insert('employees',$_POST['employees']);

    set_flash_msg(['success'=>'Pegawai berhasil ditambahkan']);
    header('location:index.php?r=employees/index');
}

$groups = $db->all('groups');

return compact('groups');