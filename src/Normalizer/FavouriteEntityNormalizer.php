<?php

namespace Drupal\favourite\Normalizer;

use Drupal\Core\Entity\EntityManagerInterface;
use Drupal\favourite\Entity\Favourite;
use Drupal\serialization\Normalizer\EntityNormalizer;

/**
 * 为促销活动添加已使用数量
 */
class FavouriteEntityNormalizer extends EntityNormalizer {

    /**
     * The interface or class that this Normalizer supports.
     *
     * @var string
     */
    protected $supportedInterfaceOrClass = Favourite::class;

    public function __construct(EntityManagerInterface $entity_manager) {
        parent::__construct($entity_manager);
    }

    /**
     * {@inheritdoc}
     */
    public function normalize($entity, $format = NULL, array $context = []) {
        $data = parent::normalize($entity, $format, $context);
        /** @var Favourite $entity */
        $favourite = $entity->get('favourite')->entity;
        $data['favourite'] = [$this->serializer->normalize($favourite, $format, $context)];
        return $data;
    }
}