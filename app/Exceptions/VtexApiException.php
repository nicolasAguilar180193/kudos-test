<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

class VtexApiException extends Exception
{
    public function __construct(
        string $message = "Error en Vtex API",
        int $code = Response::HTTP_CONFLICT,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

    /**
     * Render the exception as an HTTP response.
     */
    public function render(Request $request): Response
    {
        die($this->getMessage());

        if($request->isJson()) {
            return response()->json(['message' => $this->getMessage()], 500);
        } else {
            return response($this->getMessage(), 500);
        }
    }
}
