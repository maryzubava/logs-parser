<?php

namespace App\Service\Validator;

use App\DTO\CountFilter;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

final readonly class CountFilterValidator
{
    /**
     * @throws BadRequestHttpException
     */
    public function validate(CountFilter $countFilter): void
    {
        if (null !== $countFilter->statusCode
            && (!is_numeric($countFilter->statusCode)
                || !((int) $countFilter->statusCode > 100 && (int) $countFilter->statusCode < 600))
        ) {
            throw new BadRequestHttpException('Invalid status code.');
        }

        $this->validateDate($countFilter->startDate, 'Y-m-d');
        $this->validateDate($countFilter->endDate, 'Y-m-d');
    }

    private function validateDate(?string $dateString, string $format): void
    {
        if (null === $dateString) {
            return;
        }

        $date = \DateTime::createFromFormat($format, $dateString);

        if (false === $date || $date->format($format) !== $dateString) {
            throw new BadRequestHttpException('Invalid date format.');
        }
    }
}
