<?php

namespace Tests\Feature;

use App\Models\Room;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoomCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_room_can_be_created_viewed_updated_and_deleted(): void
    {
        $data = [
            'designacao' => 'Sala-01',
            'capacidade' => 30,
        ];

        // Formulário de criação
        $this->get(route('rooms.create'))
            ->assertOk()
            ->assertSee('Designação')
            ->assertSee('Capacidade');

        // Criação da sala
        $this->post(route('rooms.store'), $data)
            ->assertRedirect(route('rooms.index'));

        $room = Room::firstOrFail();
        $this->assertDatabaseHas('rooms', $data);

        // Listagem das salas
        $this->get(route('rooms.index'))
            ->assertOk()
            ->assertSee('Sala-01')
            ->assertSee('30')
            ->assertSee('Editar')
            ->assertSee('Eliminar');

        // Formulário de edição
        $this->get(route('rooms.edit', $room))
            ->assertOk()
            ->assertSee('Sala-01');

        // Atualização da sala
        $this->put(route('rooms.update', $room), [
            'designacao' => 'Sala-02',
            'capacidade' => 45,
        ])->assertRedirect(route('rooms.index'));

        $this->assertDatabaseHas('rooms', [
            'id_sala' => $room->id_sala,
            'designacao' => 'Sala-02',
            'capacidade' => 45,
        ]);

        // Eliminação da sala
        $this->delete(route('rooms.destroy', $room))
            ->assertRedirect(route('rooms.index'));

        $this->assertDatabaseMissing('rooms', ['id_sala' => $room->id_sala]);
    }
}
