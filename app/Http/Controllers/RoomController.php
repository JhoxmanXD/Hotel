<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoomRequest;
use App\Models\Room;
use App\Models\RoomType;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::with('roomType')->latest()->paginate(15);
        return view('rooms.index', compact('rooms'));
    }

    public function create()
    {
        $roomtypes = RoomType::orderBy('name')->get();
        return view('rooms.create', compact('roomtypes'));
    }

    public function store(RoomRequest $request)
    {
        $data = $request->validated();
        Room::create($data);

        return redirect()
            ->route('rooms.index')
            ->with('success', 'Habitación registrada correctamente.');
    }

    public function show(Room $room)
    {
        $room->load('roomType');
        return view('rooms.show', compact('room'));
    }

    public function edit(Room $room)
    {
        $roomtypes = RoomType::orderBy('name')->get();
        return view('rooms.edit', compact('room','roomtypes'));
    }

    public function update(RoomRequest $request, Room $room)
    {
        $data = $request->validated();
        $room->update($data);

        return redirect()
            ->route('rooms.index')
            ->with('success','Habitación actualizada correctamente.');
    }

    public function destroy(Room $room)
    {
        $room->delete();

        return redirect()
            ->route('rooms.index')
            ->with('success','Habitación eliminada.');
    }
}