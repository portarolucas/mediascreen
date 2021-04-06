<?php
$config = parse_ini_file('../config/db.ini');
$db = new \Illuminate\Database\Capsule\Manager();
$db->addConnection($config);
$db->setAsGlobal();
$db->bootEloquent();