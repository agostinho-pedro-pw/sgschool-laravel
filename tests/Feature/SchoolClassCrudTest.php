<?php

namespace Tests\Feature;

use App\Models\SchoolClass;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SchoolClassCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_school_class_can_be_created_viewed_updated_and_deleted(): void
    {
        $schoolClassData = [
            'nomeTurma' => '10.ª A',
            'anoLetivo' => '2026/2027',
            'classe' => '10.ª',
            'curso' => 'Informática',
            'periodo' => 'manhã',
            'sala' => 'Sala-01',
        ];

        $this->get(route('school-classes.create'))
            ->assertOk()
            ->assertSee('Nome da Classe')
            ->assertSee('Ano Letivo')
            ->assertSee('Informática');

        $this->post(route('school-classes.store'), $schoolClassData)
            ->assertRedirect(route('school-classes.index'));

        $schoolClass = SchoolClass::firstOrFail();

        $this->assertDatabaseHas('school_classes', $schoolClassData);

        $this->get(route('school-classes.index'))
            ->assertOk()
            ->assertSee('10.ª A')
            ->assertSee('2026/2027')
            ->assertSee('Detalhes')
            ->assertSee('Editar')
            ->assertSee('Eliminar');

        $this->get(route('school-classes.show', $schoolClass))
            ->assertOk()
            ->assertSee('Sala-01');

        $this->put(route('school-classes.update', $schoolClass), array_replace($schoolClassData, [
            'nomeTurma' => '10.ª B',
            'periodo' => 'tarde',
        ]))->assertRedirect(route('school-classes.index'));

        $this->assertDatabaseHas('school_classes', [
            'id' => $schoolClass->id,
            'nomeTurma' => '10.ª B',
            'periodo' => 'tarde',
        ]);

        $this->delete(route('school-classes.destroy', $schoolClass))
            ->assertRedirect(route('school-classes.index'));

        $this->assertDatabaseMissing('school_classes', ['id' => $schoolClass->id]);
    }
}
