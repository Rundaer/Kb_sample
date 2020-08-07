<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0).
 * It is also available through the world-wide-web at this URL: https://opensource.org/licenses/AFL-3.0
 */

declare(strict_types=1);

if (!defined('_PS_VERSION_')) {
    exit;
}

use PrestaShop\Module\Kb_Config\Helpers\TraitHomeProducts;
use PrestaShop\Module\Kb_Config\Install\InstallerFactory;
use PrestaShop\PrestaShop\Adapter\Category\CategoryProductSearchProvider;
use PrestaShop\PrestaShop\Adapter\Image\ImageRetriever;
use PrestaShop\PrestaShop\Adapter\Presenter\Product\ProductListingPresenter;
use PrestaShop\PrestaShop\Adapter\Product\PriceFormatter;
use PrestaShop\PrestaShop\Adapter\Product\ProductColorsRetriever;
use PrestaShop\PrestaShop\Adapter\SymfonyContainer;
use PrestaShop\PrestaShop\Core\Product\Search\ProductSearchContext;
use PrestaShop\PrestaShop\Core\Product\Search\ProductSearchQuery;
use PrestaShop\PrestaShop\Core\Product\Search\SortOrder;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

require_once __DIR__.'/vendor/autoload.php';

class Kb_Config extends Module
{
    use TraitHomeProducts;

    public function __construct()
    {
        $this->name = 'kb_config';
        $this->author = 'Konrad Babiarz';
        $this->tab = 'others';
        $this->version = '1.0.1';
        $this->ps_versions_compliancy = [
            'min' => '1.7.5.0',
            'max' => _PS_VERSION_
        ];

        parent::__construct();
        $this->displayName = $this->l('Framework configure');
        $this->description = $this->l('Admin configuration of modules');
    }

    public function install()
    {
        $installer = InstallerFactory::create();

        return parent::install() && $installer->install($this);
    }

    public function uninstall()
    {
        $installer = InstallerFactory::create();

        return $installer->uninstall() && parent::uninstall();
    }

    public function hookDisplayBackOfficeHeader()
    {
        // Use addCss : registerStylesheet is only for front controller.
        $this->context->controller->addCss(
            $this->_path.'views/css/admin.css'
        );

        $this->context->controller->addJS(
            $this->_path.'views/js/admin.js'
        );
    }

    /**
     *  Inject the needed javascript and css files in the appropriate pages
     */
    public function hookHeader()
    {
        $jsList = [];
        $cssList = [];
        if ($this->context->controller instanceof IndexControllerCore) {
            $cssList[] = '/modules/kb_config/views/css/front/home.css';
            // $jsList[] = '/modules/productcomments/views/js/jquery.rating.plugin.js';
        }
        foreach ($cssList as $cssUrl) {
            $this->context->controller->registerStylesheet(sha1($cssUrl), $cssUrl, ['media' => 'all', 'priority' => 80]);
        }
        foreach ($jsList as $jsUrl) {
            $this->context->controller->registerJavascript(sha1($jsUrl), $jsUrl, ['position' => 'bottom', 'priority' => 80]);
        }
    }

    public function hookdisplayAdminNavBarBeforeEnd($params)
    {
        $sfContainer = SymfonyContainer::getInstance();
        return $sfContainer->get('twig')
            ->render('@Modules/kb_config/views/templates/admin/menu.html.twig', [
                'in_symfony' => $this->isSymfonyContext(),
                'categ_title' => 'Framework',
                'ctr_title' => 'Configure',
                'ctr_url' => $sfContainer->get('router')->generate(
                    'kb_config_index',
                    array(),
                    UrlGeneratorInterface::ABSOLUTE_URL
                ),
            ]);
    }


    public function hookDisplayHome()
    {
        $products = $this->getProducts();
 
        if ($products != false) {
            $this->smarty->assign([
                'blocks' => $products,
            ]);
            
            $tpl = 'module:kb_config/views/templates/hook/homeblock.tpl';
            return $this->fetch($tpl);
        }
    }
}
