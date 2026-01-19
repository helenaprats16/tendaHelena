<?php
namespace App\Controller;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Seccio;
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

    public function __construct(private EntityManagerInterface $gestor)
    {
        $this->repositori = $this->gestor->getRepository(Seccio::class);
    }



    // Mètode 2: Llistat de totes les seccions
    #[Route('', name: 'llistat', methods: ['GET'])]
    public function llistat(): Response
    {
        return $this->render('seccio/llistat.html.twig', [
            'seccions' => $this->seccions
        ]);
    }

    //Mètode 3: Inserir totes les seccions noves que vuiga crear
    #[Route('/afegir', name: 'afegir', methods: ['GET','POST'])]
    public function afegir(): Response
    {
        $seccio = new Seccio();
        $seccio->setNom("Bisuteria");
        $seccio->setDescripcio("Secció de bisuteria");
        $seccio->setAny(2026);
        $seccio->setImatge("imatge.jpg");

        // Indiquem que volem guardar aquest objecte
        $this->gestor->persist($seccio);


        // S’executa la inserció
        $this->gestor->flush();

         return new Response("Seccio " . $seccio->getId() . " creada.");

    }



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



}



