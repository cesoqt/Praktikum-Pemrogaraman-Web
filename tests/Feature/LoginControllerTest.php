<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_unauthenticated_request_to_buku_redirects_to_login(): void
    {
        $response = $this->get('/buku');

        $response->assertRedirectToRoute('login');
    }

    public function test_login_with_wrong_password_shows_generic_error_and_keeps_email(): void
    {
        $user = User::factory()->create(['password' => 'rahasia123']);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'kata-sandi-salah',
        ]);

        $response->assertSessionHasErrors(['email' => 'Email atau kata sandi salah.'])
            ->assertSessionHasInput('email', $user->email)
            ->assertSessionMissingInput('password');
        $this->assertGuest();
    }

    public function test_valid_credentials_authenticate_user_and_render_book_page(): void
    {
        $user = User::factory()->create(['password' => 'rahasia123']);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'rahasia123',
        ]);

        $response->assertRedirectToRoute('buku.index');
        $this->assertAuthenticatedAs($user);

        $this->get('/buku')
            ->assertOk()
            ->assertSee($user->name)
            ->assertSee('Keluar');
    }

    public function test_logout_invalidates_session_and_blocks_buku_page(): void
    {
        $user = User::factory()->create(['password' => 'rahasia123']);

        $this->actingAs($user)
            ->post('/logout')
            ->assertRedirectToRoute('login');
        $this->assertGuest();

        $this->get('/buku')->assertRedirectToRoute('login');
    }

    public function test_login_form_renders_csrf_token_field(): void
    {
        $this->get('/login')
            ->assertOk()
            ->assertSee('name="_token"', false);
    }
}
