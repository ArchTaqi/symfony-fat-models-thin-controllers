<?php declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Serializer;
use App\Entity\Post;

/**
 * Class PostController
 * @package App\Controller
 * @Route("/posts", name="_post")
 */
class PostController extends OurAbstractController
{
    public function getEntityName()
    {
        return 'App:Post';
    }

    /**
     * Get entity service manager
     * @return mixed
     */
    public function getServiceManager(){
        return $this->get('');
    }


    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/new", name="_add", methods={"POST"})
     */
    public function createAction(Request $request)
    {
        $post = $this->serialize($request);
        $post = $this->createResource($request, $post);

        return $this->json($post);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/new", name="_add", methods={"POST"})
     */
    public function updateAction(Request $request,Post $entity)
    {
        $this->updateResource($request, $entity);
    }

    /**
     * @param Post $entity
     */
    public function readAction(Post $entity)
    {
    }

    public function listAction(array $filters = [])
    {
    }

    /**
     * @param Post $entity
     * @return Response
     */

    /**
     * @param Post $post
     * @return JsonResponse
     * @Route("/post/{id}", name="_post_delete", methods={"DELETE"})
     */
    public function deleteAction(Post $post)
    {
        $post->setActive(false);
        $this->getDoctrine()->getManager()->flush();
        $this->deleteResource($post);

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }


    private function serialize(Request $request){
        /** @var Serializer $serializer */
        $serializer = $this->get('serializer');
        return $serializer->deserialize($request->getContent(), Post::class, 'json');
    }
}
