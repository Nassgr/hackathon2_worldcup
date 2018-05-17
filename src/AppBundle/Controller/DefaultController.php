<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
     */
    public function courseAction()
    {
        $em = $this->getDoctrine()->getManager();
        $teams = $em->getRepository('AppBundle:team')->findAll();
        $time = rand(0, 3600);
        $time = date('m:s', $time);
        foreach ($teams as $team) {
            $team->setTime($time);
        }
        return $this->render('default/course.html.twig', ['teams' => $teams]);
    }
}
