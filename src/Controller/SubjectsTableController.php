<?php
namespace App\Controller;
use App\Entity\Subjects;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\SubjectType;
use App\Form\SearchFormType;
use App\Repository\SubjectsRepository ;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Serializer;
use RuntimeException;
use Symfony\Component\Serializer\SerializerInterface as SerializerSerializerInterface;

class SubjectsTableController extends AbstractController
{
    #[Route('/subjects', name: 'app_subjects')]
    public function index(): Response
    {
        return $this->render('admin/subjectsTable.html.twig', [
            'controller_name' => 'subjectsTableController',
        ]);
    }
    
    #[Route('/admin', name: 'search')]
    public function afficherSubject(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $subjects = $em->getRepository(Subjects::class)->findAll();
    
        $form = $this->createForm(SearchFormType::class);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $nameSearchTerm = $form->get('name')->getData();
            $descriptionSearchTerm = $form->get('classes_esprit')->getData();
    
            $qb = $em->createQueryBuilder();
            $qb->select('s')
                ->from(Subjects::class, 's');
    
            if ($nameSearchTerm) {
                $qb->andWhere('s.name LIKE :nameSearchTerm')
                    ->setParameter('nameSearchTerm', '%' . $nameSearchTerm . '%');
            }
    
            if ($descriptionSearchTerm) {
                $qb->andWhere('s.classes_esprit LIKE :descriptionSearchTerm')
                    ->setParameter('descriptionSearchTerm', '%' . $descriptionSearchTerm . '%');
            }
    
            $subjects = $qb->getQuery()->getResult();
    
            // Render a different template with search results
            return $this->render('front/subjects.html.twig', [
                'form' => $form->createView(),
                'bla' => $subjects,
                'subjects' => $subjects,
            ]);
        }
    
        return $this->render('admin/subjectsTable.html.twig', [
            'form' => $form->createView(),
            'bla' => $subjects,
            'subjects' => $subjects,
        ]);
    }
    
    

    #[Route('/addsubject', name: 'addsubject')]

    public function addSubject(Request $request): Response
    {
        $Subject = new Subjects();
        $form = $this->createForm(SubjectType::class, $Subject);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($Subject);
            $em->flush();
            return $this->redirectToRoute('displaySubject');
        } else
            return $this->render('admin/addsubject.html.twig', ['f' => $form->createView()]);
    }
    

    #[Route('/modifiersubject/{id}', name: 'modifiersubject')]

    public function modifiersubject(Request $request, $id): Response
    {

        $subject = $this->getDoctrine()->getManager()->getRepository(Subjects::class)->find($id);
        $form = $this->createForm(SubjectType::class, $subject);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {


            $em = $this->getDoctrine()->getManager();

            $em->flush();

            return $this->redirectToRoute('displaySubject');
        } else
            return $this->render('admin/modifiersubject.html.twig', ['f' => $form->createView()]);
    }

    #[Route('/deletesubject', name: 'deletesubject')]

    public function deletesubject( Request $request) {

        $subject = $this->getDoctrine()->getRepository(Subjects::class)->findOneBy(array('id' => $request->query->get("id")));
        $em = $this->getDoctrine()->getManager();
        $em->remove($subject);
        $em->flush();
        $subjects = $this->getDoctrine()->getManager()->getRepository(Subjects::class)->findAll();
        return $this->render('admin/subjectsTable.html.twig', [
            'bla' => $subjects
        ]);
    }


 


}
