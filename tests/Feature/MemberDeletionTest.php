<?php

namespace Tests\Feature;

use App\Models\Borrowing;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MemberDeletionTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_delete_a_member_without_history(): void
    {
        $admin = User::factory()->admin()->create();
        $member = User::factory()->create();

        $this->actingAs($admin)
            ->delete('/admin/members/'.$member->id)
            ->assertRedirect(route('admin.members.index'))
            ->assertSessionHas('status');

        $this->assertDatabaseMissing('users', ['id' => $member->id]);
        $this->assertDatabaseHas('activity_logs', ['action' => 'member.deleted']);
    }

    public function test_admin_cannot_delete_a_member_with_borrowing_history(): void
    {
        $admin = User::factory()->admin()->create();
        $member = User::factory()->create();
        Borrowing::factory()->returned()->create(['user_id' => $member->id]);

        $this->actingAs($admin)
            ->delete('/admin/members/'.$member->id)
            ->assertRedirect()
            ->assertSessionHas('error');

        $this->assertDatabaseHas('users', ['id' => $member->id]);
        $this->assertDatabaseHas('borrowings', ['user_id' => $member->id]);
        $this->assertDatabaseMissing('activity_logs', ['action' => 'member.deleted']);
    }

    public function test_admin_cannot_delete_another_admin_through_the_endpoint(): void
    {
        $admin = User::factory()->admin()->create();
        $otherAdmin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->delete('/admin/members/'.$otherAdmin->id)
            ->assertNotFound();

        $this->assertDatabaseHas('users', ['id' => $otherAdmin->id]);
    }

    public function test_member_cannot_delete_accounts(): void
    {
        $member = User::factory()->create();
        $victim = User::factory()->create();

        $this->actingAs($member)
            ->delete('/admin/members/'.$victim->id)
            ->assertForbidden();

        $this->assertDatabaseHas('users', ['id' => $victim->id]);
    }

    public function test_member_detail_page_renders_the_delete_action(): void
    {
        $admin = User::factory()->admin()->create();
        $member = User::factory()->create();

        $this->actingAs($admin)
            ->get('/admin/members/'.$member->id)
            ->assertOk()
            ->assertSee('Hapus akun')
            ->assertSee(route('admin.members.destroy', $member), false);
    }
}
