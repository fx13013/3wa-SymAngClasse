<?php

namespace App\Doctrine\Extension;

use App\Entity\User;
use App\Entity\Annonce;
use App\Entity\Message;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Security\Core\Security;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;

class CurrentUserExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
{
    protected Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, ?string $operationName = null)
    {
        /** @var User */
        $user = $this->security->getUser()->getStudent();

        if ($resourceClass === Message::class) {
            $rootAlias = $queryBuilder->getAllAliases()[0];
            $queryBuilder->andWhere("$rootAlias.child = :user")
                ->setParameter('user', $user);
        }
    }

    public function applyToItem(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, array $identifiers, ?string $operationName = null, array $context = [])
    {
        /** @var User */
        $user = $this->security->getUser()->getStudent();

        if ($resourceClass === Message::class) {
            $rootAlias = $queryBuilder->getAllAliases()[0];
            $queryBuilder->andWhere("$rootAlias.child = :user")
                ->setParameter('user', $user);
        }
    }
}
