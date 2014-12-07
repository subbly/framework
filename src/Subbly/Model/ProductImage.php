<?php

namespace Subbly\Model;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model implements ModelInterface
{
    use Concerns\SubblyModel;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_images';

    /**
    * Fields
    */
    protected $visible = array('filename', 'product', 'created_at', 'updated_at');

    protected $fillable = array('filename', 'image');

    public $sortable = array(
        'order_column_name' => 'position',
    );

    /**
     * Validations
     */
    protected $rules = array(
        'product_id' => 'required|exists:products,id',
        'filename'   => 'required',
        'image'      => 'image',
    );

    /**
     * Relashionship
     */
    public function product()
    {
        return $this->belongsTo('Subbly\\Model\\Product', 'product_id');
    }
}
