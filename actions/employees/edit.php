<?php

$conn = conn();
$db   = new Database($conn);

$data = $db->single('employees',[
    'id' => $_GET['id']
]);

$user = $db->single('users',['id'=>$data->user_id]);

if(request() == 'POST')
{
    if(!empty($_FILES['employees']['name']['pic']))
    {
        $pic  = $_FILES['employees'];
        $ext  = pathinfo($pic['name']['pic'], PATHINFO_EXTENSION);
        $name = strtotime('now').'.'.$ext;
        $file = 'employees/'.$name;
        copy($pic['tmp_name']['pic'],'../storage/'.$file);
        $_POST['employees']['pic'] = $file;
    }
    else
        $_POST['employees']['pic'] = $data->pic;

    if(!empty($_POST['detection']))
    {
        $detection = 'var employee_sample='.$_POST['detection'];
        file_put_contents('employee-samples/sample-'.$_GET['id'].'.js',$detection);
    }

    $db->update('employees',$_POST['employees'],[
        'id' => $_GET['id']
    ]);

    
    $password = $user->password;
    if(!empty($_POST['users']['password']))
        $password = md5($_POST['users']['password']);
    
    $db->update('users',[
        'name' => $_POST['employees']['name'],
        'username' => $_POST['users']['username'],
        'password' => $password,
    ],[
        'id' => $data->user_id
    ]);

    set_flash_msg(['success'=>'Pegawai berhasil diupdate']);
    header('location:index.php?r=employees/index');
}

$groups = $db->all('groups');

return compact('data','groups','user');