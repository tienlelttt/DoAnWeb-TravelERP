<?php

foreach ([
    __DIR__.'/api/auth.php',
    __DIR__.'/api/public.php',
    __DIR__.'/api/customer.php',
    __DIR__.'/api/payment.php',
    __DIR__.'/api/business.php',
    __DIR__.'/api/finance.php',
    __DIR__.'/api/product.php',
    __DIR__.'/api/operation.php',
    __DIR__.'/api/staff.php',
    __DIR__.'/api/admin.php',
] as $routeFile) {
    require $routeFile;
}
