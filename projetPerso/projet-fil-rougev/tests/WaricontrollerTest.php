<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WaricontrollerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient([],
            ['PHP_AUTH_USER' => 'cheikh',
            'PHP_AUTH_PW' => '1991', ]
        );

        $crawler = $client->request('GET', '/api/partenaires');
        $rep = $client->getResponse();
        $this->assertSame(200, $client->getResponse()->getStatuscode());
    }
    
    public function testCreationPartenaireok()
    {
        $client = static::createClient([],['PHP_AUTH_USER' => 'cheikh','PHP_AUTH_PW' => '1991', ]);
        $crawler = $client->request('POST', '/api/Entreprise',[],[],
        ['CONTENT_TYPE' => 'application/json'],
        '{"raisonSocial": "Diopservice","ninea":"dgggdgg","adress":"Dakar","telephon": 33584140,"username":"Fall888","password":"dem","nom":"Thiam","prenom":"Demba","adresse":"Mbour","telephone": 775841403,"email": "diopgaye45@gmail.com","etat" : "actif"}');
        $rep = $client->getResponse();
        var_dump($rep);
        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }
    
    public function testCreationPartenaireko()
    {
        $client = static::createClient([], ['PHP_AUTH_USER' => 'cheikh','PHP_AUTH_PW' => '1991', ]);
        $crawler = $client->request('POST', '/api/Entreprise',[],[],['CONTENT_TYPE' => 'application/json'],
        '{"raisonSocial": "","ninea":"dgggdgg","adress":"Dakar","telephon":,"username":"Diof55","password":"dem","nom":"Thiam","prenom":"Demba","adresse":"Mbour","telephone": 775841403,"email": "diopgaye45@gmail.com","etat" : "actif"}');
        $rep = $client->getResponse();
        var_dump($rep);
        $this->assertSame(400, $client->getResponse()->getStatusCode());
    }

  /* 
    public function testAddComptBok()
    {
        $client = static::createClient([],
            ['PHP_AUTH_USER' => 'cheikh',
            'PHP_AUTH_PW' => '1991', ]
        );
        $crawler = $client->request('POST', '/api/comptB',[],[],
        ['CONTENT_TYPE' => 'application/json'],
        '{"numeroCompte":"122100042","solde": 10000,"partenaire": "1"}');
        $rep = $client->getResponse();
        var_dump($rep);
        $this->assertSame(201, $client->getResponse()->getStatusCode());
    }
*/
    public function testAddComptB()
    {
        $client = static::createClient([], ['PHP_AUTH_USER' => 'cheikh', 'PHP_AUTH_PW' => '1991']);
        $crawler = $client->request('POST', '/api/comptB', [], [], ['CONTENT_TYPE' => 'application/json'], '{"numeroCompte":"1247856552","solde":,"partenaire": "8"}');
        $rep = $client->getResponse();
        var_dump($rep);
        $this->assertSame(400, $client->getResponse()->getStatusCode());
    }
    
    public function testAddDepotOK()
    {
        $client = static::createClient([], ['PHP_AUTH_USER' => 'diop2019', 'PHP_AUTH_PW' => '2019']);

        $crawler = $client->request('POST', '/api/depot', [], [], ['CONTENT_TYPE' => 'application/json'], '{"montant":100000,"comptb": "3","dateDepot": ""}');
        $rep = $client->getResponse();
        var_dump($rep);
        $this->assertSame(201, $client->getResponse()->getStatusCode());
    }

    
    public function testAddDepotko()
    {
        $client = static::createClient([], ['PHP_AUTH_USER' => 'diop', 'PHP_AUTH_PW' => '2019']);
        $crawler = $client->request('POST', '/api/depot', [], [], ['CONTENT_TYPE' => 'application/json'], '{"montant":,"comptb":"1","dateDepot": "2019-07-29"}');
        $rep = $client->getResponse();
        var_dump($rep);
        $this->assertSame(400, $client->getResponse()->getStatusCode());
    } 
}
