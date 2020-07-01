<?php

namespace App\Doctrine\Extension;

use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Security\Core\Security;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use App\Entity\Child;

class CurrentTeacherChildExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
{
    protected Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, ?string $operationName = null)
    {
        if ($resourceClass !== Child::class || !$this->security->isGranted('ROLE_PROF')) {
            return;
        }

        $child = $this->security->getUser()->getClassroom();

        if ($resourceClass === Child::class) {
            $rootAlias = $queryBuilder->getAllAliases()[0];
            $queryBuilder->andWhere("$rootAlias.classroom = :child")
                ->setParameter('child', $child);
        }
    }

    public function applyToItem(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, array $identifiers, ?string $operationName = null, array $context = [])
    {
        if ($resourceClass !== Child::class || $this->security->isGranted('ROLE_PROF')) {
            return;
        }

        $user = $this->security->getUser()->getClassroom();

        if ($resourceClass === Child::class) {
            $rootAlias = $queryBuilder->getAllAliases()[0];
            $queryBuilder->andWhere("$rootAlias.classroom = :user")
                ->setParameter('user', $user);
        }
    }
}
