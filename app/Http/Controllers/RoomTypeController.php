<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoomTypeRequest;
use App\Models\RoomType;

class RoomTypeController extends Controller
{
    public function index()
    {
        $roomtypes = RoomType::latest()->paginate(15);
        return view('roomtypes.index', compact('roomtypes'));
    }

    public function create()
    {
        return view('roomtypes.create');
    }

    public function store(RoomTypeRequest $request)
    {
        $data = $request->validated();
        RoomType::create($data);

        return redirect()
            ->route('roomtypes.index')
            ->with('success', 'Tipo de habitación registrado correctamente.');
    }

    public function show(RoomType $roomtype)
    {
        return view('roomtypes.show', compact('roomtype'));
    }

    public function edit(RoomType $roomtype)
    {
        return view('roomtypes.edit', compact('roomtype'));
    }

    public function update(RoomTypeRequest $request, RoomType $roomtype)
    {
        $data = $request->validated();
        $roomtype->update($data);

        return redirect()
            ->route('roomtypes.index')
            ->with('success','Tipo de habitación actualizado correctamente.');
    }

    public function destroy(RoomType $roomtype)
    {
        $roomtype->delete();

        return redirect()
            ->route('roomtypes.index')
            ->with('success','Tipo de habitación eliminado.');
    }
}