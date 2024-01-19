<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function index(Tenant $tenant) {
        $transactions = $tenant->transactions()
            ->with('customer')
            ->latest()->paginate(25);

        return view('transactions.index', [
            'tenant' => $tenant,
            'transactions' => $transactions,
        ]);
    }

    public function create(Tenant $tenant)
    {
        $customer = $tenant->customers()->get();
        return view('transactions.create', [
            'tenant' => $tenant,
            'customers' => $customer,
        ]);
    }

    public function store(Request $request, Tenant $tenant)
    {
        try {
            DB::beginTransaction();

            $validator = Validator::make($request->all(), [
                'customer_name' => 'required|string|max:255',
                'product_name' => 'required',
                'product_price' => 'required',
                'product_quantity' => 'required',
                'total_transaction' => 'required|numeric',
            ], [
                'customer_name.required' => 'Nama customer harus diisi.',
                'product_name.required' => 'Nama produk harus diisi.',
                'product_price.required' => 'Harga produk harus diisi.',
                'product_quantity.required' => 'Jumlah produk harus diisi.',
                'total_transaction.required' => 'Total transaksi harus diisi.',
            ]);

            if ($validator->fails()) {
                return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
            }

            $validatedData = $validator->validate();

            foreach ($validatedData['product_name'] as $index => $name) {
                if (!$name) {
                    unset($validatedData['product_name'][$index]);
                    unset($validatedData['product_price'][$index]);
                    unset($validatedData['product_quantity'][$index]);
                }
            }

            $total = 0;
            foreach ($validatedData['product_price'] as $index => $price) {
                $quantity = $validatedData['product_quantity'][$index];
                $total += $price * $quantity;
            }

            $customerName = $validatedData['customer_name'];
            $customer = $tenant->customers()->where('name', $customerName)->first();
            if (!$customer) {
                $customer = $tenant->customers()->create([
                    'name' => $customerName,
                    'phone_number' => null,
                ]);
            }

            if ($request->get('voucher_code')) {
                $voucher = $tenant->vouchers()->where('code', $request->get('voucher_code'))->first();
                if ($voucher) {
                    if ($voucher->valid()) {
                        $total -= $voucher->amount;
                        $voucher->update([
                            'is_redeemed' => true,
                            'expired_at' => now(),
                        ]);
                    }
                }
            }

            $transaction = Transaction::create([
                'tenant_id' => $tenant->id,
                'customer_id' => $customer->id,
                'invoice_number' => 'INV/' . $tenant->id . '/' . date('YmdHis'),
                'amount' => $total,
            ]);

            foreach ($validatedData['product_name'] as $index => $name) {
                $price = $validatedData['product_price'][$index];
                $quantity = $validatedData['product_quantity'][$index];

                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_name' => $name,
                    'unit_price' => $price,
                    'quantity' => $quantity,
                ]);
            }

            DB::commit();

            return redirect()->route('transactions.index', [
                'tenant' => $tenant,
            ])->with('success', 'Transaksi berhasil ditambahkan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('toast_error', $th->getMessage())->withInput();
        }
    }

    public function invoice(Tenant $tenant, Transaction $transaction) {
        $transactionDetails = $transaction->transaction_details()->get();

        return view('transactions.invoice', [
            'tenant' => $tenant,
            'transaction' => $transaction,
            'transactionDetails' => $transactionDetails,
        ]);
    }
}

