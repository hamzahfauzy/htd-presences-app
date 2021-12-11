<?php

$conn = conn();
$db   = new Database($conn);
$success_msg = get_flash_msg('success');

$db->query = "SELECT employees.*, groups.name as group_name FROM employees JOIN groups ON groups.id = employees.group_id";
$datas = $db->exec('all');

return compact('datas','success_msg');