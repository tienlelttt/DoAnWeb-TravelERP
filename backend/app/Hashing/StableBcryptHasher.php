<?php

namespace App\Hashing;

use Illuminate\Hashing\BcryptHasher;

// Model lưu thông tin dữ liệu.
class StableBcryptHasher extends BcryptHasher
{
    /**
     * Dùng chi phí băm cố định để bảo đảm mật khẩu được xử lý nhất quán giữa các môi trường.
     */
    public function __construct(array $options = [])
    {
        $options['rounds'] = $options['rounds'] ?? 10;
        parent::__construct($options);
    }
}
