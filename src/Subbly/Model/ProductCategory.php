<?php

namespace Subbly\Model;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model implements ModelInterface
{
    use Concerns\SubblyModel;

    protected $table = 'category_product';

    /**
     * Fields.
     */
    // protected $visible = array('name', 'position', 'created_at', 'updated_at');

    protected $fillable = array('product_id', 'category_id');

    // public $sortable = array(
    //     'order_column_name' => 'position',
    // );

    /**
     * Validations.
     */
    protected $rules = array(
        'product_id'  => 'required|exists:products,id',
        'category_id' => 'required',
    );

    protected $defaultValues = array();

    /**
     *
     */
    protected function performInsert(\Illuminate\Database\Eloquent\Builder $query, array $options)
    {
        $this->attributes['uid'] = md5(uniqid(mt_rand(), true));

        parent::performInsert($query, $options);
    }

    /**
     * Relashionship.
     */
    public function parent()
    {
        return $this->belongsTo('Subbly\\Model\\ProductCategory', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('Subbly\\Model\\ProductCategory', 'parent_id');
    }

    public function product()
    {
        return $this->belongsTo('Subbly\\Model\\Product', 'product_id');
    }
}
