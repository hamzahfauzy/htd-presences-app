<?php

if(request() == 'POST')
{
    $conn  = conn();
    $db    = new Database($conn);
    $auth  = auth('api');

    $pic   = $auth->employee->id.'-'.strtotime('now').'.jpg';
    file_put_contents('../presences/'.$pic, file_get_contents($_POST['pic']));

    $data = [
        'employee_id' => $auth->employee->id,
        'schedule_id' => $_POST['schedule_id'],
        'status'      => 'accepted',
        'pic'         => $pic
    ];
    $presence = $db->insert('presences',$data);
}

die();