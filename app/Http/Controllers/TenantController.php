<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TenantController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
        ], [
            'name.required' => 'Nama toko harus diisi.',
        ]);

        $validatedData['owner_id'] = auth()->user()->id;

        Tenant::create($validatedData);

        return redirect()->route('dashboard')->with('success', 'Toko berhasil ditambahkan.');
    }

    public function update(Request $request, Tenant $tenant)
    {
        $validatedData = $request->validate([
            'name' => ['required'],
        ], [
            'name.required' => 'Nama toko harus diisi.',
        ]);

        $tenant->update($validatedData);

        return redirect()->route('tenants.index')->with('success', 'Toko berhasil diperbarui.');
    }

    public function destroy(Tenant $tenant)
    {
        $tenant->delete();
        return redirect()->route('tenants.index')->with('success', 'Toko berhasil dihapus.');
    }
}
