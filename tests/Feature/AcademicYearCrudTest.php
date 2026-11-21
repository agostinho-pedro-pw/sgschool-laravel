<?php

namespace Tests\Feature;

use App\Models\AcademicYear;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AcademicYearCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_academic_year_can_be_created_viewed_updated_and_deleted(): void
    {
        $data = [
            'designation' => '2026/2027',
            'start_date' => '2026-09-01',
            'end_date' => '2027-07-31',
        ];

        $this->get(route('academic-years.create'))
            ->assertOk()
            ->assertSee('Designação')
            ->assertSee('Data de Início')
            ->assertSee('Data de Fim');

        $this->post(route('academic-years.store'), $data)
            ->assertRedirect(route('academic-years.index'));

        $academicYear = AcademicYear::firstOrFail();
        $this->assertDatabaseHas('academic_years', $data);

        $this->get(route('academic-years.index'))
            ->assertOk()
            ->assertSee('2026/2027')
            ->assertSee('Detalhes')
            ->assertSee('Editar')
            ->assertSee('Eliminar');

        $this->get(route('academic-years.show', $academicYear))
            ->assertOk()
            ->assertSee('2026/2027');

        $this->put(route('academic-years.update', $academicYear), [
            'designation' => '2027/2028',
            'start_date' => '2027-09-01',
            'end_date' => '2028-07-31',
        ])->assertRedirect(route('academic-years.index'));

        $this->assertDatabaseHas('academic_years', [
            'id' => $academicYear->id,
            'designation' => '2027/2028',
        ]);

        $this->delete(route('academic-years.destroy', $academicYear))
            ->assertRedirect(route('academic-years.index'));

        $this->assertDatabaseMissing('academic_years', ['id' => $academicYear->id]);
    }
}
