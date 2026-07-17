<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_page_is_available(): void
    {
        $response = $this->get('/register');

        $response->assertOk();
        $response->assertSee('Регистрация');
    }

    public function test_user_can_register_from_form(): void
    {
        $response = $this->post('/register', [
            'first_name' => 'Иван',
            'last_name' => 'Иванов',
            'company' => 'ООО АЙТЕРОСС',
            'email' => 'ivan@example.com',
            'phone' => '+7 (999) 000-00-00',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect('/login');

        $this->assertDatabaseHas('users', [
            'first_name' => 'Иван',
            'last_name' => 'Иванов',
            'company' => 'ООО АЙТЕРОСС',
            'email' => 'ivan@example.com',
            'phone' => '+7 (999) 000-00-00',
        ]);

        $this->assertTrue(User::where('email', 'ivan@example.com')->exists());
    }
}
