<?php

/**
 * Allows you to display certain attributes only for the admin role
 */

namespace App\Serializer;

use App\Entity\Buyer;
use Symfony\Component\HttpFoundation\Request;
use ApiPlatform\Core\Serializer\SerializerContextBuilderInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

final class BuyerContextBuilder implements SerializerContextBuilderInterface
{
    private $decorated;
    private $authorizationChecker;

    public function __construct(SerializerContextBuilderInterface $decorated, AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->decorated = $decorated;
        $this->authorizationChecker = $authorizationChecker;
    }
    
    /**
     * createFromRequest -
     *
     * @param  Request $request
     * @param  bool $normalization
     * @param  array|null $extractedAttributes
     * @return array
     */
    public function createFromRequest(Request $request, bool $normalization, ?array $extractedAttributes = null): array
    {
        $context = $this->decorated->createFromRequest($request, $normalization, $extractedAttributes);
        $resourceClass = $context['resource_class'] ?? null;
        if (
            $resourceClass === Buyer::class
            && isset($context['groups'])
            && $this->authorizationChecker->isGranted('ROLE_ADMIN')
            && true === $normalization
            && $context['operation_type'] === "item"
        ) {
            $context['groups'][] = 'admin:buyer:read';
        }

        if (
            $resourceClass === Buyer::class
            && isset($context['groups'])
            && $this->authorizationChecker->isGranted('ROLE_CUSTOMER')
            && true === $normalization
            && $context['operation_type'] === "item"
        ) {
            $context['groups'][] = 'customer:buyer:read';
        }


        return $context;
    }
}
