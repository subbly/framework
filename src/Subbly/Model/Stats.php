<?php

namespace Subbly\Model;

use Illuminate\Database\Eloquent\Model;

class Stats extends Model implements ModelInterface
{
    use Concerns\SubblyModel;

    protected $table = 'statistics';

    /**
     * Fields
     */
    protected $visible = array('id', 'service', 'period', 'value');
    protected $fillable = array('id', 'service', 'period', 'value');

    /**
     * Validations
     */
    protected $rules = array(
        'service' => 'required',
    );

    protected $defaultValues = array(
        'period' => 'all',
        'value'  => 0,
    );
}
