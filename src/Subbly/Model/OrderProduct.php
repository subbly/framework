<?php

namespace Subbly\Model;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model implements ModelInterface
{
    use Concerns\SubblyModel;

    /**
     * Fields.
     */
    protected $visible = array('id', 'order_id', 'product_id', 'sku', 'name', 'description', 'price', 'sale_price', 'quantity', 'options', 'product');
    protected $fillable = array('order_id', 'product_id', 'sku', 'name', 'description', 'price', 'sale_price', 'quantity', 'options');

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'order_products';

    /**
     * Validations.
     */
    protected $rules = array(
        'order_id' => 'required',
    );

    protected $defaultValues = array();

    /**
     * Relashionship.
     */
    public function order()
    {
        return $this->belongsTo('Subbly\\Model\\Order', 'order_id');
    }

    public function product()
    {
        return $this->belongsTo('Subbly\\Model\\Product', 'product_id');
    }
}
