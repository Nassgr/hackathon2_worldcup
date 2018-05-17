<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Country;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/courses", name="courses")
     */
    public function coursesAction()
    {
        return $this->render('default/courses.html.twig');
    }

    /**
     * @Route("/courses/1", name="course")
     * @Method({"GET", "POST"})
     */
    public function courseAction()
    {
        $em = $this->getDoctrine()->getManager();
        $teams = $em->getRepository('AppBundle:team')->findAll();
        foreach ($teams as $team) {
            $time = date('m:s', rand(0, 3600));
            $team->setTemps($time);
            $em->createQueryBuilder()->update('AppBundle:team', 't')->set('t.temps', $em->createQueryBuilder()->expr()->literal($time))
                ->where('t.id = ?1')
                ->setParameter(1, $team->getId())
                ->getQuery()->execute();
        }
        $teams = $em->getRepository('AppBundle:team')->findBy([], ['countryid' => 'ASC']);
        $teamsPodium = $em->getRepository('AppBundle:team')->findBy([], ['temps' => 'ASC'], 3, 0);
        $winner = $teamsPodium[0];

        if (!empty($_POST['pariCountry'])) {
            $pariCountry = $em->getRepository('AppBundle:Country')->findBy(['name' => $_POST['pariCountry']]);
            $pariCountry = $pariCountry[0];
            return $this->render('default/course.html.twig', ['teams' => $teams, 'teamsPodium' => $teamsPodium, 'winner' => $winner, 'pariCountry' => $pariCountry]);
        }

        return $this->render('default/course.html.twig', ['teams' => $teams, 'teamsPodium' => $teamsPodium, 'winner' => $winner]);
    }
}
