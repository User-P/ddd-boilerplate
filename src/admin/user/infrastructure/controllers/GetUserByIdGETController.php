<?php

namespace Src\admin\user\infrastructure\controllers;

use App\Http\Controllers\Controller;
use Src\admin\user\application\GetUserByIdUseCase;
use Src\admin\user\infrastructure\repositories\EloquentUserRepository;

final class GetUserByIdGETController extends Controller
{

    public function index($id)
    {

        $getUserByIdUseCase = new GetUserByIdUseCase(
            new EloquentUserRepository()
        );

        $user = $getUserByIdUseCase->execute(
            $id
        );

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found',
            ])->setStatusCode(404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $user,
            'message' => 'User retrieved successfully',
        ])->setStatusCode(200);
    }
}
