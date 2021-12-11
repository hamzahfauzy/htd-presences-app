<?php

if(request() == 'POST')
{
    $conn  = conn();
    $db    = new Database($conn);

    $user = $db->single('users',[
        'username' => $_POST['username'],
        'password' => md5($_POST['password']),
    ]);

    if($user)
    {
        $employee = $db->single('employees',[
            'user_id' => $user->id
        ]);
        $group = $db->single('groups',[
            'id' => $employee->group_id
        ]);
        $employee->group = $group;
        $payload = [
            'id'   => $user->id,
            'name' => $user->name,
            'username' => $user->name,
            'employee' => $employee
        ];
        $token = JwtAuth::encode($payload,config('jwt_secret'));
        echo json_encode([
            'status'=>'success',
            'token'=>$token
        ]);
    }
    else
        echo json_encode(['status'=>'fail']);
}

die();