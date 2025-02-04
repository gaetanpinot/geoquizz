<?php

return [

    // token jwt
    'jwt.tempsvalidite' => 3600,
    'jwt.emmeteur' => 'auth',
    'jwt.audience' => 'auth',
    'jwt.key' => getenv('JWT_SECRET_KEY'),
    'jwt.algo' => 'HS512',


];
