<?php

namespace App\Validation;

use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator as v;
use Slim\Psr7\Request;

class Validator
{
    private $errors = [];
    public function validate(array $data, array $validateRule)
    {
        /**
         * @var string $key
         * @var v $validator
         */

        foreach ($validateRule as $key => $validator) {
            try {
                $validator->setName($key)->assert($data[$key] ?? null);
            } catch (NestedValidationException $exception) {
                $this->errors[$key] = array_values($exception->getMessages());
            }
        }
    }

    public function getErrors()
    {
        session_start();
        $_SESSION['validateErrors'] = $this->errors;
    }

    public function hasFailed(): bool
    {
        return !empty($this->errors);
    }
}
