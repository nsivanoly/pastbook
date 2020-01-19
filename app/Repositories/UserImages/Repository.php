<?php

namespace App\Repositories\UserImages;

/**
 * Interface Repository
 * @package App\Repositories\UserImages
 */
interface Repository
{

    /**
     * Add images to DB
     *
     * @param array $images
     */
    public function addImages($images);
}
