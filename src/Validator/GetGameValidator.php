<?php

namespace App\Validator;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;

class GetGameValidator
{
    private $request;

    /**
     * GetGameValidator constructor.
     * @param $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function validate(){

        $rules = [];

        if($this->request->query->get('source')){
            $rules["source"] = [
                new Assert\Type(['type' => 'string']),
                new Assert\Length(['max' => 3000]),
            ];
        }

        if($this->request->query->get('from')){
            $rules["from"] = [
                new Assert\DateTime()
            ];
        }

        if($this->request->query->get('to')){
            $rules["to"] = [
                new Assert\DateTime()
            ];
        }

        $constraint = new Assert\Collection($rules);
        $validator = Validation::createValidator();
        return $validator->validate($this->request->query->all(), $constraint);
    }
}