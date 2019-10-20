<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\Api\v1\ApiRequest;
use App\Http\Requests\Api\v1\Auth\SignInRequest;
use App\Http\Requests\Api\v1\Auth\SignUpRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends ApiController
{
    /**
     * @var UserService
     */
    private $userService;

    /**
     * AuthController constructor.
     *
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        parent::__construct();

        $this->userService = $userService;
    }

    /**
     * Sign in method
     *
     * @param SignInRequest   $request
     *
     * @return mixed
     *
     * @OA\Post(
     *     path="/auth/signin",
     *     tags={"Auth"},
     *     operationId="signin",
     *     summary="Вход в аккаунт",
     *     description="",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     description="Email",
     *                     property="email",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     description="Password",
     *                     property="password",
     *                     type="string"
     *                 ),
     *                 required={"email", "password"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorised",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function signIn(SignInRequest $request)
    {
        return $this->authorization($request);
    }

    /**
     * Sign up method
     *
     * @param SignUpRequest   $request
     *
     * @return mixed
     *
     * @OA\Post(
     *     path="/auth/signup",
     *     tags={"Auth"},
     *     operationId="signup",
     *     summary="Регистрация",
     *     description="",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     description="Name",
     *                     property="name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     description="Email",
     *                     property="email",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     description="Password",
     *                     property="password",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     description="Confirm password",
     *                     property="password_confirmation",
     *                     type="string"
     *                 ),
     *                 required={"name", "email", "password", "password_confirmation"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Invalid request",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorised",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function signUp(SignUpRequest $request)
    {
        if (!$this->userService->createUser($request->{User::FIELD_NAME}, $request->{User::FIELD_EMAIL}, $request->{User::FIELD_PASSWORD})) {
            return response()->jsonResult(
                false,
                ['user' => ['Error creating user']],
                null,
                JsonResponse::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        return $this->authorization($request);
    }

    /**
     * Authorization the user
     *
     * @param ApiRequest $request
     *
     * @return mixed
     */
    private function authorization(ApiRequest $request)
    {
        if (!$this->userService->authorization($request->{User::FIELD_EMAIL}, $request->{User::FIELD_PASSWORD})) {
            return response()->jsonResult(
                false,
                ['Unauthorised'],
                null,
                JsonResponse::HTTP_UNAUTHORIZED
            );
        }

        $user = Auth::user();

        return response()->jsonResult(
            true,
            null,
            [
                'token' => $this->userService->getToken($user),
                'user' => new UserResource($user)
            ],
            JsonResponse::HTTP_OK
        );
    }

}
