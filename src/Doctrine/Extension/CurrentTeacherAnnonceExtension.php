<?php

namespace App\Doctrine\Extension;

use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Security\Core\Security;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use App\Entity\Annonce;

class CurrentTeacherAnnonceExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
{
    protected Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, ?string $operationName = null)
    {
        if ($resourceClass !== Annonce::class) {
            return;
        }

        if ($this->security->isGranted('ROLE_PROF')) {
            $classroom = $this->security->getUser()->getClassroom();
        } else {
            $classroom = $this->security->getUser()->getStudent()->getClassroom();
        }

        $rootAlias = $queryBuilder->getAllAliases()[0];
        $queryBuilder->andWhere("$rootAlias.classroom = :classroom")
            ->setParameter('classroom', $classroom);
    }

    public function applyToItem(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, array $identifiers, ?string $operationName = null, array $context = [])
    {
        if ($resourceClass !== Annonce::class) {
            return;
        }

        if ($this->security->isGranted('ROLE_PROF')) {
            $classroom = $this->security->getUser()->getClassroom();
        } else {
            $classroom = $this->security->getUser()->getStudent()->getClassroom();
        }

        $rootAlias = $queryBuilder->getAllAliases()[0];
        $queryBuilder->andWhere("$rootAlias.classroom = :classroom")
            ->setParameter('classroom', $classroom);
    }
}
