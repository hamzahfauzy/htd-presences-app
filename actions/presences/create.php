<?php

$conn = conn();
$db   = new Database($conn);
$auth = auth();

if(request() == 'POST')
{
    $pic   = $auth->user->employee->id.'-'.strtotime('now').'.png';
    base64_to_jpeg($_POST['pic'], '../presences/'.$pic);

    $data = [
        'employee_id' => $auth->user->employee->id,
        'schedule_id' => $_POST['schedule_id'],
        'status'      => 'accepted',
        'pic'         => $pic
    ];
    $presence = $db->insert('presences',$data);
    $msg = 'Presensi Berhasil';
    set_flash_msg(['success'=>$msg]);
    echo json_encode(['status' => 'success', 'msg' => $msg]);
    die();
}

$schedules = $db->all('schedules');

return compact('schedules');