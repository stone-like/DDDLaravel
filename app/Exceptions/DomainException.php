<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use App\Exceptions\DDDBaseException;

//ValidationErrorをつかって妥協するか
class DomainException extends DDDBaseException
{
}
