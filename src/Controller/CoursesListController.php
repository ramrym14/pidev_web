<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Subjects;
use App\Entity\Courses;
use App\Repository\CoursesRepository;
use App\Repository\SubjectsRepository;
use Knp\Component\Pager\PaginatorInterface;

class CoursesListController extends AbstractController
{
    #[Route('/subjects/{subjectId}/courses', name: 'courses_list')]


    public function index(int $subjectId, CoursesRepository $courseRepository, SubjectsRepository $subjectRepository,Request $request,PaginatorInterface $paginator): Response
    {
        $subject = $subjectRepository->find($subjectId);
        if (!$subject) {
            throw $this->createNotFoundException('The subject does not exist');
        }

        $courses = $courseRepository->findBy(['subject' => $subject]);


        $courses = $paginator->paginate(
            $courses, /* query NOT result */
            $request->query->getInt('page', 1),
           1
        );
        return $this->render('front/course.html.twig', [
            'subject' => $subject,
            'courses' => $courses,
        ]);
    }
     
}
    



    
      

    

