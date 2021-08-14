<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

trait ApiResponser
{
    private function successfullResponse($data, $code)
    {
        return response()->json($data, $code);
    }

    protected function errorResponse($message, $code)
    {
        return response()->json(['error' => $message, 'code' => $code], $code);
    }

    protected function showAll(Collection $collection, $code = 200)
    {
        return $this->successfullResponse($collection, $code);
    }

    protected function showOne(Model $instance, $code = 200)
    {
        return $this->successfullResponse($instance, $code);
    }

    protected function showMessage($message, $code = 200)
    {
        return $this->successfullResponse(['data' => $message], $code);
    }
}
