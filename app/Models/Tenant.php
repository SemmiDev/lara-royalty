<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Tenant
 *
 * @property int $id
 * @property string $name
 * @property int $owner_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property User $user
 * @property Collection|Customer[] $customers
 * @property Collection|Transaction[] $transactions
 *
 * @package App\Models
 */
class Tenant extends Model
{
	protected $table = 'tenants';

	protected $casts = [
		'owner_id' => 'int'
	];

	protected $fillable = [
		'name',
		'owner_id'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'owner_id');
	}

	public function customers()
	{
		return $this->hasMany(Customer::class);
	}

    public function vouchers()
    {
        return $this->hasMany(Voucher::class);
    }

	public function transactions()
	{
		return $this->hasMany(Transaction::class);
	}
}
