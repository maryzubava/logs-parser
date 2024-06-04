<?php

namespace App\Service\LogImporter\Validator;

use App\DTO\Log;

interface ValidatorInterface
{
    public function validate(Log $log): void;
}
