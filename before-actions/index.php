<?php

$route = get_route();

if($route == 'app/db-init')
    if(stringContains(url(),"localhost"))
        return true;
    else
        return false;

if(startWith($route,'api'))
{
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");
    header("Access-Control-Allow-Methods: *");
    header("Content-Type: application/json");

    if(isset($_SERVER["Authorization"]))
    {
        $headers = trim($_SERVER["Authorization"]);
        if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
            $token = $matches[1];
            JwtSession::init($token);
        }
    }
}

// check if installation is exists
$conn  = conn();
$db    = new Database($conn);

$installation = $db->single('application');
if(!$installation && $route != "installation")
{
    header("location:index.php?r=installation");
    die();
}

$auth = auth();
if(!isset($auth->user) && !in_array($route, ['auth/login','installation']) && !startWith($route,'api'))
{
    header("location:index.php?r=auth/login");
    die();
}

if(!startWith($route,'api') && isset($auth->user) && !isset($auth->user->id) && $route != 'auth/logout')
{
    header("location:index.php?r=auth/logout");
    die();
}

// check if route is allowed
if(!startWith($route,'api') && isset($auth->user) && isset($auth->user->id) && !is_allowed($route, $auth->user->id) && $route != 'auth/logout')
{
    return false;
}

return true;