<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TransactionDetail
 * 
 * @property int $id
 * @property int $transaction_id
 * @property string $product_name
 * @property int $quantity
 * @property float $unit_price
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Transaction $transaction
 *
 * @package App\Models
 */
class TransactionDetail extends Model
{
	protected $table = 'transaction_details';

	protected $casts = [
		'transaction_id' => 'int',
		'quantity' => 'int',
		'unit_price' => 'float'
	];

	protected $fillable = [
		'transaction_id',
		'product_name',
		'quantity',
		'unit_price'
	];

	public function transaction()
	{
		return $this->belongsTo(Transaction::class);
	}
}
