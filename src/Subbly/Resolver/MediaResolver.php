<?php

namespace Subbly\Resolver;

use Doctrine\Common\Util\Inflector;

use Symfony\Component\PropertyAccess\PropertyAccess;

use Subbly\Framework\Container;

class MediaResolver
{
    protected $basePath;
    protected $baseSource;
    protected $propertyAccessor;
    protected $basedirs;

    public function __construct(Container $container)
    {
        $this->basePath         = storage_path();
        $this->baseSource       = storage_path() . '/uploads';
        $this->propertyAccessor = PropertyAccess::getPropertyAccessor();
        $this->basedirs         = array();
    }

    /**
    * {@inheritDoc}
    */
    public function supports($model, array $options)
    {
        return null !== $this->getBasename($model, $options);
    }

    /**
    * {@inheritDoc}
    */
    public function getPath($model, array $options)
    {
        $basename = $this->getBasename($model, $options);

        if (null == $basename) {
            return null;
        }

        return $this->basePath . '/' . $basename;
    }

    /**
    * {@inheritDoc}
    */
    public function getSource($model, array $options)
    {
        $basename = $this->getBasename($model, $options);

        if (null == $basename) {
            return null;
        }

        return $this->baseSource . '/' . $basename;
    }

    public function getDirname($model)
    {
        $className = get_class($model);

        if (isset($this->basedirs[$className])) {
            $basedir = $this->basedirs[$className];
        }
        else
        {
            $reflection = new \ReflectionClass($className);
            $basedir = $this->basedirs[$className] = Inflector::tableize($reflection->getShortName());
        }

        $id = sprintf('%012s', $model->id);

        // Format
        //      $basedir / id[0..4] / id[5..8] / id[9..12]
        //      $basedir / 0000 / 0000 / 0001
        return sprintf('%s/%04s/%04s/%04s',
            $basedir,
            substr($id, 0, 4),
            substr($id, 5, 4),
            substr($id, 9, 4)
        );
    }

    public function getBasename($model, array $options)
    {
        $basedir = $this->getDirname($model);

        if (isset($options['dirname'])) {
            return $basedir;
        }

        if (isset($options['filename'])) {
            $basename = $options['filename'];
        }
        else {
            $basename = $this->propertyAccessor->getValue($model, $options['field']);
        }

        if (!$basename) {
            return null;
        }

        return $basedir . '/' . $basename;
    }
}
