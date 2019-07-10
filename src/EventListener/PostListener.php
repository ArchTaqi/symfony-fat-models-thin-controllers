<?php declare(strict_types=1);

namespace App\EventListener;

use App\Event\RepositoryEvent;
use App\Services\PostService;
use App\Entity\Post;

/**
 * Class PostListener
 * @package App\EventListener
 */
class PostListener
{
    /**
     * @var RepositoryEvent
     */
    protected $event;

    /**
     * @var PostService
     */
    private $postService;

    /**
     * PostListener constructor.
     * @param PostService $postService
     */
    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * @param RepositoryEvent $event
     */
    public function preValidate(RepositoryEvent $event)
    {
        if (!$event->getData() instanceof Post) {
            return ;
        }

        /**
         * @var Post $post
         */
        $post = $event->getData();

        switch ($event->getAction()) {
            case 'create':
                $this->postService->newPost($post);
                break;
            case 'update':
                $this->postService->newPost($post);
                break;
            case 'delete':
                break;
            default:
        }
    }

    /**
     * @param RepositoryEvent $event
     */
    public function onPreFlush(RepositoryEvent $event)
    {
        if (!$event->getData() instanceof Post) {
            return ;
        }

        /**
         * @var Post $post
         */
        $post = $event->getData();

        switch ($event->getAction()) {
            case 'create':
                $this->postService->newPost($post);
                break;
            case 'update':
                $this->postService->newPost($post);
                break;
            case 'delete':
                break;
            default:
        }
    }

    /**
     * @param RepositoryEvent $event
     */
    public function onPostFlush(RepositoryEvent $event)
    {
        if (!$event->getData() instanceof Post) {
            return ;
        }

        /**
         * @var Post $post
         */
        $post = $event->getData();

        switch ($event->getAction()) {
            case 'create':
                $this->postService->newPost($post);
                break;
            case 'update':
                $this->postService->newPost($post);
                break;
            case 'delete':
                break;
            default:
        }
    }
}
