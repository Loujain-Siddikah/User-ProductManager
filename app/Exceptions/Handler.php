<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Support\Str;
use App\Traits\JsonResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use App\Exceptions\CustomModelNotFoundException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    use JsonResponseTrait;
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

    }



    public function render($request, Throwable $e)
    {
        if ($e instanceof ModelNotFoundException) {
            return $this->jsonErrorResponse(" {$this->prettyModelNotFound($e)} not found.",404);
        }
        
        if ($e instanceof PermissionDoesNotExist) {
            return $this->jsonErrorResponse(
                'You do not have permission to perform this action.',
                JsonResponse::HTTP_FORBIDDEN
            );
        }

        if ($e instanceof AuthorizationException) {
            return  $this->jsonErrorResponse( 
                "You are not authorized to perform this action.",
                JsonResponse::HTTP_FORBIDDEN
            );
        }
        
        if ($e instanceof InvalidVerificationCodeException) {
            return  $this->jsonErrorResponse( 
                'Invalid verification code provided.',
                JsonResponse::HTTP_FORBIDDEN
            );
        }

        if ($e instanceof ValidationException) {
            return  $this->jsonErrorResponse( 
                $e->errors(),
                422            
            );
        }
        // if ($e instanceof \Exception) {
        //     return  $this->jsonErrorResponse(
        //         'server error',
        //         500);
        // }
        return parent::render($request, $e);
    }

    private function prettyModelNotFound(ModelNotFoundException $exception): string
    {
        if (! is_null($exception->getModel())) {
            return Str::lower(ltrim(preg_replace('/[A-Z]/', ' $0', class_basename($exception->getModel()))));
        }

        return 'resource';
    }
}
