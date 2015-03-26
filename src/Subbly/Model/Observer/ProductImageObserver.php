<?php

namespace Subbly\Model\Observer;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Subbly\Model\ProductImage;
use Subbly\Subbly;

class ProductImageObserver
{
    /**
     *
     */
    public function created(ProductImage $model)
    {
        $this->uploadImage($model);
    }

    /**
     *
     */
    public function updated(ProductImage $model)
    {
        $this->uploadImage($model);
    }

    /**
     *
     */
    private function uploadImage(ProductImage $model)
    {
        if (!$model->imageToUpload instanceof UploadedFile) {
            return;
        }

        $source = Subbly::getContainer()->get('media_resolver')->getSource($model, array(
            'field' => 'filename',
        ));

        $model->imageToUpload->move(dirname($source), $model->filename);
    }
}
