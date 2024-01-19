<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\Transaction;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VoucherController extends Controller
{
    public function create(Tenant $tenant) {
        return view('vouchers.create', compact('tenant'));
    }

    public function store(Request $request, Tenant $tenant)
    {
        $request->validate([
            'invoice_numbers' => 'required|array',
        ]);

        $invoiceNumbers = $request->input('invoice_numbers');

        foreach ($invoiceNumbers as $index => $number) {
            if (!$number) {
                unset($invoiceNumbers[$index]);
            }
        }

        $transactions = Transaction::whereIn('invoice_number', $invoiceNumbers)->get()->keyBy('invoice_number')->toArray();

        $customerId = null;

        $total_amount = 0;
        $targetTransactionAmountForVoucher = env('TARGET_TRANSACTION_AMOUNT_FOR_VOUCHER', 1000000);
        $voucherAmount = env('VOUCHER_AMOUNT', 10000);
        $voucherDuration = env('VOUCHER_DURATION_IN_DAYS', 90);

        foreach ($invoiceNumbers as $invoiceNumber) {
            $transaction = $transactions[$invoiceNumber] ?? null;

            if ($transaction) {
                if ($transaction['is_used_voucher']) {
                    $transaction['status'] = 'INVOICE TELAH DIGUNAKAN';
                } else {
                    $transaction['status'] = 'OK';
                    $total_amount += $transaction['amount'];
                    $customerId = $transaction['customer_id'];
                }
            } else {
                $transaction['status'] = 'TRANSAKSI TIDAK DITEMUKAN';
                $transaction['invoice_number'] = $invoiceNumber;
            }

            $transactions[] = $transaction;
            unset($transactions[$invoiceNumber]);
        }

        $voucher = null;
        $error = null;

        if ($total_amount >= $targetTransactionAmountForVoucher) {
            // Mulai transaksi
            DB::beginTransaction();

            try {
                $voucher = new Voucher([
                    'code' => $this->generateUniqueVoucherCode($customerId),
                    'amount' => $voucherAmount,
                    'expired_at' => now()->addDay($voucherDuration),
                    'is_redeemed' => false,
                    'tenant_id' => $tenant->id,
                    'customer_id' => $customerId,
                ]);

                $voucher->save();

                foreach ($invoiceNumbers as $invoiceNumber) {
                    $transaction = Transaction::where('invoice_number', $invoiceNumber)->first();
                    if ($transaction) {
                        $transaction->voucher_id = $voucher->id;
                        $transaction->is_used_voucher = true;
                        $transaction->save();
                    }
                }

                // Commit transaksi
                $error = "VOUCHER BERHASIL DIBUAT";
                $total_amount = $voucherAmount;
                DB::commit();
            } catch (\Exception $e) {
                // Rollback transaksi jika ada kesalahan
                DB::rollBack();

                // Tangani kesalahan
                $error = "Terjadi kesalahan: " . $e->getMessage();
            }
        } else {
            $error = "BELUM MENCAPAI TARGET TRANSAKSI UNTUK MENDAPATKAN VOUCHER";
        }

        return response()->json([
            'transactions' => $transactions,
            'voucher' => $voucher,
            'error' => $error,
            'amount' => $total_amount,
        ]);
    }

    private function generateUniqueVoucherCode($customerId)
    {
        $code = rand(10000, 99999);
        return $customerId . $code;
    }

    public function show(Tenant $tenant, Voucher $voucher) {
        return view('vouchers.show', compact('tenant', 'voucher'));
    }

    public function redeem(Tenant $tenant) {
        return view('vouchers.redeem', compact('tenant'));
    }

    public function redeemVoucher(Request $request, Tenant $tenant) {
        $request->validate([
            'code' => 'required',
        ]);

        $voucher = $tenant->vouchers()->where('code', $request->get('code'))->first();

        if ($voucher) {
            if ($voucher->valid()) {
                $voucher->update([
                    'is_redeemed' => true,
                    'expired_at' => now()->subDay(),
                ]);
                return redirect()->back()->with('success', "Voucher berhasil digunakan");
            } else {
                return redirect()->back()->with('error', "Voucher sudah kadaluarsa");
            }
        }

        return redirect()->back()->with('error', "Voucher tidak valid");
    }
}
