<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;


/**
 * @OA\OpenApi(
 *     @OA\Info(
 *         version="1.0",
 *         title="BulletinBoardApi",
 *     ),
 *     @OA\Server(
 *         description="OpenApi host",
 *         url="/api/v1"
 *     ),
 * ),
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     in="header",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="bearer",
 * )
 */
class ApiController extends Controller
{
    /**
     * ApiController constructor.
     */
    public function __construct()
    {

    }
}
