<?php

namespace PrestaShop\Module\Kb_Config\Controller;

use PrestaShop\Module\Kb_Config\Entity\CategoryProducts;
use Symfony\Component\HttpFoundation\Request;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use PrestaShop\Module\Kb_Config\Form\CategoryProductsFormType;
use PrestaShop\Module\Kb_Config\Helpers\TraitContext;

class IndexController extends FrameworkBundleAdminController
{
    use TraitContext;

    /**
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $records = $em
            ->getRepository(CategoryProducts::class)
            ->findAll();

        foreach ($records as $record) {
            $products = $record->getProducts();
            foreach ($products as &$product) {
                $product = $this->getProductData($product);
            }
            $record->setProducts($products);
        }

        return $this->render('@Modules/kb_config/views/templates/admin/index/index.html.twig', ['records' => $records]);
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request)
    {
        $categoryProducts = new CategoryProducts();

        $form = $this->createForm(CategoryProductsFormType::class, $categoryProducts);

        if ($request->isMethod('post')) {
            $form->handleRequest($request);

            $em = $this->getDoctrine()->getManager();
            $em->persist($categoryProducts);
            $em->flush();

            $this->addFlash("notice", "Blok została dodana");

            return $this->redirectToRoute('kb_config_index');
        }


        return $this->render('@Modules/kb_config/views/templates/admin/index/add.html.twig', ["form" => $form->createView()]);
    }

    /**
     * @param Request $request
     * @param CategoryProducts $categoryProducts
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, CategoryProducts $categoryProducts)
    {
        $form = $this->createForm(CategoryProductsFormType::class, $categoryProducts);

        if ($request->isMethod('post')) {
            $form->handleRequest($request);

            $em = $this->getDoctrine()->getManager();
            $em->persist($categoryProducts);
            $em->flush();

            $this->addFlash("notice", "Blok został edytowany");

            return $this->redirectToRoute('kb_config_index');
        }


        return $this->render('@Modules/kb_config/views/templates/admin/index/edit.html.twig', ["form" => $form->createView()]);
    }

    /**
     * @param Request $request
     * @param CategoryProducts $categoryProducts
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(CategoryProducts $categoryProducts)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($categoryProducts);
        $entityManager->flush();

        $this->addFlash("success", "Blok został usunięty");

        return $this->redirectToRoute("kb_config_index");
    }
}
