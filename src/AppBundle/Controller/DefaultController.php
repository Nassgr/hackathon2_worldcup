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
    public function qualificationAction()
    {
        $em = $this->getDoctrine()->getManager();
        $teams = $em->getRepository('AppBundle:team')->findAll();
        $teams = $this->generateCourse($teams);
        $results = $this->podiumAction();
        if (!empty($results[2])) {
            return $this->render('default/course.html.twig', ['teams' => $teams, 'teamsPodium' => $results[0], 'winner' => $results[1], 'pariCountry' => $results[2]]);
        }
        return $this->render('default/course.html.twig', ['teams' => $teams, 'teamsPodium' => $results[0], 'winner' => $results[1]]);
    }


    public function podiumAction()
    {
        $em = $this->getDoctrine()->getManager();
        $teamsPodium = $em->getRepository('AppBundle:team')->findBy([], ['temps' => 'ASC'], 3, 0);
        $teamsPodium = $this->generateCourse2($teamsPodium);
        $winner = $em->getRepository('AppBundle:team')->findBy([], ['temps2' => 'ASC'], 1, 0);;
        $winner = $winner[0];

        if (!empty($_POST['pariCountry'])) {
            $pariCountry = $em->getRepository('AppBundle:Country')->findBy(['name' => $_POST['pariCountry']]);
            $pariCountry = $pariCountry[0];
            return [$teamsPodium, $winner, $pariCountry];
        }
        return [$teamsPodium, $winner];
    }

    /**
     * @param $teams
     */
    public function generateCourse($teams)
    {
        $em = $this->getDoctrine()->getManager();
        foreach ($teams as $team) {
            $time = $this->generateTime();
            $timeMax = date('m:s', 10000);
            $team->setTemps($time);
            $em->createQueryBuilder()->update('AppBundle:team', 't')
                ->set('t.temps', $em->createQueryBuilder()->expr()->literal($time))
                ->set('t.temps2', $em->createQueryBuilder()->expr()->literal($timeMax))
                ->where('t.id = ?1')
                ->setParameter(1, $team->getId())
                ->getQuery()->execute();

        }
        return $teams;
    }

    /**
     * @param $teams
     */
    public function generateCourse2($teams)
    {
        $em = $this->getDoctrine()->getManager();
        foreach ($teams as $team) {
            $time = $this->generateTime();
            $team->setTemps2($time);
            $em->createQueryBuilder()->update('AppBundle:team', 't')
                ->set('t.temps2', $em->createQueryBuilder()->expr()->literal($time))
                ->where('t.id = ?1')
                ->setParameter(1, $team->getId())
                ->getQuery()->execute();
        }
        return $teams;
    }

    /**
     * @return false|string
     */
    public function generateTime()
    {
        return date('m:s', mt_rand(10, 120));
    }
}
