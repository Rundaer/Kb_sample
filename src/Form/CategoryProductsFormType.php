<?php

namespace PrestaShop\Module\Kb_Config\Form;

use PrestaShop\Module\Kb_Config\Entity\CategoryProducts;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Product;
use Context;
use Category;
use PrestaShopBundle\Form\Admin\Type\CategoryChoiceTreeType;

class CategoryProductsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        //TODO: do better!
        $id_lang=(int)Context::getContext()->language->id;
        $start=0;
        $limit=100;
        $order_by='id_product';
        $order_way='DESC';
        $id_category = false;
        $only_active =true;
        $context = null;
        $choices = [];

        $all_products = Product::getProducts($id_lang, $start, $limit, $order_by, $order_way, $id_category, $only_active, $context);
        foreach ($all_products as $product) {
            $product['name'] = Product::getProductName($product['id_product']);
        }
        foreach ($all_products as $product) {
            $choices[$product['name']] = $product['id_product'];
        }

        


        $builder
            ->add('title', TextType::class, [
                "label" => "Tytuł"
            ])
            ->add('products', ChoiceType::class, [
                "label" => "Produkty",
                "choices" => $choices,
                'multiple' => true,
                'required' => true,
                'expanded' => false,
            ])
            ->add('link', TextType::class, [
                "label" => "Link",
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Wyślij'
                
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CategoryProducts::class,
        ]);
    }
}
