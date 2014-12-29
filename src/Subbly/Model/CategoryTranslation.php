<?php

namespace Subbly\Model;

use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model
{
  public $timestamps = false;
  protected $fillable = ['label', 'slug'];
}