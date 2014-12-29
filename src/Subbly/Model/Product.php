<?php

namespace Subbly\Model;

use Illuminate\Database\Eloquent\Model;

class Product extends Model  implements ModelInterface
{
    use Concerns\SubblyModel;
    use Concerns\Translatable;
    use Concerns\Sortable;

    protected $table = 'products';

    /**
     * Fields
     */
    protected $visible = array('id', 'position', 'status', 'sku', 'name', 'description', 'price', 'sale_price', 'quantity', 'images', 'options', 'categories', 'created_at', 'updated_at');

    protected $fillable = array('status', 'sku', 'name', 'description', 'price', 'sale_price', 'quantity');

    public $sortable = array(
        'order_column_name' => 'position',
    );

    public $translatedAttributes = array( 'name', 'description', 'locale' );

    /**
     * Validation rules
     */
    protected $rules = array(
        'status' => 'required',
        'name'   => 'required',
        'sku'    => 'unique:products,sku,{{self_id}}',
        'price'  => 'required|regex:/^\d+(\.\d{1,2})?$/',
    );

    protected $defaultValues = array(
        'status' => self::STATUS_DRAFT,
    );

    const STATUS_DRAFT      = 'draft';
    const STATUS_ACTIVE     = 'active';
    const STATUS_HIDDEN     = 'hidden';
    const STATUS_SOLDOUT    = 'sold_out';
    const STATUS_COMINGSOON = 'coming_soon';

    /**
     * Get visible fields
     *
     * @return array
     */
    public function getSaveMethod()
    {
        return 'saveWithTranslation';
    }

    /**
     * Relashionship
     */
    public function images()
    {
        return $this->hasMany('Subbly\\Model\\ProductImage');
    }

    public function options()
    {
        return $this->hasMany('Subbly\\Model\\ProductOption');
    }

    public function categories()
    {
        // return $this->hasMany('Subbly\\Model\\ProductCategory');
        return $this->belongsToMany('Subbly\\Model\\Category');
    }

    public function getPriceAttribute()
    {
        return (double) $this->attributes['price'];
    }
    public function getSalePriceAttribute()
    {
        return $this->attributes['sale_price'] === null
            ? null
            : (double) $this->attributes['sale_price']
        ;
    }
}
