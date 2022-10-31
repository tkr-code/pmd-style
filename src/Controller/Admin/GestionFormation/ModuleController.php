<?php

namespace App\Controller\Admin\GestionFormation;

use App\Entity\Module;
use App\Form\ModuleType;
use App\Repository\ModuleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/gestion-formation/module")
 */
class ModuleController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }
    /**
     * @Route("/", name="module_index", methods={"GET"})
     */
    public function index(ModuleRepository $moduleRepository): Response
    {
        #l'utilisateur courant
        $user = $this->getUser();

        return $this->render('admin/gestion_formation/module/index.html.twig', [
            //'modules' => $moduleRepository->findAll(),
            'modules' => $moduleRepository->findBy(['user' => $user->getId()]),
            //'id'=>$user->getID()
        ]);
    }

    /**
     * @Route("/new", name="module_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $user = $this->getUser();

        $module = new Module();
        $form = $this->createForm(ModuleType::class, $module);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $module->setUser($user);
            $this->em->persist($module);
            $this->em->flush();

            $this->addFlash(
                'success',
                'Le Module a été ajouté avec succès'
            );

            return $this->redirectToRoute('module_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/gestion_formation/module/new.html.twig', [
            'module' => $module,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id<\d+>}", name="module_show", methods={"GET"})
     */
    public function show(Module $module): Response
    {
        return $this->render('admin/gestion_formation/module/show.html.twig', [
            'module' => $module,
        ]);
    }

    /**
     * @Route("/{id<\d+>}/edit", name="module_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Module $module): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(ModuleType::class, $module);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $module->setUser($user);
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash(
                'success',
                'Module modifé avec succès'
            );
            return $this->redirectToRoute('module_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/gestion_formation/module/edit.html.twig', [
            'module' => $module,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id<\d+>}/del", name="module_delete", methods={"POST"})
     */
    public function delete(Request $request, Module $module): Response
    {

        if (
            $request->request->get('module') &&
            $request->request->get('module') == 'katoula_yawou' &&
            $request->request->get('supr_module') &&
            !empty($request->request->get('supr_module')) &&
            $request->request->get('supr_module') == $module->getId()
        ) {
            $this->em->remove($module);
            $this->em->flush();

            $response = 'success';
        } else {
            $response = 'failed';
        }
        return new JsonResponse($response);
        //return $this->redirectToRoute('module_index', [], Response::HTTP_SEE_OTHER);
    }
}
