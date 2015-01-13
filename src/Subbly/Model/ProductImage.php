<?php

namespace Subbly\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

// use Symfony\Component\HttpFoundation\File\UploadedFile;
// use Symfony\Component\Filesystem\Filesystem;
// use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

use Subbly\Subbly;

class ProductImage extends Model implements ModelInterface
{
    use Concerns\SubblyModel;
    use Concerns\Sortable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_images';

    /**
    * Fields
    */
    protected $visible = array('filename', 'product', 'created_at', 'updated_at');

    protected $fillable = array('filename');

    public $imageToUpload = null;

    public $sortable = array(
        'order_column_name' => 'position',
    );

    /**
     * Validations
     */
    protected $rules = array(
        'product_id' => 'required|exists:products,id',
        'filename'   => 'required',
    );

    protected $defaultValues = array();

    /**
     *
     */
    public static function boot()
    {
        parent::boot();

        // ProductImage::observe(new Observer\ProductImageObserver);
    }

    /**
     *
     */
    protected function performInsert( \Illuminate\Database\Eloquent\Builder $query, array $options = array() )
    {
        $this->attributes['uid'] = md5(uniqid(mt_rand(), true));

        parent::performInsert($query, $options);
    }

    /**
     * Relashionship
     */
    public function product()
    {
        return $this->belongsTo('Subbly\\Model\\Product', 'product_id');
    }
    
    public function getFilenameAttribute()
    {
        return public_upload( 'product_image/' . $this->attributes['filename'] );
    }
}
