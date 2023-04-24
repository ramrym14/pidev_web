<?php

namespace App\Controller;
use App\Entity\Subjects;
use App\Entity\Courses;
use App\Repository\SubjectsRepository;
use App\Repository\CoursesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
   
    #[Route('/pie-chart', name: 'pie_chart')]
    public function statisticssubjects(SubjectsRepository $subjectsRepository): Response
    {
        // Retrieve all subjects from the database
        $subjects = $subjectsRepository->findAll();

        // Initialize an empty array to store the subject data
        $subjectData = [];

        // Iterate through the subjects and count the number of times each class appears
        foreach ($subjects as $subject) {
            $className = $subject->getClassesEsprit();
            if (!array_key_exists($className, $subjectData)) {
                $subjectData[$className] = 1;
            } else {
                $subjectData[$className]++;
            }
        }

        // Prepare the data for the pie chart by formatting it as an array of arrays
        $chartData = [];
        foreach ($subjectData as $className => $count) {
            $chartData[] = [
                'name' => $className,
                'y' => $count,
            ];
        }

        return $this->render('admin/stats.html.twig', [
            'chartData' => json_encode($chartData),
        ]);
    }




    #[Route('/pie-chartcourse', name: 'pie_chartcourse')]
    public function statisticscourses(CoursesRepository $coursesRepository): Response
    {
        // Retrieve all subjects from the database
        $courses = $coursesRepository->findAll();

        // Initialize an empty array to store the subject data
        $courseData = [];

        // Iterate through the subjects and count the number of times each class appears
        foreach ($courses as $course) {
            $className = $course->getDifficulty();
            if (!array_key_exists($className,   $courseData)) {
                $courseData[$className] = 1;
            } else {
                $courseData[$className]++;
            }
        }

        // Prepare the data for the pie chart by formatting it as an array of arrays
        $chartData = [];
        foreach (  $courseData as $className => $count) {
            $chartData[] = [
                'name' => $className,
                'y' => $count,
            ];
        }

        return $this->render('admin/statscourse.html.twig', [
            'chartData' => json_encode($chartData),
        ]);
    }
}
