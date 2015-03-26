<?php

namespace Subbly\Model;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model implements ModelInterface
{
    use Concerns\SubblyModel;
    use Concerns\Address;

    protected $table = 'user_addresses';

    /**
     * Fields.
     */
    protected $visible = array('id', 'uid', 'name', 'firstname', 'lastname', 'address1', 'address2', 'zipcode', 'city', 'country', 'phone_work', 'phone_home', 'phone_mobile', 'other_informations', 'created_at', 'updated_at');

    protected $fillable = array('name', 'firstname', 'lastname', 'address1', 'address2', 'zipcode', 'city', 'country', 'phone_work', 'phone_home', 'phone_mobile', 'other_informations');

    /**
     * Validations.
     */
    protected $rules = array(
        'user_id'   => 'required|exists:users,id',
        'name'      => 'required',
        'firstname' => 'required',
        'lastname'  => 'required',
        'address1'  => 'required',
        'zipcode'   => 'required',
        'city'      => 'required',
        'country'   => 'required', // 'required|country',
    );

    protected $defaultValues = array();

    /**
     *
     */
    protected function performInsert(\Illuminate\Database\Eloquent\Builder $query, array $options = array())
    {
        // $this->attributes['uid'] = md5(uniqid(mt_rand(), true));
        $this->attributes['uid'] = $this->user->uid;

        parent::performInsert($query, $options);
    }

    /**
     * Relationships.
     */
    public function user()
    {
        return $this->belongsTo('Subbly\\Model\\User');
    }
}
