<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Voucher
 *
 * @property int $id
 * @property int $customer_id
 * @property int $tenant_id
 * @property string $code
 * @property float $amount
 * @property Carbon $expired_at
 * @property bool $is_redeemed
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Customer $customer
 * @property Tenant $tenant
 * @property Collection|Transaction[] $transactions
 *
 * @package App\Models
 */
class Voucher extends Model
{
	protected $table = 'vouchers';

	protected $casts = [
		'customer_id' => 'int',
		'tenant_id' => 'int',
		'amount' => 'float',
		'expired_at' => 'datetime',
		'is_redeemed' => 'bool'
	];

	protected $fillable = [
		'customer_id',
		'tenant_id',
		'code',
		'amount',
		'expired_at',
		'is_redeemed'
	];

	public function customer()
	{
		return $this->belongsTo(Customer::class);
	}

	public function tenant()
	{
		return $this->belongsTo(Tenant::class);
	}

	public function transactions()
	{
		return $this->hasMany(Transaction::class);
	}

    public function valid() {
        return !$this->is_redeemed && $this->expired_at->isFuture();
    }
}
