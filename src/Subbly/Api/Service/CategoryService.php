<?php

namespace Subbly\Api\Service;

use Sentry;

use Subbly\Model\Collection;
use Subbly\Model\ProductCategory;
use Subbly\Model\Category;

class CategoryService extends Service
{
    protected $modelClass = 'Subbly\\Model\\Category';

    protected $includableRelationships = array();

    /**
     * Return an empty model
     *
     * @return \Subbly\Model\Category
     *
     * @api
     */
    public function newCategory()
    {
        return new Category();
    }

    /**
     * Get all Category
     *
     * @param array $options
     *
     * @return \Illuminate\Database\Eloquent\Collection
     *
     * @api
     */
    public function all(array $options = array())
    {
        $query = $this->newCollectionQuery($options);

        return new Collection($query);
    }

    /**
     * Find a Category by $id
     *
     * @example
     *     $category = Subbly::api('subbly.category')->find($id);
     *
     * @param integer $id
     * @param array   $options
     *
     * @return \Subbly\Model\Category
     *
     * @api
     */
    public function find($id, array $options = array())
    {
        $query = $this->newQuery($options);
        $query->where('id', '=', $id);

        return $query->firstOrFail();
    }

    /**
     * Create a new Category
     *
     * @example
     *     $category = Subbly\Model\Category;
     *     Subbly::api('subbly.category')->create($category);
     *
     *     Subbly::api('subbly.category')->create(array(
     *         'label'  => 'Men Shoes',
     *         'parent' => 1,
     *     ), 'en');
     *
     * @param array                           $category
     * @param \Subbly\Model\Category|null     $
     *
     * @return \Subbly\Model\ProductCategory
     *
     * @throws \Subbly\Api\Service\Exception
     *
     * @api
     */
    public function create($category, $locale = null)
    {
        if (!$category instanceof Category) {
            $category = new Category($category);
        }

        // set locale
        if( !is_null( $locale ) )
        {
            $category->setFrontLocale( $locale );
        }

        if ($category instanceof Category)
        {
            if ($this->fireEvent('creating', array($category)) === false) return false;

            $category->setCaller($this);
            $category->saveWithTranslation();

            $this->fireEvent('created', array($category));

            $category = $this->find($category->id);

            return $category;
        }

        throw new Exception(sprintf(Exception::CANT_CREATE_MODEL,
            $this->modelClass,
            $this->name()
        ));
    }

    /**
     * Update a Category
     *
     * @example
     *     $category = [Subbly\Model\Category instance];
     *     Subbly::api('subbly.category')->update($category);
     *
     *     Subbly::api('subbly.category')->update($category_id, array(
     *         'label' => 'shoes',
     *         'slug'  => 'shoes',
     *     ), 'en');
     *
     * @return \Subbly\Model\Category
     *
     * @api
     */
    public function update()
    {
        $args     = func_get_args();
        $category = null;

        if (count($args) == 1 && $args[0] instanceof Category) {
            $category = $args[0];
        }
        else if (count($args) == 2 && !empty($args[0]) && is_array($args[1]))
        {
            $category = $this->find($args[0]);
            $category->fill($args[1]);
        }
        else if (count($args) == 3 && !empty($args[0]) && is_array($args[1]) && !empty($args[2]))
        {
            $category = $this->find($args[0]);
            $category->setFrontLocale( $args[2] );
            $category->fill($args[1]);
        }

        if ($category instanceof category)
        {
            if ($this->fireEvent('updating', array($category)) === false) return false;

            $category->setCaller($this);
            $category->saveWithTranslation();

            $this->fireEvent('updated', array($category));

            return $category;
        }

        throw new Exception(sprintf(Exception::CANT_UPDATE_MODEL,
            'Subbly\\Model\\Category',
            $this->name()
        ));
    }

    /**
     * Delete a Category
     *
     * @param \Subbly\Model\Category|string  $category The category_id or the category model
     *
     * @return \Subbly\Model\Category
     *
     * @pi
     */
    public function delete($category)
    {
        if (!is_object($category)) {
            $category = $this->find($category);
        }
        
        if ($category instanceof category)
        {
            if ($this->fireEvent('deleting', array($category)) === false) return false;

            $category->setCaller($this);
            $category->delete($this);

            $this->fireEvent('deleted', array($category));
        }
    }

    /**
     * Set the model position in the database.
     *
     * @param  array  $attributes
     * @return \Subbly\Model\Category
     */
    final public function sort(array $attributes = array())
    {
        $category       = $this->find( $attributes['movingId']  );
        $positionEntity = $this->find( $attributes['movedId'] );

        if ($category instanceof Category)
        {
            if ($this->fireEvent('sorting', array($category)) === false) return false;
            
            $category->setCaller($this);
            $category->{$attributes['type']}( $positionEntity );

            $this->fireEvent('sorted', array($category));

            return $category;
        }
        
        throw new Exception(sprintf(Exception::CANT_UPDATE_MODEL,
            'Subbly\\Model\\Category',
            $this->name()
        ));
    }

    /**
     * Service name
     */
    public function name()
    {
        return 'subbly.category';
    }
}
