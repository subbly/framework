<?php

namespace Subbly\Model;

use Illuminate\Database\Eloquent\Model;

class ProductTranslation extends Model
{
  public $timestamps = false;
    protected $fillable = ['name', 'description'];
    protected $defaultValues = array();
}
