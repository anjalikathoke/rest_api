<?php
namespace App\Services\Auth;
use Exception;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Resources\User\UserResource;
use App\Repositories\Auth\AuthRepository;
use App\Http\Requests\Auth\AuthDtoRequest;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Requests\Auth\AuthUpdateDtoRequest;
use App\Http\Requests\Auth\AuthRegisterDtoRequest;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use App\Http\Requests\Auth\AuthChangePasswordDtoRequest;

class AuthService
{
    protected $repository;

    /**
     * Constructor based dependency injection
     *
     * @param AuthRepository $repository
     *
     * @return void
     */
    public function __construct(AuthRepository $repository)
    {
        $this->repository = $repository;
    }


    /**
     * create function
     *
     * @param AuthRegisterDtoRequest $data
     * @return array
     */
    public function create(AuthRegisterDtoRequest $data){
        try{
            $data->merge(['password' => bcrypt($data->password)]);
            return new UserResource(
                $this->repository->add($data)
            );
        }catch(Exception $e){
            throw $e;
        }
    }


    /**
     * login function
     *
     * @param AuthDtoRequest $data
     * @return array
     */
    public function login(AuthDtoRequest $data){
       // try{
            $input = $data->only('email', 'password');
            $jwt_token = null;
            $expire = \Carbon\Carbon::now()->addDays(7)->timestamp;

            if ($jwt_token = JWTAuth::attempt($input, ['exp' => $expire] )) {
                return [
                    'token' => $jwt_token,
                    'token_type' => 'bearer',
                    'expires_in' => $expire
                ];
            }else{
                throw new Exception ;
            }
       /* }catch(TokenInvalidException $e){
            throw $e;
        }*/
    }

    /**
     * Get the customer details
     *
     * @param int $id
     *
     * @return array
     */
    public function getUser()
    {
        try {
            return new UserResource( JWTAuth::parseToken()->authenticate());
        } catch (JWTException $e) {
            return $e;
        }
    }

    /**
     * logout action
     *
     * @return array
     */
    public function logout()
    {
        // get token
        if(JWTAuth::getToken()){
            throw new JWTException ;
        }

        try {
            return JWTAuth::parseToken()->invalidate();
        }catch(Exception $e){
            throw $e;
        }
    }

    /**
     * refresh token action
     *
     * @return array
     */
    public function refresh()
    {
        try {
            return JWTAuth::refresh();

        }catch(TokenInvalidException $e){
            throw $e;
        }
    }

    /**
     * edit profile function
     *
     * @param AuthUpdateDtoRequest $data
     * @param int $id
     * @return array
     */
    public function update(AuthUpdateDtoRequest $data){

        try{
            return  new UserResource($this->repository->update($data));
        }catch(Exception $e){
            throw $e;
        }
    }

    /**
     * change password function
     *
     * @param AuthChangePasswordDtoRequest $data
     * @param int $id
     * @return array
     */
    public function changePassword(AuthChangePasswordDtoRequest $data){

        try{

            $data = ['password' => bcrypt($data->password)];

            if($this->repository->changePassword($data)){
               // return JWTAuth::refresh();
               return true;
            }

        }catch(Exception $e){
            throw $e;
        }
    }

}
