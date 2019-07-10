<?php declare(strict_types=1);

namespace App\Services;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Doctrine\ORM\EntityManager;
use App\Entity\Manager\PostManager;
use App\Entity\Post;

/**
 * Class PostService
 * @package App\Services
 */
class PostService
{
    /**
     * @var PostManager $postManager
     */
    protected $postManager;
    /**
     * @var EventDispatcher $eventDispatcher
     */
    protected $eventDispatcher;
    /**
     * @var
     */
    private $validator;
    /**
     * @var ContainerInterface $container
     */
    protected $container;

    /**
     * SubscriberManager constructor.
     * @param EntityManager $entityManager
     * @param $eventDispatcher
     * @param $container
     * @param $validator
     */
    public function __construct(PostManager $postManager, $eventDispatcher, $container, $validator)
    {
        $this->postManager              = $postManager;
        $this->eventDispatcher = $eventDispatcher;
        $this->container       = $container;
        $this->validator = $validator;
    }

    /**
     * @param Post $post
     */
    public function newPost(Post $post){
        $this->postManager->save($post);
    }
}
