<?php

namespace App\GraphQL\Queries;

final class MedicalReports
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        return "Hi";
    }
}
