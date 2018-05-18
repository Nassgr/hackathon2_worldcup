<?php

namespace AppBundle\Controller;

use AppBundle\Entity\team;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Team controller.
 *
 * @Route("team")
 */
class teamController extends Controller
{
    /**
     * Lists all team entities.
     *
     * @Route("/", name="team_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $teams = $em->getRepository('AppBundle:team')->findAll();

        return $this->render('team/index.html.twig', array(
            'teams' => $teams,
        ));
    }

    /**
     * Creates a new team entity.
     *
     * @Route("/admin/new", name="team_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $team = new Team();
        $form = $this->createForm('AppBundle\Form\teamType', $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($team);
            $em->flush();
            $em->createQueryBuilder()->update('AppBundle:Country', 'c')->set('c.teams', $em->createQueryBuilder()->expr()->literal($team->getId()))
                ->where('c.id = ?1')
                ->setParameter(1, $team->getCountryid())
                ->getQuery()->execute();

            return $this->redirectToRoute('team_show', array('id' => $team->getId()));
        }

        return $this->render('team/new.html.twig', array(
            'team' => $team,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a team entity.
     *
     * @Route("/{id}", name="team_show")
     * @Method("GET")
     */
    public function showAction(Request $request, team $team)
    {

        $id =   $request->get('id');
        $em = $this->getDoctrine()->getManager();

        $players = $em->getRepository('AppBundle:player')->findBy([
            'teamid' => $id
        ]);

        $deleteForm = $this->createDeleteForm($team);

        return $this->render('team/show.html.twig', array(
            'players' => $players,
            'team' => $team,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing team entity.
     *
     * @Route("/{id}/admin/edit", name="team_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, team $team)
    {
        $deleteForm = $this->createDeleteForm($team);
        $editForm = $this->createForm('AppBundle\Form\teamType', $team);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('team_edit', array('id' => $team->getId()));
        }

        return $this->render('team/edit.html.twig', array(
            'team' => $team,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a team entity.
     *
     * @Route("/{id}/admin/delete", name="team_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, team $team)
    {
        $form = $this->createDeleteForm($team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($team);
            $em->flush();
        }

        return $this->redirectToRoute('team_index');
    }

    /**
     * Creates a form to delete a team entity.
     *
     * @param team $team The team entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(team $team)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('team_delete', array('id' => $team->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
