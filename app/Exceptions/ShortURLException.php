<?php
declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class ShortURLException extends Exception
{
    // Custom constructor to pass custom message or code
    public function __construct($message = "Short URL exception occurred", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    // Custom method to return a formatted error response
    public function render()
    {
        return response()->json([
            'status' => 'Error',
            'message' => $this->getMessage(),
        ], 400);
    }
}
