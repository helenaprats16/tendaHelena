<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/seccions', name: 'seccio_')]
class SeccioController
{
    private $seccions = array(
        [
            "codi" => "1",
            "nom" => "Roba",
            "descripcio" => "Secció de roba",
            "any" => "2026",
            "articles" => array("Pantalons", "Camisa", "Jersei", "Jaqueta")
        ],
        [
            "codi" => "2",
            "nom" => "Calçat",
            "descripcio" => "Secció de calçat",
            "any" => "2025",
            "articles" => array("Sabatilles", "Botes", "Sandàlies")
        ],
        [
            "codi" => "3",
            "nom" => "Accessoris",
            "descripcio" => "Secció d'accessoris",
            "any" => "2024",
            "articles" => array("Bossa", "Cinturó", "Barret")
        ],
        [
            "codi" => "4",
            "nom" => "Esports",
            "descripcio" => "Secció d'esports",
            "any" => "2023",
            "articles" => array("Pilota", "Raqueta", "Bicicleta")
        ]
    );



    #[Route('/{codi}', name: 'detall', methods: ['GET'], requirements: ['codi' => '\d+'])]
    public function detall(int $codi): Response
    {
        $resultat = array_filter(
            $this->seccions,
            function ($seccio) use ($codi) {
                return $seccio['codi'] == $codi;
            }
        );

        if (!$resultat) {
            return new Response('No s’ha trobat la secció:' . $codi);

        } else {
            // Torna 1r element
            $seccio = array_shift($resultat);
            $articles = implode(', ', $seccio['articles']);
            $resp = "<h1>{$seccio['nom']}</h1>
                    <ul>
                        <li><strong>Descripció:</strong> {$seccio['descripcio']}</li>
                        <li><strong>Any:</strong> {$seccio['any']}</li>
                        <li><strong>Articles:</strong> $articles</li>
                    </ul>";

            return new Response("<html><body>$resp</body></html>");
        }
    }


}



