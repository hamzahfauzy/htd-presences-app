<?php

$conn = conn();
$db   = new Database($conn);
$success_msg = get_flash_msg('success');
$query = "  SELECT 
                presences.*, employees.name as employee_name, 
                schedules.name as schedule_name 
            FROM 
                presences 
            JOIN employees ON employees.id=presences.employee_id
            JOIN schedules ON schedules.id=presences.schedule_id
            ORDER BY presences.created_at DESC
        ";
if(have_role(auth()->user->id,'pegawai'))
    $query .= " WHERE presences.employee_id=".auth()->user->employee->id;

$db->query = $query;
$datas = $db->exec('all');

return compact('datas','success_msg');