<?php declare(strict_types=1);

namespace App\Entity\Manager;

use Doctrine\ORM\EntityManager;
use App\Repository\PostRepository;
use App\Entity\Post;

/**
 * Class PostManager
 * @package App\Entity\Manager
 */
class PostManager
{
    /**
     * @var EntityManager
     */
    protected $em;
    /**
     * @var PostRepository
     */
    protected $repository;

    /**
     * PostManager constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->repository = $this->em->getRepository('AppBundle:Post');
    }

    /**
     * @param  Post $post
     * @return Post
     */
    public function save(Post $post)
    {
        $this->persistAndFlush($post);

        return $post;
    }

    protected function persistAndFlush($entity)
    {
        $this->em->persist($entity);
        $this->em->flush();
    }
}
