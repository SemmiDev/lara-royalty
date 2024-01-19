<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Transaction
 * 
 * @property int $id
 * @property int $tenant_id
 * @property int $customer_id
 * @property string $invoice_number
 * @property bool|null $is_used_voucher
 * @property int|null $voucher_id
 * @property float $amount
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Customer $customer
 * @property Tenant $tenant
 * @property Voucher|null $voucher
 * @property Collection|TransactionDetail[] $transaction_details
 *
 * @package App\Models
 */
class Transaction extends Model
{
	protected $table = 'transactions';

	protected $casts = [
		'tenant_id' => 'int',
		'customer_id' => 'int',
		'is_used_voucher' => 'bool',
		'voucher_id' => 'int',
		'amount' => 'float'
	];

	protected $fillable = [
		'tenant_id',
		'customer_id',
		'invoice_number',
		'is_used_voucher',
		'voucher_id',
		'amount'
	];

	public function customer()
	{
		return $this->belongsTo(Customer::class);
	}

	public function tenant()
	{
		return $this->belongsTo(Tenant::class);
	}

	public function voucher()
	{
		return $this->belongsTo(Voucher::class);
	}

	public function transaction_details()
	{
		return $this->hasMany(TransactionDetail::class);
	}
}
