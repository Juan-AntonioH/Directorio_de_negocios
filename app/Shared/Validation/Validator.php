<?php

namespace App\Shared\Validation;

use Psr\Http\Message\ServerRequestInterface;
use Respect\Validation\Exceptions\NestedValidationException;

final class Validator
{
    protected $errors;

    public function validate(ServerRequestInterface $request, array $rules)
    {
        foreach ($rules as $field => $rule) {
            try {
                $rule->setName($field)->assert($request->getParsedBody()[$field]);
            } catch (NestedValidationException $e) {
                $this->errors[$field] = $e->getMessages();
            }
        }

        $_SESSION['errors'] = $this->errors;

        return $this;
    }

    public function failed()
    {
        return !empty($this->errors);
    }
}
