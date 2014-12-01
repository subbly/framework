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
     * Validations
     */
    protected $rules = array(
        'product_id' => 'required|exists:products,id',
    );

    /**
     * Relashionship
     */
    public function product()
    {
        return $this->belongsTo('Subbly\\Model\\Product', 'product_id');
    }
}
