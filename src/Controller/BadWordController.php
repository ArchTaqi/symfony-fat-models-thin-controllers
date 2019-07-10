<?php declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use App\Entity\BadWord;

/**
 * Class BadWordController
 * @package App\Controller
 */
class BadWordController extends OurAbstractController
{
    public function getEntityName()
    {
        return 'App:BadWord';
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
     */
    public function createAction(Request $request)
    {
        $entity = new BadWord();
    }

    /**
     * @param BadWord $entity
     * @param Request $request
     */
    public function updateAction(BadWord $entity, Request $request)
    {
        $this->updateResource($request, $entity);
    }

    /**
     * @param BadWord $entity
     */
    public function readAction(BadWord $entity)
    {
    }

    public function listAction(array $filters = [])
    {
    }

    /**
     * @param BadWord $entity
     * @return Response
     */
    public function deleteAction(BadWord $entity)
    {
        $this->deleteResource($entity);
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
