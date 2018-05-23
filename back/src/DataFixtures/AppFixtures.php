<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Post;
use App\Utils\Slug;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;
use Faker\Factory;

class AppFixtures extends Fixture
{
    private $passwordEncoder;
    private $faker;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager): void
    {
        $this->loadUsers($manager);
        $this->loadPosts($manager);
    }

    private function loadUsers(ObjectManager $em): void
    {
        for($i = 1; $i < 10; $i++) {
            $user = new User();
            $user->setUsername('user' . $i);
            $user->setName('UserName');
            $user->setSurname('UserSurname');
            $user->setEmail('user' . $i . '@email.com');
            $user->setPassword($this->passwordEncoder->encodePassword($user, 'user'));

            $em->persist($user);
            $this->addReference('user' . $i, $user);
        }

        $user = new User();
        $user->setUsername('admin');
        $user->setName('AdminName');
        $user->setSurname('AdminSurname');
        $user->setEmail('admin@email.com');
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'admin'));
        $user->setRoles(['ROLE_ADMIN']);
        $this->addReference('user10', $user);
        $em->persist($user);

        $em->flush();
    }

    private function loadPosts(ObjectManager $em): void
    {
        for($i = 0; $i < 50; $i++) {
            $post = new Post();
            $title = $this->faker->company;
            $post->setTitle($title);
            $post->setSlug(Slug::slugger($title));
            $post->setContent($this->faker->text(1500));

            for($j = 0; $j < random_int(1, 25); $j++) {
                $comment = new Comment();
                $comment->setContent($this->faker->text(500));
                $comment->setAuthor($this->getReference('user' . random_int(1, 10)));

                $post->addComment($comment);
            }

            $em->persist($post);
        }
        $em->flush();
    }

    private function loadComments(ObjectManager $em): void
    {

    }
}
