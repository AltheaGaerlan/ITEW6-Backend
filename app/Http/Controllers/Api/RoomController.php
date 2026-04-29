<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class RoomController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            Room::withCount('sections')
                ->orderBy('building')
                ->orderBy('room_name')
                ->get()
        );
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'room_name'  => 'required|string|max:20',
            'room_type'  => 'required|string|max:30',
            'capacity'   => 'required|integer|min:1',
            'building'   => 'required|string|max:50',
            'floor'      => 'nullable|integer|min:0',
            'status'     => ['sometimes', 'string', Rule::in(['available', 'occupied', 'maintenance'])],
        ]);

        $this->validateRoomUniqueness($validated['room_name'], $validated['building']);

        $room = Room::create($validated);
        return response()->json($room->loadCount('sections'), 201);
    }

    public function show(int $id): JsonResponse
    {
        return response()->json(
            Room::with('sections')->findOrFail($id)
        );
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $room = Room::findOrFail($id);

        $validated = $request->validate([
            'room_name'  => 'sometimes|string|max:20',
            'room_type'  => 'sometimes|string|max:30',
            'capacity'   => 'sometimes|integer|min:1',
            'building'   => 'sometimes|string|max:50',
            'floor'      => 'nullable|integer|min:0',
            'status'     => ['sometimes', 'string', Rule::in(['available', 'occupied', 'maintenance'])],
        ]);

        $this->validateRoomUniqueness(
            $validated['room_name'] ?? $room->room_name,
            $validated['building'] ?? $room->building,
            $room->room_id
        );

        $room->update($validated);
        return response()->json($room->loadCount('sections'));
    }

    public function destroy(int $id): JsonResponse
    {
        Room::findOrFail($id)->delete();
        return response()->json(['message' => 'Room deleted successfully']);
    }

    // GET /api/v1/rooms/{id}/sections
    public function sections(int $id): JsonResponse
    {
        return response()->json(
            Room::with('sections')->findOrFail($id)->sections
        );
    }

    protected function validateRoomUniqueness(string $roomName, string $building, ?int $ignoreRoomId = null): void
    {
        $query = Room::query()
            ->where('room_name', $roomName)
            ->where('building', $building);

        if ($ignoreRoomId !== null) {
            $query->where('room_id', '!=', $ignoreRoomId);
        }

        if ($query->exists()) {
            throw ValidationException::withMessages([
                'room_name' => ['A room with the same name already exists in this building.'],
            ]);
        }
    }
}
