<?php

namespace App\Http\Models;

use Auth;
use Eloquent;
use Illuminate\Database\Eloquent\Model;

/**
 * 订单
 * Class Order
 *
 * @package App\Http\Models
 * @mixin Eloquent
 * @property-read mixed $status_label
 */
class Order extends Model
{
	protected $table = 'order';
	protected $primaryKey = 'oid';
	protected $appends = ['status_label'];

	function scopeUid($query)
	{
		return $query->where('user_id', Auth::user()->id);
	}

	function user()
	{
		return $this->hasOne(User::class, 'id', 'user_id');
	}

	function goods()
	{
		return $this->hasOne(Goods::class, 'id', 'goods_id')->withTrashed();
	}

	function coupon()
	{
		return $this->hasOne(Coupon::class, 'id', 'coupon_id')->withTrashed();
	}

	function payment()
	{
		return $this->hasOne(Payment::class, 'oid', 'oid');
	}

	function getOriginAmountAttribute($value)
	{
		return $value/100;
	}

	function setOriginAmountAttribute($value)
	{
		return $this->attributes['origin_amount'] = $value*100;
	}

	function getAmountAttribute($value)
	{
		return $value/100;
	}

	function setAmountAttribute($value)
	{
		return $this->attributes['amount'] = $value*100;
	}
}