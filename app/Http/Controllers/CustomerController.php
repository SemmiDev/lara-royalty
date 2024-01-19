<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Tenant;
use Cassandra\Custom;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CustomerController extends Controller
{
    public function index(Tenant $tenant)
    {
        $customers = $tenant->customers()->latest()->paginate(25);
        return view('customers.index', [
            'customers' => $customers,
            'tenant' => $tenant,
        ]);
    }

    public function store(Request $request, Tenant $tenant)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:customers,name',
        ], [
            'name.required' => 'Username harus diisi.',
            'name.unique' => 'Username sudah digunakan.',
        ]);

        $validatedData['tenant_id'] = $tenant->id;
        Customer::create($validatedData);

        return redirect()->route('customers.index', [
            'tenant' => $tenant
        ])->with('success', 'Customer berhasil ditambahkan.');
    }

    public function destroy(Customer $customer): RedirectResponse
    {
        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Customer berhasil dihapus.');
    }

    public function transactionHistory(Tenant $tenant, Customer $customer) : View
    {
        $transactions = $customer->transactions()->latest()->paginate(25);

        return view('customers.transaction-history', [
            'transactions' => $transactions,
            'tenant' => $tenant,
            'customer' => $customer,
        ]);
    }

    public function voucherHistory(Tenant $tenant, Customer $customer) : View
    {
        $vouchers = $customer->vouchers()->latest()->paginate(25);

        return view('customers.voucher-history', [
            'vouchers' => $vouchers,
            'tenant' => $tenant,
            'customer' => $customer,
        ]);
    }

    public function redeemVoucher(Tenant $tenant, Customer $customer) : View
    {
        $vouchers = $customer->vouchers()->latest()->paginate(25);

        return view('customers.redeem-voucher', [
            'vouchers' => $vouchers,
            'tenant' => $tenant,
            'customer' => $customer,
        ]);
    }
}
