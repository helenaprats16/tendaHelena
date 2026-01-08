<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/seccions', name: 'seccio_')]
class SeccioController extends AbstractController
{
    private $seccions = array(
        [
            "codi" => 1,
            "nom" => "Roba",
            "descripcio" => "Secció de roba",
            "any" => "2026",
            "articles" => array("Pantalons", "Camisa", "Jersei", "Jaqueta")
        ],
        [
            "codi" => 2,
            "nom" => "Calçat",
            "descripcio" => "Secció de calçat",
            "any" => "2025",
            "articles" => array("Sabatilles", "Botes", "Sandàlies")
        ],
        [
            "codi" => 3,
            "nom" => "Accessoris",
            "descripcio" => "Secció d'accessoris",
            "any" => "2024",
            "articles" => array("Bolso", "Cinturó", "Sombrero")
        ],
        [
            "codi" => 4,
            "nom" => "Esports",
            "descripcio" => "Secció d'esports",
            "any" => "2023",
            "articles" => array("Pilota", "Raqueta", "Bicicleta")
        ]
    );

    // Mètode 1: Mostrar detall d'una secció (primera, per evitar conflicte)
    #[Route('/{codi}', name: 'detall', methods: ['GET'], requirements: ['codi' => '\d+'])]
    public function detall(int $codi): Response
    {
        // Buscar la secció amb el codi especificat
        $resultat = array_filter(
            $this->seccions,
            function ($seccio) use ($codi) {
                return $seccio['codi'] == $codi;
            }
        );

        // Si no s'ha trobat la secció
        if (!$resultat) {
            return new Response('No s\'ha trobat la secció amb codi: ' . $codi, 404);
        }

        // Extreu la secció trobada
        $seccio = array_shift($resultat);

        // Renderitzar la plantilla seccio/detall.html.twig
        return $this->render('seccio/detall.html.twig', [
            'seccio' => $seccio
        ]);
    }

    // Mètode 2: Llistat de totes les seccions
    #[Route('', name: 'llistat', methods: ['GET'])]
    public function llistat(): Response
    {
        return $this->render('seccio/llistat.html.twig', [
            'seccions' => $this->seccions
        ]);
    }



}



