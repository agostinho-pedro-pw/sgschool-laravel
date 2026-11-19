<?php

namespace Tests\Feature;

use App\Models\Enrollment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EnrollmentCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_enrollment_can_be_created_viewed_updated_and_deleted(): void
    {
        $this->get(route('enrollments.create'))
            ->assertOk()
            ->assertSee('Business Informatics')
            ->assertSee('Computer Science and Multimedia Systems')
            ->assertSee('Electronics and Telecommunications');

        $enrollmentData = [
            'fullName' => 'Maria Pedro',
            'dateOfBirth' => '2000-05-10',
            'phone' => '900000000',
            'email' => 'maria@example.com',
            'gender' => 'Feminino',
            'course' => 'informatica-gestao',
        ];

        $this->post(route('enrollments.store'), $enrollmentData)
            ->assertRedirect(route('enrollments.index'));

        $enrollment = Enrollment::firstOrFail();

        $this->assertSame(today()->toDateString(), $enrollment->applicationDate->toDateString());
        $this->assertDatabaseHas('enrollments', [
            'id' => $enrollment->id,
            'status' => 'pending',
        ]);

        $this->get(route('enrollments.show', $enrollment))
            ->assertOk()
            ->assertSee('Business Informatics');
        $this->get(route('enrollments.edit', $enrollment))
            ->assertOk()
            ->assertSee('Editar inscrição');

        $updatedData = array_replace($enrollmentData, ['fullName' => 'Maria Pedro Atualizada']);

        $this->put(route('enrollments.update', $enrollment), $updatedData)
            ->assertRedirect(route('enrollments.index'));

        $this->assertDatabaseHas('enrollments', [
            'id' => $enrollment->id,
            'fullName' => 'Maria Pedro Atualizada',
        ]);

        $this->delete(route('enrollments.destroy', $enrollment))
            ->assertRedirect(route('enrollments.index'));

        $this->assertSoftDeleted('enrollments', ['id' => $enrollment->id]);
    }

    public function test_admin_can_accept_enrollment_and_see_success_alert(): void
    {
        $enrollment = Enrollment::create([
            'fullName' => 'Maria Pedro',
            'dateOfBirth' => '2000-05-10',
            'phone' => '900000000',
            'email' => 'maria@example.com',
            'gender' => 'Feminino',
            'course' => 'informatica-gestao',
            'applicationDate' => today(),
        ]);

        $this->get(route('enrollments.index'))
            ->assertOk()
            ->assertSeeInOrder(['Detalhes', 'Aceitar', 'Eliminar']);

        $this->followingRedirects()
            ->post(route('enrollments.accept', $enrollment))
            ->assertOk()
            ->assertSee('Candidatura aceite com sucesso.');

        $this->assertDatabaseHas('enrollments', [
            'id' => $enrollment->id,
            'status' => 'accepted',
        ]);
    }
}
