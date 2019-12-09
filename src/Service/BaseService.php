<?php


namespace App\Service {


    use Symfony\Component\HttpFoundation\Request;
    use App\Entity\Product;
    use App\Form\ProductType;
    use Doctrine\ORM\EntityManagerInterface;


    class BaseService
    {
        protected $em;

        /**
         * BaseService constructor.
         * @param EntityManagerInterface $em
         */
        public function __construct(EntityManagerInterface $em)
        {
            $this->em = $em;
        }


        public function getAllProducts()
        {
            return $this
                ->em
                ->getRepository(Product::class)
                ->findAll();
        }

        public function showById(Product $product)
        {
            return $this->em
                ->getRepository(Product::class)
                ->find($product);
        }

        public function editProduct(Product $product)
        {
            $this->em
                ->getRepository(Product::class)
                ->find($product);
            return $product;
        }

        public function delProduct($product)
        {
            $this->em->remove($product);
            $this->em->flush();
            return $product;
        }

        public function createProduct($product)
        {
            $this->em->persist($product);
            $this->em->flush();
            return $product;
        }
    }
}