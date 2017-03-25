<?php

return [

    /* Auth */
    'get-login' => ['GET',  '/', 'login_controller'],
    'post-login' => ['POST',  '/', 'login_controller'],
    'get-logout' => ['GET',  '/logout', 'logout_controller'],

    /* User */
    'get-register-user' => ['GET',  '/user/register', 'register_user_controller'],
    'post-register-user' => ['POST',  '/user/register', 'register_user_controller'],
    'get-update-user' => ['GET',  '/user/update/{id}', 'update_user_controller'],
    'post-update-user' => ['POST',  '/user/update/{id}', 'update_user_controller'],

    /* Dashboard */
    'get-dashboard' => ['GET',  '/dashboard', 'dashboard_controller'],

];
