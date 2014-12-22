<?php

namespace Subbly\Model;

use Illuminate\Database\Eloquent\Model;

class OrderAddress extends Model implements ModelInterface
{
    use Concerns\SubblyModel;
    use Concerns\Address;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'order_addresses';

    protected $defaultValues = array();

    /**
     * Relashionship
     */
    public function order()
    {
        return $this->hasOne('Subbly\\Model\\Order');
    }
}
