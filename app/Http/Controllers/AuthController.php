<?php

namespace App\Http\Controllers;

use JWTAuth;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\Auth\AuthService;
use Tymon\JWTAuthExceptions\JWTException;
use App\Http\Requests\Auth\AuthDtoRequest;
use App\Http\Requests\Auth\LogoutDtoRequest;
use App\Http\Requests\Auth\AuthUpdateDtoRequest;
use App\Http\Requests\Auth\AuthRegisterDtoRequest;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use App\Http\Requests\Auth\AuthChangePasswordDtoRequest;

class AuthController extends Controller
{
    protected $service;

     /**
     * Constructor based dependency injection
     *
     * @param CustomerService $service
     *
     * @return void
     */
    public function __construct(AuthService $service)
    {
        $this->service = $service;
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    public function register(AuthRegisterDtoRequest $request)
    {
        $data = null;
        $status = 'success';

        try{

            $data = $this->service->create($request);

        }catch(Exception $e){
            $status = $e;
        }
        $result = array('status' => $status,'data' => $data);
        return response()->json($result);
    }


    public function login(AuthDtoRequest $request)
    {
        $data = null;
        $status = 'success';

        try{
            $data = $this->service->login($request);
        }catch(Exception $e){
            $status = 'Error';
        }
        $result = array('status' => $status,'data' => $data);
        return response()->json($result);

    }

    public function refresh()
    {
        $data = null;
        $status = 'success';

        try{
            $data = $this->service->refresh();
        }catch(TokenInvalidException $e){
            $status = $e;
        }
        $result = array('status' => $status,'data' => $data);
        return response()->json($result);

    }

    public function logout()
    {
        $data = null;
        $status = 'success';

        try{
            $data = $this->service->logout();
        }catch(Exception $e){
            $status = $e;
        }
        $result = array('status' => $status,'data' => $data);
        return response()->json($result);

    }

    public function getUser()
    {
        $data = null;
        $status = 'success';

        try{
            $data = $this->service->getUser();
        }catch(Exception $e){
            $status = $e;
        }

        $result = array('status' => $status,'data' => $data);
        return response()->json($result);
    }

    public function edit_profile(AuthUpdateDtoRequest $request)
    {
        $data = null;
        $status = 'success';

        try{

            $data = $this->service->update($request);

        }catch(Exception $e){
            $status = $e;
        }
        $result = array('status' => $status,'data' => $data);
        return response()->json($result);
    }

    public function change_password(AuthChangePasswordDtoRequest $request)
    {
        $data = null;
        $status = 'success';

        try{

            $data = $this->service->changePassword($request);

        }catch(Exception $e){
            $status = $e;
        }
        $result = array('status' => $status,'data' => $data);
        return response()->json($result);
    }
}
