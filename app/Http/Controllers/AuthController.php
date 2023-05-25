<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\Auth\AuthService;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuthExceptions\JWTException;
use App\Http\Requests\Auth\AuthDtoRequest;
use App\Http\Requests\Auth\LogoutDtoRequest;

class AuthController extends Controller
{
    public $token = true;

     /**
     * Constructor based dependency injection
     *
     * @param CustomerService $service
     *
     * @return void
     */
    public function __construct(protected AuthService $service)
    {

    }

    public function register(AuthDtoRequest $request)
    {
        $data = null;
        $status = 'success';

        try{
            $data = $this->service->create(data : $request);
        }catch(Exception $e){
            $status = $e;
        }
    }

    public function login(Request $request)
    {
        $data = null;
        $status = 'success';

        try{
            $data = $this->service->login(data : $request);
        }catch(Exception $e){
            $status = $e;
        }

    }

    public function logout(LogoutDtoRequest $request)
    {
        $data = null;
        $status = 'success';

        try{
            $data = $this->service->logout(data : $request);
        }catch(Exception $e){
            $status = $e;
        }
    }

    public function getUser(LogoutDtoRequest $request)
    {
        $data = null;
        $status = 'success';

        try{
            $data = $this->service->getUser(data : $request);
        }catch(Exception $e){
            $status = $e;
        }

    }
}
