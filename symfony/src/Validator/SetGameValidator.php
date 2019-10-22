<?php

namespace App\Validator;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;

class SetGameValidator
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

    public function validate()
    {

        $rules = [];


        if ($this->request->get('data') && !self::isAssoc($this->request->request->get("data"))) {
            $rules["data"] = [
                new Assert\Type('array'),
                new Assert\Count(['min' => 1]),
                new Assert\All([
                    $this->getGameRules()
                ]),
            ];
        } else {

            $rules["data"] = [
                $this->getGameRules()
            ];
        }


        $constraint = new Assert\Collection($rules);
        $validator = Validation::createValidator();
        return $validator->validate($this->request->request->all(), $constraint);
    }

    static public function isAssoc(array $arr)
    {
        if (array() === $arr) return false;
        return array_keys($arr) !== range(0, count($arr) - 1);
    }

    private function getGameRules()
    {
        return new Assert\Collection([
            'language' => [
                new Assert\NotBlank(),
                new Assert\Type(['type' => 'string'])
            ],
            'sport' => [
                new Assert\NotBlank(),
                new Assert\Type(['type' => 'string'])
            ],
            'liga' => [
                new Assert\NotBlank(),
                new Assert\Type(['type' => 'string'])
            ],
            'team_first' => [
                new Assert\NotBlank(),
                new Assert\Type(['type' => 'string'])
            ],
            'team_second' => [
                new Assert\NotBlank(),
                new Assert\Type(['type' => 'string'])
            ],
            'start_time' => [
                new Assert\NotBlank(),
                new Assert\DateTime()
            ],
            'source' => [
                new Assert\NotBlank(),
                new Assert\Type(['type' => 'string'])
            ],

        ]);
    }
}