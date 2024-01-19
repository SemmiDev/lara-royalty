<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index() : View
    {
        $tenants = Tenant::latest()->where('owner_id', auth()->user()->id)->get();
        return view('dashboard', compact('tenants'));
    }
}
