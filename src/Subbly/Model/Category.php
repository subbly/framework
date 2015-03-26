<?php

namespace Subbly\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model implements ModelInterface
{
    use Concerns\SubblyModel;
    use Concerns\Translatable;
    use Concerns\Sortable;

    protected $table = 'categories';

    /**
     * Fields.
     */
    protected $visible = array('id', 'label', 'slug', 'position', 'parent', 'locale');

    protected $fillable = array('label', 'slug', 'position', 'parent', 'locale');

    public $translatedAttributes = array( 'label', 'slug' );

    protected $dates = ['deleted_at'];

    protected $defaultValues = array();

    /**
     * Validations.
     */
    protected $rules = array(
        'label' => 'required'
      , 'slug'  => 'required',
    );

    /**
     *
     */
//     protected function performInsert(\Illuminate\Database\Eloquent\Builder $query, array $options = array())
//     {
//         // $this->translate('en')->slug = 'abc';
//         // dd( $this );
//         $this->slug = \Str::slug( $this->label );
// // dd( $this->label, $this->attributes );
//         if( isset( $this->parent ) && !is_numeric( $this->parent ) )
//             $this->parent = null;

//         parent::performInsert($query, $options);
//     }

    // /**
    //  * Aliases
    //  */
    // public function setSlugAttribute($value) {
    //     dd('set');
    //     // $this->attributes['first_name'] = (string) $value;
    // }

    /**
     * Relashionship.
     */
    public function products()
    {
        return $this->belongsTo('Subbly\\Model\\Product');
    }

    /**
     * Get visible fields.
     *
     * @return array
     */
    public function getSaveMethod()
    {
        return 'saveWithTranslation';
    }
}
