<?php

namespace AutoBundle\Controller;

use AutoBundle\Entity\Car;
use AutoBundle\Repository\CarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Car controller.
 *
 *
 */
class CarController extends Controller
{
    /**
     * Lists all car entities.
     *
     * @Route("/{page}", name="car_index", requirements={"page": "\d+"})
     * @param integer $page
     * @Method("GET")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction($page = 1)
    {
        $em = $this->getDoctrine()->getManager();

        /**
         * @var CarRepository
         */
        $carsRepository = $em->getRepository('AutoBundle:Car');
        $cars = $carsRepository->getAllCars($page);
        $limit = 6;
        $maxPages = ceil($cars->count() / $limit);
        $thisPage = $page;
        return $this->render('car/index.html.twig', array(
            'cars' => $cars,
            'maxPages' => $maxPages,
            'thisPage' => $thisPage
        ));
    }

    /**
     * Lists all car entities.
     *
     * @Route("car/index", name="user_car_index")
     * @Method("GET")
     */
    public function indexUserAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cars = $em->getRepository('AutoBundle:Car')->findBy(array('createdBy'=>$this->getUser()));

        return $this->render('car/usercars.html.twig', array(
            'cars' => $cars,
        ));
    }

    /**
     * Creates a new car entity.
     *
     * @Route("car/new", name="car_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $car = new Car();
        $em = $this->getDoctrine()->getManager();
        $makes = $em->getRepository('AutoBundle:Make')->findAll();
        $form = $this->createForm('AutoBundle\Form\CarType', $car, array('makes' => $makes));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $car->setCreatedAt(new \DateTime(null, new \DateTimeZone("UTC")));
            $car->setUpdatedAt(new \DateTime(null, new \DateTimeZone("UTC")));
            $car->setCreatedBy($this->getUser());
            $em->persist($car);
            $em->flush();

            return $this->redirectToRoute('car_show', array('id' => $car->getId()));
        }

        return $this->render('car/new.html.twig', array(
            'car' => $car,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a car entity.
     *
     * @Route("details/{id}", name="car_show")
     * @Method("GET")
     */
    public function showAction(Car $car)
    {
        $deleteForm = $this->createDeleteForm($car);

        return $this->render('car/show.html.twig', array(
            'car' => $car
        ));
    }

    /**
     * Finds and displays a car entity.
     *
     * @Route("car/detailed/{id}", name="car_detailed")
     * @Method("GET")
     */
    public function detailedAction(Car $car)
    {
        $deleteForm = $this->createDeleteForm($car);

        return $this->render('car/detailed.html.twig', array(
            'car' => $car,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing car entity.
     *
     * @Route("car/{id}/edit", name="car_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Car $car)
    {
        $deleteForm = $this->createDeleteForm($car);
        $editForm = $this->createForm('AutoBundle\Form\CarType', $car);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $car->setUpdatedAt(new \DateTime(null, new \DateTimeZone("UTC")));
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_car_index');
        }

        return $this->render('car/edit.html.twig', array(
            'car' => $car,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a car entity.
     *
     * @Route("car/{id}", name="car_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Car $car)
    {
        $form = $this->createDeleteForm($car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($car);
            $em->flush();
        }

        return $this->redirectToRoute('user_car_index');
    }

    /**
     * Creates a form to delete a car entity.
     *
     * @param Car $car The car entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Car $car)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('car_delete', array('id' => $car->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
