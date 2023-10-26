<?php

namespace App\DataFixtures;

use App\Entity\Character;
use App\Entity\GameAccount;
use Faker;
use DateTime;
use App\Entity\Post;
use App\Entity\User;
use App\Entity\PostCategory;
use App\Entity\Product;
use App\Entity\ProductCategory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct (
        private UserPasswordHasherInterface $userPasswordHasherInterface,
        private SluggerInterface $slugger
        ) 
    {
        $this->userPasswordHasherInterface = $userPasswordHasherInterface;
        $this->slugger = $slugger;
    }
    
    public function load(ObjectManager $manager): void
    {   

        $faker = Faker\Factory::create();

        // Création Users simple & admin
        $admintest = new User();
        $admintest->setUsername("admintest");
        $admintest->setEmail("admintest@test.fr");
        $admintest->setPassword($this->userPasswordHasherInterface->hashPassword($admintest, "admintest"));
        $admintest->setRoles(["ROLE_ADMIN"]);
        $admintest->setVotepoints(0);
        $admintest->setCashpoints(1000);
        $manager->persist($admintest);

        $usertest = new User();
        $usertest->setUsername("usertest");
        $usertest->setEmail("usertest@test.fr");
        $usertest->setPassword($this->userPasswordHasherInterface->hashPassword($usertest, "usertest"));
        $usertest->setRoles(["ROLE_USER"]);
        $usertest->setVotepoints(0);
        $usertest->setCashpoints(1000);
        $manager->persist($usertest);


        // Création PostCategory
        $newsCategory = new PostCategory();
        $newsCategory->setName('news');
        $manager->persist($newsCategory);

        $wikiCategory = new PostCategory();
        $wikiCategory->setName('wiki');
        $manager->persist($wikiCategory);


        // Création ProductCategory
        $ProductCatsTab = ["Boîtes","Capes","Masques","Consommables","Fashions","Guilde", "Ramasseurs"];
        $ProductCats=[];
        for($i=0;$i<7;$i++){
            $ProductCat = new ProductCategory();
            $ProductCat->setName($ProductCatsTab[$i]);
            array_push($ProductCats, $ProductCat);
            $manager->persist($ProductCat);
        }


        // Création News Posts
        for($i=0;$i<50;$i++){
            $news = new Post();
            $news->setTitle($faker->words(3, true));
            $news->setCategories($newsCategory);
            $news->setContent($faker->text());
            $news->setUser($admintest);
            $news->setCreatedAt(new DateTime());
            $news->setUpdatedAt(new DateTime());
            $news->setSlug($this->slugger->slug($news->getTitle()));
            $news->setImage('banner.png');
            $manager->persist($news);
        }

        // Création Wiki Posts
        for($i=0;$i<8;$i++){
            $wikis = new Post();
            $wikis->setTitle($faker->words(3, true));
            $wikis->setCategories($wikiCategory);
            $wikis->setContent($faker->text());
            $wikis->setUser($admintest);
            $wikis->setCreatedAt(new DateTime());
            $wikis->setUpdatedAt(new DateTime());
            $wikis->setSlug($this->slugger->slug($wikis->getTitle()));
            $wikis->setImage('banner.png');
            $manager->persist($wikis);
        }


        // Création GameAccounts
        $usersAccount = [];

        $adminGameAccount = new GameAccount();
        $adminGameAccount->setUser($admintest);
        $adminGameAccount->setAccountName("admintest");
        $adminGameAccount->setNickname("admintest");
        $adminGameAccount->setPassword($this->userPasswordHasherInterface->hashPassword($admintest, "admintest"));
        array_push($usersAccount, $adminGameAccount);
        $manager->persist($adminGameAccount);

        $testGameAccount = new GameAccount();
        $testGameAccount->setUser($usertest);
        $testGameAccount->setAccountName("usertest");
        $testGameAccount->setNickname("usertest");
        $testGameAccount->setPassword($this->userPasswordHasherInterface->hashPassword($usertest, "usertest"));
        array_push($usersAccount, $testGameAccount);
        $manager->persist($testGameAccount);


        // Création Characters
        $classesTab = ["Vagabond", "Mercenaire", "Acrobate", "Acolyte", "Mage"];
        $guildesTab = ["Black", "White", "Blue", "Red"];

        for($i=0;$i<10;$i++){
            $classesIndex = array_rand($classesTab);
            $class = $classesTab[$classesIndex];
            $guildesIndex = array_rand($guildesTab);
            $guildes = $guildesTab[$guildesIndex];

            $character = new Character();
            $character->setGameAccount($usersAccount[random_int(0, count($usersAccount)-1)]);
            $character->setCharacterName($faker->userName());
            $character->setClass($class);
            $character->setGuild($guildes);
            $character->setXp(random_int(0, 9999999999));
            $manager->persist($character);
        }


        // Création Produits
        $products = [
            [
                'name' => 'Lucky Box (Cape)',
                'desc' => 'Contient une cape exclusive',
                'price' => 500,
                'image' => 'Premium-Box-6535867fb8d7a.png',
                'category' => $ProductCats[0],
            ],
            [
                'name' => 'Lucky Box (Masque)',
                'desc' => 'Contient un masque exclusif',
                'price' => 500,
                'image' => 'Treasure-Box-653588482a59a.png',
                'category' => $ProductCats[0],
            ],
            [
                'name' => 'Cape de Matholle (Noire)',
                'desc' => 'Cape de Matholle (Noire)',
                'price' => 250,
                'image' => 'itm-MATHOLLE01-65358ae28db3a.png',
                'category' => $ProductCats[1],
            ],
            [
                'name' => 'Cape de Matholle (Blanche)',
                'desc' => 'Cape de Matholle (Blanche)',
                'price' => 250,
                'image' => 'itm-MATHOLLE02-65358af9ced92.png',
                'category' => $ProductCats[1],
            ],
            [
                'name' => 'Masque du Dragon (Foudroyant)',
                'desc' => 'Masque du Dragon (Foudroyant)',
                'price' => 250,
                'image' => 'Chance-Box-Mask-of-the-Dragon-65358b313b6d2.png',
                'category' => $ProductCats[2],
            ],
            [
                'name' => 'Masque du Dragon (Immortel)',
                'desc' => 'Masque du Dragon (Immortel)',
                'price' => 250,
                'image' => 'Chance-Box-Mask-of-the-Dragon-65358b4cc65af.png',
                'category' => $ProductCats[2],
            ],
            [
                'name' => 'Tenue Purple Winter (F)',
                'desc' => 'Tenue Purple Winter (F)',
                'price' => 300,
                'image' => 'Purple-Winter-65358b8ebe280.png',
                'category' => $ProductCats[4],
            ],
            [
                'name' => 'Tenue Bodyguard (M)',
                'desc' => 'Tenue Bodyguard (M)',
                'price' => 300,
                'image' => 'BoadyguardM-65358bb452a59.png',
                'category' => $ProductCats[4],
            ],
            [
                'name' => 'Dent de Dragon',
                'desc' => 'Slot d\'items de quête permettant d\'xp votre guilde',
                'price' => 300,
                'image' => 'dent-de-dragon-65358bd5c5fa5.png',
                'category' => $ProductCats[5],
            ],
            [
                'name' => 'Parchemin de transfert d\'éveil',
                'desc' => 'Parchemin de transfert d\'éveil',
                'price' => 500,
                'image' => 'oxqvztbExfpM0NGbJeigKAcYFfCAb7S9SULTYA2u-65358c185.png',
                'category' => $ProductCats[3],
            ],
            [
                'name' => 'Parchemin de maîtrise (R)',
                'desc' => 'Parchemin augmentant l\'XP de 50%',
                'price' => 400,
                'image' => 'Maitrise-R-65358c4f61f2e.png',
                'category' => $ProductCats[3],
            ],
            [
                'name' => 'chienchien noir',
                'desc' => 'Bébé ramasseur qui vous suivra et ramassera les ob...',
                'price' => 200,
                'image' => 'chienchien-noir-65358c6d5fa56.png',
                'category' => $ProductCats[6],
            ],
            [
                'name' => 'Ramassator',
                'desc' => 'Bébé ramasseur qui vous suivra et ramassera les ob...',
                'price' => 200,
                'image' => 'Ramassator-65358c8ff2e08.png',
                'category' => $ProductCats[6],
            ],
        ];
        
        foreach ($products as $productData) {
            $product = new Product();
            $product->setName($productData['name']);
            $product->setDescription($productData['desc']);
            $product->setPrice($productData['price']);
            $product->setImage($productData['image']);
            $product->setCategories($productData['category']);
            $product->setCreatedAt(new DateTime());
            $product->setUpdatedAt(new DateTime());
            $manager->persist($product);
        }

        $manager->flush();
    }
}