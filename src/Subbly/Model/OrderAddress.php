<?php

namespace Subbly\Model;

use Illuminate\Database\Eloquent\Model;

class OrderAddress extends Model implements ModelInterface
{
    use Concerns\SubblyModel;
    use Concerns\Address;

    /**
     * Fields
     */
    protected $visible = array('id', 'firstname', 'lastname', 'address1', 'address2', 'zipcode', 'city', 'country', 'phone_work', 'phone_home', 'phone_mobile', 'other_informations');
    protected $fillable = array('firstname', 'lastname', 'address1', 'address2', 'zipcode', 'city', 'country', 'phone_work', 'phone_home', 'phone_mobile', 'other_informations');

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'order_addresses';

    protected $defaultValues = array();

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
    public function order()
    {
        return $this->hasOne('Subbly\\Model\\Order');
    }
}
