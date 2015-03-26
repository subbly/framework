<?php

namespace Subbly\Model;

use Illuminate\Database\Eloquent\Model;

class ProductOption extends Model implements ModelInterface
{
    use Concerns\SubblyModel;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_options';

    /**
     * Validations.
     */
    protected $rules = array(
        'product_id' => 'required|exists:products,id',
    );

    protected $defaultValues = array();

    /**
     * Relashionship.
     */
    public function product()
    {
        return $this->belongsTo('Subbly\\Model\\Product', 'product_id');
    }
}
