<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Customer
 * 
 * @property int $id
 * @property string $name
 * @property int $tenant_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Tenant $tenant
 * @property Collection|Transaction[] $transactions
 * @property Collection|Voucher[] $vouchers
 *
 * @package App\Models
 */
class Customer extends Model
{
	protected $table = 'customers';

	protected $casts = [
		'tenant_id' => 'int'
	];

	protected $fillable = [
		'name',
		'tenant_id'
	];

	public function tenant()
	{
		return $this->belongsTo(Tenant::class);
	}

	public function transactions()
	{
		return $this->hasMany(Transaction::class);
	}

	public function vouchers()
	{
		return $this->hasMany(Voucher::class);
	}
}
