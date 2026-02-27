<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EquipmentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:equipment,name',
            'plate_number' => 'required|string|max:100|unique:equipment,plate_number',
        ]);

        DB::table('equipment')->insert([
            'name' => $request->name,
            'plate_number' => $request->plate_number,
            'status' => 'available',
        ]);

        return redirect()->back()->with('success', '✅ New equipment added successfully!');
    }
}