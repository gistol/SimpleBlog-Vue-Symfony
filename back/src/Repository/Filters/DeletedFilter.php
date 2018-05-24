<?php

namespace App\Repository\Filters;

use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;

class DeletedFilter extends SQLFilter
{
    public function addFilterConstraint(ClassMetadata $targetEntity, $alias): string
    {
        if($targetEntity->hasField('deletedAt')) {
            $date = new \DateTime();

            return $alias . '.deleted_at IS NULL';
        }

        return '';
    }
}
