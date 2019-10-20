<?php

namespace App\Services;

use App\Models\Advert;

class AdvertService extends BaseService
{
    const ITEMS_PER_PAGE = 20;

    /**
     * Create new advert
     *
     * @param string $title
     * @param string $content
     * @param int    $categoryId
     * @param int    $userId
     *
     * @return mixed
     */
    public function createAdvert(string $title, string $content, int $categoryId, int $userId)
    {
        $advert = new Advert;

        $advert->{Advert::FIELD_TITLE} = $title;
        $advert->{Advert::FIELD_CONTENT} = $content;
        $advert->{Advert::FIELD_CATEGORY_ID} = $categoryId;
        $advert->{Advert::FIELD_USER_ID} = $userId;

        if ($advert->save()) {
            return $advert;
        }
        return false;
    }

    /**
     * Update the advert
     *
     * @param string $title
     * @param string $content
     * @param int    $categoryId
     * @param int    $advertId
     *
     * @return mixed
     */
    public function updateAdvert(string $title, string $content, int $categoryId, int $advertId)
    {
        $advert = Advert::find($advertId);

        $advert->{Advert::FIELD_TITLE} = $title;
        $advert->{Advert::FIELD_CONTENT} = $content;
        $advert->{Advert::FIELD_CATEGORY_ID} = $categoryId;

        if ($advert->save()) {
            return $advert;
        }
        return false;
    }

    /**
     * Get the advert
     *
     * @param int $id
     *
     * @return mixed
     */
    public function getAdvert(int $id)
    {
        return Advert::find($id);
    }

    /**
     * Get all adverts
     *
     * @return mixed
     */
    public function getAll()
    {
        return Advert::orderBy(Advert::FIELD_ID, 'desc')->paginate($this::ITEMS_PER_PAGE);
    }

    /**
     * Delete the advert
     *
     * @param int $id
     *
     * @return bool
     */
    public function delete(int $id)
    {
        if ($advert = Advert::find($id)) {
            return $advert->delete();
        }

        return false;
    }


}
