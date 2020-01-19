<?php
namespace App\Repositories;

use App\Repositories\UserImages\Repository;
use App\UserImages;
use Carbon\Carbon;

/**
 * Class UserImagesRepository
 * @package App\Repositories
 */
class UserImagesRepository implements Repository
{

    /**
     * @var UserImages
     */
    protected $userImages;

    /**
     * UserImagesRepository constructor.
     * @param UserImages $userImages
     */
    public function __construct(UserImages $userImages)
    {
        $this->userImages = $userImages;
    }


    /**
     * add Images
     * @param array $images
     */
    public function addImages($images)
    {
        foreach ($images as $image){
            $data = $image->asArray();
            unset($data['id']);
            $data['user_id'] = auth()->id();
            $data['created_time'] = Carbon::parse('2016-11-26 06:35:50.0 +00:00')->format('Y-m-d H:i:s');
            $this->userImages->updateOrCreate($data);
        }
    }
}
