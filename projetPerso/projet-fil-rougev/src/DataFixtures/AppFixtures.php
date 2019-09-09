<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $admin1 = new User();
        $admin1->setImageName('gnome.jpg');
        $admin1->setUpdatedAt(new \DateTime());
        $admin1->setUsername('cheikh');
        $password = $this->encoder->encodePassword($admin1, '1991');
        $admin1->setpassword($password);
        $admin1->setUsername('Cheikh');
        $admin1->setRoles(['ROLE_SUPER_ADMIN']);
        $admin1->setNom('Gaye');
        $admin1->setPrenom('Cheikh Diop');
        $admin1->setAdresse('Dakar');
        $admin1->setTelephone(773658401);
        $admin1->setEmail('diopgaye8045@gmail.com');
        $admin1->setEtat('');
        $admin1->setProfil('admin');

        $manager->persist($admin1);
        $manager->flush();
    }
}
