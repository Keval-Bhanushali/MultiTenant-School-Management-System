<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Attendance;

class AttendanceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function authenticated_user_can_view_ai_attendance_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get('/attendance/ai');
        $response->assertStatus(200);
        $response->assertSee('AI Attendance');
    }

    /** @test */
    public function attendance_can_be_recorded()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $data = [
            'student_id' => 1,
            'date' => now()->toDateString(),
            'status' => 'present',
        ];
        $response = $this->post('/attendance/store', $data);
        $response->assertStatus(302); // Assuming redirect after store
        $this->assertDatabaseHas('attendances', [
            'student_id' => 1,
            'date' => now()->toDateString(),
            'status' => 'present',
        ]);
    }
}
