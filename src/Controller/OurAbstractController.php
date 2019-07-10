<?php declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Event\RepositoryEvent;

/**
 * Class OurAbstractController
 * @package App\Controller
 */
abstract class OurAbstractController extends AbstractController
{
    /**
     * Get entity name for CRUD
     * @return string
     */
    abstract public function getEntityName();

    /**
     * Get entity service manager
     * @return mixed
     */
    abstract protected function getServiceManager();

    /**
     * @param string $action
     * @param array  $messages
     * @param array  $messageParams
     *
     * @internal param string $value
     */
    public function setFlash($action, $messages, $messageParams = array())
    {
        $responseMessages = "";
        if (!is_array($messages)) {
            $messages = array($messages);
        }
        foreach ($messages as $message) {
            if ($responseMessages != "") {
                $responseMessages .= "<br/>";
            }
            $responseMessages .= $message. '  '. $messageParams;
        }
        $this->get('session')->getFlashBag()->set($action, $responseMessages);
    }

    /**
     * @param Request $request
     * @param object $entity
     * @param array $validationGroups
     * @return $entity | ConstraintViolationListInterface
     */
    public function createResource(Request $request, $entity, array $validationGroups = [])
    {
        $event = new RepositoryEvent($entity, 'create');
        $this->get('event_dispatcher')->dispatch('okApp.pre_validate', $event);

        $errors = $this->validate($entity, $validationGroups);
        if (count($errors) > 0) {
            return $errors; // TODO: use error validation formatter instead!
        }

        // TODO: add permissions check
        $this->getDoctrine()->getManager()->persist($entity);
        $this->get('event_dispatcher')->dispatch('okApp.pre_flush', $event);
        $this->getDoctrine()->getManager()->flush(); // save changes to already attached entity
        $this->get('event_dispatcher')->dispatch('okApp.post_flush', $event);

        return $entity;
    }
    /**
     * Standard logic for updating resource
     *
     * @param Request $request
     * @param $entity
     * @param array $validationGroups
     * @return mixed
     */
    public function updateResource(Request $request, $entity, array $validationGroups = [])
    {
        $event = new RepositoryEvent($entity, 'update');
        $this->get('event_dispatcher')->dispatch('okApp.pre_validate', $event);

        $errors = $this->validate($entity, $validationGroups);
        if (count($errors) > 0) {
            return $errors; // TODO: use error validation formatter instead!
        }

        $this->getDoctrine()->getManager()->persist($entity);
        // TODO: add support of request passing as variable to check _opt status, add $context to $event for more custom handling
        $this->get('event_dispatcher')->dispatch('okApp.pre_flush', $event);

        // TODO: add validation, permissions check
        $this->getDoctrine()->getManager()->flush(); // save changes to already attached entity

        $this->get('event_dispatcher')->dispatch('okApp.post_flush', $event);
        return $entity;
    }
    /**
     * Standard logic for deletion resource
     *
     * @param $entity
     * @return mixed
     */
    public function deleteResource($entity)
    {
        $this->getDoctrine()->getManager()->remove($entity);
        $event = new RepositoryEvent($entity, 'delete');
        $this->get('event_dispatcher')->dispatch('okApp.pre_validate', $event);
        $this->get('event_dispatcher')->dispatch('okApp.pre_flush', $event);
        $this->getDoctrine()->getManager()->flush(); // save changes to already attached entity
        $this->get('event_dispatcher')->dispatch('okApp.post_flush', $event);

        return $entity;
    }
    /**
     * @param $entity
     * @param array $groups
     * @return ConstraintViolationListInterface
     */
    protected function validate($entity, $groups = null)
    {
        // $groups - empty array must be replaced with NULL. Otherwise none of the validation groups will be checked
        return $this->get('validator')->validate($entity, empty($groups) ? null : $groups);
    }
}
