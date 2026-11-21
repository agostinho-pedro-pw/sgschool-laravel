<?php

namespace Tests\Feature;

use App\Models\Turma;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TurmaCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_turma_can_be_created_viewed_updated_and_deleted(): void
    {
        $turmaData = [
            'nomeTurma' => '10.ª A',
            'anoLetivo' => '2026/2027',
            'classe' => '10.ª',
            'curso' => 'Informática',
            'periodo' => 'manhã',
            'sala' => 'Sala-01',
        ];

        $this->get(route('turmas.create'))
            ->assertOk()
            ->assertSee('Nome da Turma')
            ->assertSee('Ano Letivo')
            ->assertSee('Informática');

        $this->post(route('turmas.store'), $turmaData)
            ->assertRedirect(route('turmas.index'));

        $turma = Turma::firstOrFail();

        $this->assertDatabaseHas('turmas', $turmaData);

        $this->get(route('turmas.index'))
            ->assertOk()
            ->assertSee('10.ª A')
            ->assertSee('2026/2027')
            ->assertSee('Detalhes')
            ->assertSee('Editar')
            ->assertSee('Eliminar');

        $this->get(route('turmas.show', $turma))
            ->assertOk()
            ->assertSee('Sala-01');

        $this->put(route('turmas.update', $turma), array_replace($turmaData, [
            'nomeTurma' => '10.ª B',
            'periodo' => 'tarde',
        ]))->assertRedirect(route('turmas.index'));

        $this->assertDatabaseHas('turmas', [
            'id' => $turma->id,
            'nomeTurma' => '10.ª B',
            'periodo' => 'tarde',
        ]);

        $this->delete(route('turmas.destroy', $turma))
            ->assertRedirect(route('turmas.index'));

        $this->assertDatabaseMissing('turmas', ['id' => $turma->id]);
    }
}
