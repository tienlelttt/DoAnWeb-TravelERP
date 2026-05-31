<?php

namespace Tests\Feature;

use Tests\TestCase;

class ApiContractCompatibilityTest extends TestCase
{
    public function test_customer_voucher_alias_routes_are_registered(): void
    {
        $this->getJson('/api/khach-hang/vi-voucher')->assertStatus(401);
        $this->getJson('/api/khach-hang/voucher-co-the-doi')->assertStatus(401);
        $this->postJson('/api/khach-hang/ap-voucher', [])->assertStatus(401);
        $this->postJson('/api/khach-hang/doi-diem', [])->assertStatus(401);
    }

    public function test_payment_alias_routes_are_registered(): void
    {
        $this->postJson('/api/thanh-toan/khoi-tao', [])->assertStatus(401);
        $this->postJson('/api/thanh-toan/DDT001/het-han-qr')->assertStatus(401);
        $this->postJson('/api/thanh-toan/DDT001/xac-nhan-chuyen-khoan')->assertStatus(401);
        $this->getJson('/api/thanh-toan/DDT001/ket-qua')->assertStatus(401);
    }

    public function test_admin_alias_routes_are_registered(): void
    {
        $this->getJson('/api/quan-tri/nhat-ky-he-thong')->assertStatus(401);
        $this->postJson('/api/quan-tri/dang-ky-nhan-vien', [])->assertStatus(401);
    }

    public function test_operation_alias_routes_are_registered(): void
    {
        $this->getJson('/api/kinh-doanh/danh-gia')->assertStatus(401);
        $this->postJson('/api/dieu-hanh/phan-cong', [])->assertStatus(401);
        $this->getJson('/api/dieu-hanh/tour/TTT001/doan')->assertStatus(401);
        $this->getJson('/api/dieu-hanh/tour/TTT001/su-co')->assertStatus(401);
        $this->getJson('/api/dieu-hanh/tour/TTT001/chi-phi')->assertStatus(401);
    }
}
