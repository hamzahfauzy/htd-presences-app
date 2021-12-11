<?php

$conn = conn();
$db   = new Database($conn);

$query = "  SELECT 
                presences.*, employees.name as employee_name, 
                schedules.name as schedule_name 
            FROM 
                presences 
            JOIN employees ON employees.id=presences.employee_id
            JOIN schedules ON schedules.id=presences.schedule_id
        ";
$auth = auth('api');
if(have_role($auth->id,'pegawai'))
    $query .= " WHERE presences.employee_id=".$auth->employee->id;

$db->query = $query;
$datas = $db->exec('all');

return compact('datas');