<?php

namespace Subbly\Model;

use Illuminate\Database\Eloquent\Model;

class OrderToken extends Model  implements ModelInterface
{
    use Concerns\SubblyModel;

    protected $table = 'order_tokens';

    /**
     * Fields.
     */
    protected $visible = array('token', 'order_id', 'created_at', 'updated_at');

    protected $fillable = array('token', 'order_id');

    /**
     * Validation rules.
     */
    protected $rules = array(
        'token'    => 'required',
        'order_id' => 'required|unique:order_tokens',
    );

    /**
     * Relashionship.
     */
    public function order()
    {
        return $this->belongsTo('Subbly\\Model\\Order');
    }
}
