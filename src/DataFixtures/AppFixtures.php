<?php

namespace App\DataFixtures;

use App\Entity\Child;
use App\Entity\Classroom;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    protected UserPasswordEncoderInterface $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $photoMale = "https://randomuser.me/api/portraits/men/";
        $photofemale = "https://randomuser.me/api/portraits/women/";

        // Classes
        $classes = [];
        for ($c = 0; $c < count(Classroom::LEVELS); $c++) {
            $classe = new Classroom;
            $classe->setName(Classroom::LEVELS[$c]);
            $classes[] = $classe;

            $manager->persist($classe);
        }

        // Prof
        for ($p = 0; $p < 5; $p++) {
            $prof = new User;
            $prof->setFirstName($faker->firstName)
                ->setLastName($faker->lastName)
                ->setEmail("prof$p@gmail.com")
                ->setRoles(['ROLE_PROF'])
                ->setClassroom($classes[$p])
                ->setPassword($this->encoder->encodePassword($prof, 'password'));

            $manager->persist($prof);
        }

        // user
        for ($u = 0; $u < 20; $u++) {
            $eleve = new Child;
            $eleve->setNom($faker->lastName);
            if ($faker->boolean()) {
                $eleve->setGenre(Child::GENRES[0])
                    ->setPrenom($faker->firstNameMale)
                    ->setPhoto($photoMale . \random_int(0, 99) . '.jpg');
            } else {
                $eleve->setGenre(Child::GENRES[1])
                    ->setPrenom($faker->firstNameFemale)
                    ->setPhoto($photofemale . \random_int(0, 99) . '.jpg');
            }
            $eleve->setClassroom($classes[2])
                ->setNom($faker->lastName)
                ->setDateNaissance($faker->dateTimeBetween("- 10 years", "- 9 years"))
                ->setAdresse($faker->streetAddress)
                ->setCodePostal($faker->postcode)
                ->setVille($faker->city)
                ->setSecuriteSociale($faker->ean13);
            if ($faker->boolean()) {
                $eleve->setAssuranceScolaire($faker->word());
            }
            if ($faker->boolean(65)) {
                $eleve->setNombreFreres(\random_int(1, 3))
                    ->setNombreSoeurs(\random_int(1, 3));
            }
            if ($faker->boolean(75)) {
                $eleve->setProfessionPere($faker->word());
            }
            if ($faker->boolean(45)) {
                $eleve->setProfessionMere($faker->word());
            }
            if ($faker->boolean(70)) {
                $eleve->setTelephoneDomicile($faker->phoneNumber)
                    ->setTelephonePere($faker->phoneNumber)
                    ->setTelephoneMere($faker->phoneNumber);
            }
            if ($faker->boolean(25)) {
                $eleve->setObservations($faker->words(\random_int(1, 5), true));
            }
            if ($faker->boolean(75)) {
                $eleve->setNomMedecinTraitant($faker->name)
                    ->setTelephoneMedecin($faker->phoneNumber);
            }
            $manager->persist($eleve);

            $prenom = $eleve->getPrenom();
            $nom = $eleve->getNom();

            $user = new User;
            $user->setFirstName($prenom)
                ->setLastName($nom)
                ->setEmail("user$u@gmail.com")
                ->setPassword($this->encoder->encodePassword($user, 'password'));
            $user->setStudent($eleve);

            $manager->persist($user);
        }

        $manager->flush();
    }
}
