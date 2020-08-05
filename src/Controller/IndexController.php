<?php

namespace PrestaShop\Module\Kb_Config\Controller;

use PrestaShop\Module\Kb_Config\Entity\SampleClass;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use PrestaShop\Module\Kb_Config\Form\SampleFormType;

class IndexController extends FrameworkBundleAdminController
{
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
            ->getRepository(SampleClass::class)
            ->findAll();

        return $this->render('@Modules/kb_config/views/templates/admin/index/index.html.twig', ['records' => $records]);
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request)
    {
        $sample = new SampleClass();

        $form = $this->createForm(SampleFormType::class, $sample);

        if ($request->isMethod('post')) {
            $form->handleRequest($request);

            $em = $this->getDoctrine()->getManager();
            $em->persist($sample);
            $em->flush();

            $this->addFlash("notice", "Aukcja została dodana");

            return $this->render('@Modules/kb_config/views/templates/admin/index/index.html.twig');
        }


        return $this->render('@Modules/kb_config/views/templates/admin/index/add.html.twig', ["form" => $form->createView()]);
    }
}
