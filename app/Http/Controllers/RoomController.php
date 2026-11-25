<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RoomController extends Controller
{
    // Lista todas as salas por ordem alfabética da designação
    public function index()
    {
        $rooms = Room::orderBy('designacao')->get();

        return view('admin.rooms.all-rooms.index', compact('rooms'));
    }

    // Mostra o formulário para criar uma sala
    public function create()
    {
        return view('admin.rooms.add-room.index');
    }

    // Guarda uma nova sala
    public function store(Request $request)
    {
        Room::create($request->only([
            'designacao',
            'capacidade',
        ]));

        return redirect()
            ->route('rooms.index')
            ->with('success', 'Sala criada com sucesso.');
    }
    public function show(Room $room)
    {
        return view('admin.rooms.rooms.index', compact('room'));
    }
    // Mostra o formulário para editar uma sala
    public function edit(Room $room)
    {
        return view('admin.rooms.edit-room.index', compact('room'));
    }

    // Atualiza uma sala
    public function update(Request $request, Room $room)
    {
        $room->update($request->only([
            'designacao',
            'capacidade',
        ]));

        return redirect()
            ->route('rooms.index')
            ->with('success', 'Sala atualizada com sucesso.');
    }

    // Elimina uma sala
    public function destroy(Room $room)
    {
        $room->delete();

        return redirect()
            ->route('rooms.index')
            ->with('success', 'Sala eliminada com sucesso.');
    }
}
