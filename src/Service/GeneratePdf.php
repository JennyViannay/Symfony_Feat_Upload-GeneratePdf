<?php

namespace App\Service;

use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\String\Slugger\SluggerInterface;

class GeneratePdf
{
    private $targetDirectory;
    private $templating;
    private $slugger;

    public function __construct($targetDirectory, SluggerInterface $slugger, \Twig\Environment $templating)
    {
        $this->targetDirectory = $targetDirectory;
        $this->slugger = $slugger;
        $this->templating = $templating;
    }

    public function generate($infos)
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        
        // Retrieve the HTML generated in our twig file
        $html = $this->templating->render('default/mypdf.html.twig', [
            'infos' => $infos
        ]);
        
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        
        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Store PDF Binary Data
        $output = $dompdf->output();
        
        // In this case, we want to write the file in the public directory
        $publicDirectory = $this->getTargetDirectory();
        $safeFilename = $this->slugger->slug('Attestation-'.uniqid());
        $pdfFilepath =  $publicDirectory . '/' .$safeFilename .'.pdf';
        
        // Write file to the desired path
        file_put_contents($pdfFilepath, $output);
        
        // Send some text response
        return $safeFilename .'.pdf';
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}