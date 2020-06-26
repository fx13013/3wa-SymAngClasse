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
        $user = $this->security->getUser()->getClassroom();

        if ($resourceClass === Annonce::class) {
            $rootAlias = $queryBuilder->getAllAliases()[0];
            $queryBuilder->andWhere("$rootAlias.classroom = :user")
                ->setParameter('user', $user);
        }
    }

    public function applyToItem(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, array $identifiers, ?string $operationName = null, array $context = [])
    {
        $user = $this->security->getUser()->getClassroom();

        if ($resourceClass === Annonce::class) {
            $rootAlias = $queryBuilder->getAllAliases()[0];
            $queryBuilder->andWhere("$rootAlias.classroom = :user")
                ->setParameter('user', $user);
        }
    }
}
