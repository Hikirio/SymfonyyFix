<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\BaseService;

/**
 * @Route("/product")
 */
class ProductController extends AbstractController
{
    protected $baseServise;

    // Сервис автозагрузится в качестве аргумента по имени класса (MyService)
    public function __construct(BaseService $baseServise)
    {
        // Помещаем сервис в поле класса
        $this->baseServise = $baseServise;
    }

    /**
     *
     * @Route("/", name="product_index", methods={"GET"})
     *
     * @return Response
     */
    public function index()
    {
        return $this->render('product/index.html.twig', [
            'products' => $this
                ->baseServise
                ->getAllProducts()
        ]);
    }

    /**
     * @Route("/{id}", name="product_show", methods={"GET"}, requirements={"id":"\d+"})
     *
     * @param Product $product
     *
     * @return Response
     */
    public function show(Product $product): Response
    {
        return $this->render('product/show.html.twig', [
            'product' => $this
                ->baseServise
                ->showById($product)
        ]);
    }

    /**
     * @Route("/new", name="product_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);


        return $this->render('product/new.html.twig', [
            'product' => $this->baseServise
                ->createProduct($product),
            'form' => $form->createView(),

        ]);
    }

    /**
     * @Route("/{id}/edit", name="product_edit", methods={"GET","POST"})
     *
     * @param Request $request
     * @param Product $product
     *
     * @return Response
     */
    public function edit(Request $request, Product $product): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('product_index');
        }

        return $this->render('product/edit.html.twig', [
            'form' => $form->createView(),
            'product' => $this->baseServise
                ->editProduct($product)
        ]);
    }

    /**
     * @Route("/{id}", name="product_delete", methods={"DELETE"})
     *
     * @param Request $request
     * @param Product $product
     *
     * @return Response
     */
    public function delete(Request $request, Product $product): Response
    {
        $this->baseServise->delProduct($product);
        return $this->redirectToRoute('product_index', [
        ]);
    }
}
