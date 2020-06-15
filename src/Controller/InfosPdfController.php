<?php

namespace App\Controller;

use App\Entity\InfosPdf;
use App\Form\InfosPdfType;
use App\Repository\InfosPdfRepository;
use App\Service\GeneratePdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/infos/pdf")
 */
class InfosPdfController extends AbstractController
{
    /**
     * @Route("/", name="infos_pdf_index", methods={"GET"})
     */
    public function index(InfosPdfRepository $infosPdfRepository): Response
    {
        return $this->render('infos_pdf/index.html.twig', [
            'infos_pdfs' => $infosPdfRepository->findAll(),
        ]);
    }

    /**
     * @Route("/generate/{id}", name="generate_pdf")
     */
    public function generate(InfosPdf $infosPdf, GeneratePdf $generatePdf): Response
    {
        $pathPdf = $generatePdf->generate($infosPdf);
        $infosPdf->setPdfPath($pathPdf);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($infosPdf);
        $entityManager->flush();

        return $this->render('infos_pdf/show.html.twig', [
            'infos_pdf' => $infosPdf,
        ]);
    }

    /**
     * @Route("/new", name="infos_pdf_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $infosPdf = new InfosPdf();
        $form = $this->createForm(InfosPdfType::class, $infosPdf);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($infosPdf);
            $entityManager->flush();

            return $this->redirectToRoute('infos_pdf_index');
        }

        return $this->render('infos_pdf/new.html.twig', [
            'infos_pdf' => $infosPdf,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="infos_pdf_show", methods={"GET"})
     */
    public function show(InfosPdf $infosPdf): Response
    {
        return $this->render('infos_pdf/show.html.twig', [
            'infos_pdf' => $infosPdf,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="infos_pdf_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, InfosPdf $infosPdf): Response
    {
        $form = $this->createForm(InfosPdfType::class, $infosPdf);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('infos_pdf_index');
        }

        return $this->render('infos_pdf/edit.html.twig', [
            'infos_pdf' => $infosPdf,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="infos_pdf_delete", methods={"DELETE"})
     */
    public function delete(Request $request, InfosPdf $infosPdf): Response
    {
        if ($this->isCsrfTokenValid('delete'.$infosPdf->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($infosPdf);
            $entityManager->flush();
        }

        return $this->redirectToRoute('infos_pdf_index');
    }
}
