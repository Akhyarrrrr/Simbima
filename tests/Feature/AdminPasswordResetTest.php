<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminPasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_reset_user_password(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'mahasiswa']);

        $response = $this
            ->actingAs($admin)
            ->patch(route('admin.users.password.update', $user), [
                'password' => 'password-baru',
                'password_confirmation' => 'password-baru',
            ]);

        $response
            ->assertRedirect()
            ->assertSessionHas('status', 'Password akun berhasil direset.');

        $this->assertTrue(Hash::check('password-baru', $user->refresh()->password));
    }
}
