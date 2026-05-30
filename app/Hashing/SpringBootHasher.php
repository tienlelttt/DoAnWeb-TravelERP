<?php

namespace App\Hashing;

use Illuminate\Hashing\BcryptHasher;

class SpringBootHasher extends BcryptHasher
{
    /**
     * Khởi tạo đối tượng băm mật khẩu.
     * Ghi đè chi phí (cost) mặc định thành 10 để khớp với Spring Boot.
     *
     * @param  array  $options
     * @return void
     */
    public function __construct(array $options = [])
    {
        // Spring Boot uses BCrypt with strength (cost) 10 by default
        $options['rounds'] = 10;
        parent::__construct($options);
    }
}
