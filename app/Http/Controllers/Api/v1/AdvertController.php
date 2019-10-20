<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\Api\v1\Advert\CreateAdvertRequest;
use App\Http\Requests\Api\v1\Advert\DestroyAdvertRequest;
use App\Http\Requests\Api\v1\Advert\UpdateAdvertRequest;
use App\Http\Resources\AdvertCollection;
use App\Http\Resources\AdvertResource;
use App\Models\Advert;
use App\Models\User;
use App\Services\AdvertService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AdvertController extends ApiController
{
    /**
     * @var AdvertService
     */
    private $advertService;

    /**
     * AdvertController constructor.
     *
     * @param AdvertService $advertService
     */
    public function __construct(AdvertService $advertService)
    {
        parent::__construct();

        $this->advertService = $advertService;
    }

    /**
     * Get a list of adverts
     *
     * @return mixed
     * @throws \Exception
     *
     * @OA\Get(
     *     path="/advert",
     *     tags={"Advert"},
     *     operationId="advertList",
     *     summary="Список объявлений",
     *     description="",
     *     @OA\Response(
     *         response=200,
     *         description="List of adverts",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorised",
     *         @OA\JsonContent()
     *     ),
     *     security={
     *       {"bearerAuth": {}}
     *     }
     * )
     */
    public function index()
    {
        return new AdvertCollection($this->advertService->getAll());
    }

    /**
     * Get the advert
     *
     * @param mixed $id
     *
     * @return mixed
     * @throws \Exception
     *
     * @OA\Get(
     *     path="/advert/{id}",
     *     tags={"Advert"},
     *     operationId="advertShow",
     *     summary="Объявление",
     *     description="",
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="advert ID",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="advert",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorised",
     *         @OA\JsonContent()
     *     ),
     *     security={
     *       {"bearerAuth": {}}
     *     }
     * )
     */
    public function show($id)
    {
        if ($advert = $this->advertService->getAdvert((int)$id)) {
            return response()->jsonResult(
                true,
                null,
                new AdvertResource($advert),
                JsonResponse::HTTP_OK
            );
        }

        return response()->jsonResult(
            false,
            ['user' => ['The advert is not found']],
            null,
            JsonResponse::HTTP_UNPROCESSABLE_ENTITY
        );
    }

    /**
     * Create advert
     *
     * @param CreateAdvertRequest      $request
     *
     * @return mixed
     * @throws \Exception
     *
     * @OA\Post(
     *     path="/advert",
     *     tags={"Advert"},
     *     operationId="advertCreate",
     *     summary="Создание объявления",
     *     description="",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                  @OA\Property(
     *                     description="Category ID",
     *                     property="category_id",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     description="Advert title",
     *                     property="title",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     description="Advert text",
     *                     property="content",
     *                     type="string"
     *                 ),
     *                 required={"category_id", "title", "content"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Advert model",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Invalid request",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent()
     *     ),
     *     security={
     *       {"bearerAuth": {}}
     *     }
     * )
     */
    public function store(CreateAdvertRequest $request)
    {
        $advert = $this->advertService->createAdvert(
            $request->{Advert::FIELD_TITLE},
            $request->{Advert::FIELD_CONTENT},
            $request->{Advert::FIELD_CATEGORY_ID},
            Auth::user()->{User::FIELD_ID});

        if ($advert) {
            return response()->jsonResult(
                true,
                null,
                new AdvertResource($advert),
                JsonResponse::HTTP_OK
            );
        }

        return response()->jsonResult(
            false,
            ['user' => ['Error creating advert']],
            null,
            JsonResponse::HTTP_UNPROCESSABLE_ENTITY
        );
    }

    /**
     * Update the advert
     *
     * @param UpdateAdvertRequest   $request
     * @param int                   $id
     *
     * @return mixed
     * @throws \Exception
     *
     * @OA\Put(
     *     path="/advert/{id}",
     *     tags={"Advert"},
     *     operationId="advertUpdate",
     *     summary="Редактирование объявления",
     *     description="",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                  @OA\Property(
     *                     description="Category ID",
     *                     property="category_id",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     description="Advert title",
     *                     property="title",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     description="Advert text",
     *                     property="content",
     *                     type="string"
     *                 ),
     *                 required={"category_id", "title", "content"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Advert model",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Invalid request",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent()
     *     ),
     *     security={
     *       {"bearerAuth": {}}
     *     }
     * )
     */
    public function update(UpdateAdvertRequest $request, int $id)
    {
        $advert = $this->advertService->updateAdvert(
            $request->{Advert::FIELD_TITLE},
            $request->{Advert::FIELD_CONTENT},
            $request->{Advert::FIELD_CATEGORY_ID},
            $id);

        if ($advert) {
            return response()->jsonResult(
                true,
                null,
                new AdvertResource($advert),
                JsonResponse::HTTP_OK
            );
        }

        return response()->jsonResult(
            false,
            ['user' => ['Error updating the advert']],
            null,
            JsonResponse::HTTP_UNPROCESSABLE_ENTITY
        );
    }

    /**
     * Delete the advert
     *
     * @param DestroyAdvertRequest  $request
     * @param int                   $id
     *
     * @return mixed
     * @throws \Exception
     *
     * @OA\Delete(
     *     path="/advert/{id}",
     *     tags={"Advert"},
     *     operationId="advertDelete",
     *     summary="Удаление объявления",
     *     description="",
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Фвмуке ШВ",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent()
     *     ),
     *     security={
     *       {"bearerAuth": {}}
     *     }
     * )
     */
    public function destroy(DestroyAdvertRequest $request, int $id)
    {
        if ($this->advertService->delete($id)) {
            return response()->jsonResult(
                true,
                null,
                null,
                JsonResponse::HTTP_OK
            );
        }

        return response()->jsonResult(
            false,
            ['user' => ['Error deleting the advert']],
            null,
            JsonResponse::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
