<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;
use App\Entity\Article;


class UserFixtures extends Fixture
{
	private $PasswordEncode;
	public function __construct(UserPasswordEncoderInterface $PasswordEncode)
	{
		$this->PasswordEncode=$PasswordEncode;
	}
    public function load(ObjectManager $manager)
    {
		for ($i=0; $i <=2 ; $i++) { 
		$user = new User();
		$user->setEmail(sprintf("email%d@gmail.com", $i));

        $user->setPassword($this->PasswordEncode->encodePassword(
            $user,
           'the_new_password'
        ));

        $manager->persist($user);
        for ($j=0; $j <= 3 ; $j++) { 
        	$article = new Article();
        	$article->setTitre(sprintf("Titre %d", $j));
            $article->setDescription(sprintf("Description %d", $j));
            $article->setDate(new \DateTime());
            $article->setAuteur($user);

            $manager->persist($article);
        }
		}
        $manager->flush();

    }
}
