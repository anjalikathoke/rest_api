<?php

namespace App\Repositories\Auth\Interface;

use App\Http\Requests\Auth\AuthDtoRequest;

interface AuthRepositoryInterface
{
    public function add(AuthDtoRequest $data);

    public function update(AuthDtoRequest $data, int $id);

}
