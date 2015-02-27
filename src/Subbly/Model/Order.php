<?php

namespace Subbly\Model;

use Illuminate\Database\Eloquent\Model;

class Order extends Model implements ModelInterface
{
    use Concerns\SubblyModel;

    protected $table = 'orders';

    /**
     * Fields
     */
    protected $visible = array('id', 'uid', 'status', 'total_price','gateway', 'shipping_address_id', 'billing_address_id', 'user', 'products', 'shipping_address', 'billing_address', 'created_at', 'updated_at');
    protected $fillable = array('status', 'user_id', 'total_price', 'gateway', 'shipping_address_id', 'billing_address_id');

    /**
     * Validations
     */
    protected $rules = array(
        'user_id' => 'required',
        'gateway' => 'required'
    );

    protected $defaultValues = array(
        'status'      => self::STATUS_DRAFT,
        'total_price' => 0,
    );

    const STATUS_DRAFT     = 'draft';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_REFUSED   = 'refused';
    const STATUS_WAITING   = 'waiting';
    const STATUS_PAID      = 'paid';
    const STATUS_SENT      = 'sent';


    /**
     *
     */
    protected function performInsert(\Illuminate\Database\Eloquent\Builder $query, array $options = array())
    {
        $this->attributes['uid'] = md5(uniqid(mt_rand(), true));

        parent::performInsert($query, $options);
    }

    /**
     * Relashionship
     */
    public function user()
    {
        return $this->belongsTo('Subbly\\Model\\User', 'user_id');
    }

    public function products()
    {
        return $this->hasMany('Subbly\\Model\\OrderProduct');
    }

    public function shipping_address()
    {
        return $this->belongsTo('Subbly\\Model\\OrderAddress', 'shipping_address_id');
    }

    public function billing_address()
    {
        return $this->belongsTo('Subbly\\Model\\OrderAddress', 'billing_address_id');
    }
}
