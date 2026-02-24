<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class AdminProfileFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create an admin user
        $this->admin = User::factory()->create([
            'role' => 'admin',
            'name' => 'Test Admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('password123'),
        ]);
    }

    /** @test */
    public function admin_can_view_profile_page()
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.profile'));

        $response->assertStatus(200);
        $response->assertSee($this->admin->name);
        $response->assertSee($this->admin->email);
        $response->assertSee(ucfirst($this->admin->role));
    }

    /** @test */
    public function non_admin_cannot_access_profile_page()
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)
            ->get(route('admin.profile'));

        // Should redirect to dashboard or show 403
        $this->assertTrue(
            $response->status() === 403 || $response->status() === 302
        );
    }

    /** @test */
    public function profile_page_displays_all_tabs()
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.profile'));

        $response->assertStatus(200);
        $response->assertSee('Givings Approved');
        $response->assertSee('Service Registrations');
        $response->assertSee('Group Approvals');
        $response->assertSee('Events Created');
    }

    /** @test */
    public function admin_can_update_profile_information()
    {
        $response = $this->actingAs($this->admin)
            ->from(route('admin.profile'))
            ->put(route('admin.profile.update'), [
                'name' => 'Updated Admin Name',
                'email' => 'updated@test.com',
            ]);

        $response->assertRedirect(route('admin.profile'));

        $this->admin->refresh();
        $this->assertEquals('Updated Admin Name', $this->admin->name);
        $this->assertEquals('updated@test.com', $this->admin->email);
    }

    /** @test */
    public function admin_can_upload_profile_image()
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('profile.jpg');

        $response = $this->actingAs($this->admin)
            ->from(route('admin.profile'))
            ->put(route('admin.profile.update'), [
                'name' => $this->admin->name,
                'email' => $this->admin->email,
                'profile_image' => $file,
            ]);

        $response->assertRedirect(route('admin.profile'));
        
        $this->admin->refresh();
        $this->assertNotNull($this->admin->profile_image);
    }

    /** @test */
    public function admin_can_change_password()
    {
        $response = $this->actingAs($this->admin)
            ->from(route('admin.profile'))
            ->post(route('admin.profile.password'), [
                'current_password' => 'password123',
                'password' => 'newpassword123',
                'password_confirmation' => 'newpassword123',
            ]);

        $response->assertRedirect(route('admin.profile'));

        $this->admin->refresh();
        $this->assertTrue(Hash::check('newpassword123', $this->admin->password));
    }

    /** @test */
    public function profile_page_shows_empty_state_for_no_givings()
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.profile', ['tab' => 'givings']));

        $response->assertStatus(200);
        $response->assertSee('No givings approved yet');
    }

    /** @test */
    public function profile_page_shows_empty_state_for_no_registrations()
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.profile', ['tab' => 'registrations']));

        $response->assertStatus(200);
        $response->assertSee('No registrations approved yet');
    }

    /** @test */
    public function profile_page_shows_empty_state_for_no_events()
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.profile', ['tab' => 'events']));

        $response->assertStatus(200);
        $response->assertSee('No events created yet');
    }

    /** @test */
    public function profile_dropdown_is_accessible_from_dashboard()
    {
        $response = $this->actingAs($this->admin)
            ->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertSee($this->admin->name);
        $response->assertSee('View Profile');
        $response->assertSee('Logout');
    }
}
