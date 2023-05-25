<?php
namespace App\Services\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Repositories\Auth\AuthRepository;
use Tymon\JWTAuthExceptions\JWTException;
use App\Http\Requests\Auth\LogoutDtoRequest;


class AuthService
{
    /**
     * Constructor based dependency injection
     *
     * @param AuthRepository $repository
     *
     * @return void
     */
    public function __construct(protected AuthRepository $repository)
    {

    }


    /**
     * create function
     *
     * @param CustomerDtoRequest $data
     * @return array
     */
    public function create(AuthDtoRequest $data){
        try{
            $data->merge(['password' => bcrypt($data->password]);
            return new CustomerResource(
                $this->repository->add($data)
            );
        }catch(Exception $e){
            throw $e;
        }
    }


    /**
     * login function
     *
     * @param CustomerDtoRequest $data
     * @return array
     */
    public function login(AuthDtoRequest $data){
        $input = $data->only('email', 'password');
        $jwt_token = null;

        if (!$jwt_token = JWTAuth::attempt($input)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Email or Password',
            ], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json([
            'success' => true,
            'token' => $jwt_token,
        ]);
    }

    /**
     * update function
     *
     * @param CustomerDtoRequest $data
     * @param int $id
     * @return array
     */
    public function update(AuthDtoRequest $data, int $id){

        try{
            return new CustomerResource(
                $this->repository->update($data,$id)
            );
        }catch(Exception $e){
            throw $e;
        }
    }

    /**
     * Get the customer details
     *
     * @param int $id
     *
     * @return array
     */
    public function getUser(LogoutDtoRequest $data)
    {
        try{
            $user = JWTAuth::authenticate($data->token);

            return response()->json(['user' => $user]);
        }catch(\Exception $e){
            throw $e;
        }
    }

    /**
     * delete by id
     *
     * @return array
     */
    public function logout(LogoutDtoRequest $data)
    {
        try {
            JWTAuth::invalidate($data->token);

            return response()->json([
                'success' => true,
                'message' => 'User logged out successfully'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, the user cannot be logged out'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
