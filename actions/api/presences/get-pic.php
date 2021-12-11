<?php

header('Content-Type: image/jpg');
readfile("../presences/" . $_GET['pic']);
die();