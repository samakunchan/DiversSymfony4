<?php

namespace App\Controller;

use App\Entity\Profil;
use App\Form\ProfilType;
use App\Repository\ProfilRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/profil")
 */
class ProfilController extends AbstractController
{
    /**
     * @Route("/", name="profil_index", methods="GET")
     * @param ProfilRepository $profilRepository
     * @return Response
     */
    public function index(ProfilRepository $profilRepository): Response
    {
        return $this->render('profil/index.html.twig', ['profils' => $profilRepository->findAll()]);
    }

    /**
     * @Route("/new", name="profil_new", methods="GET|POST")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $profil = new Profil();
        $form = $this->createForm(ProfilType::class, $profil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($profil);
            $em->flush();

            return $this->redirectToRoute('profil_index');
        }

        return $this->render('profil/new.html.twig', [
            'profil' => $profil,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="profil_show", methods="GET")
     * @param Profil $profil
     * @return Response
     */
    public function show(Profil $profil): Response
    {
        return $this->render('profil/show.html.twig', ['profil' => $profil]);
    }

    /**
     * @Route("/{id}/edit", name="profil_edit", methods="GET|POST")
     * @param Request $request
     * @param Profil $profil
     * @return Response
     */
    public function edit(Request $request, Profil $profil): Response
    {
        $form = $this->createForm(ProfilType::class, $profil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('profil_edit', ['id' => $profil->getId()]);
        }

        return $this->render('profil/edit.html.twig', [
            'profil' => $profil,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="profil_delete", methods="DELETE")
     * @param Request $request
     * @param Profil $profil
     * @return Response
     */
    public function delete(Request $request, Profil $profil): Response
    {
        if ($this->isCsrfTokenValid('delete'.$profil->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($profil);
            $em->flush();
        }

        return $this->redirectToRoute('profil_index');
    }


    /**
     * On remplace la méthode new pour tout excécuté avec Ajax
     * @Route("/image", name="image", methods={"POST"}, options={"expose"=true})
     * @param Request $request
     * @param ObjectManager $manager
     * @return JsonResponse
     */
    public function getImage(Request $request, ObjectManager $manager)
    {
        if ($request->isXmlHttpRequest()){
            $profil = new Profil();
            $form = $this->createForm(ProfilType::class, $profil);
            $form->handleRequest($request);

            //Le fichier croppé
            $files = $_FILES['file'];
            $file = new UploadedFile($files['tmp_name'], $files['name'], $files['type']);
            $filename = $this->genUniqName().'.'.$file->guessExtension();
            //$file->move( $this->targetDir(), $filename );
            //$profil->setAvatar($filename);
            //$manager->persist($profil);
            //$manager->flush();
            return new JsonResponse($files);
        }
        return new JsonResponse('La requête ajax s\'est bien déroulé.');
    }

    private function genUniqName()
    {
        return md5(uniqid());
    }

    private function targetDir()
    {
        return $this->getParameter('dossier_upload_dans_serviceyaml');
    }
}
