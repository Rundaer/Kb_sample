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

use PrestaShop\Module\Kb_Sample\Install\InstallerFactory;
use PrestaShop\PrestaShop\Adapter\SymfonyContainer;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

require_once __DIR__.'/vendor/autoload.php';

class Kb_Sample extends Module
{
    public function __construct()
    {
        $this->name = 'kb_sample';
        $this->author = 'Konrad Babiarz';
        $this->tab = 'others';
        $this->version = '1.0.0';
        $this->ps_versions_compliancy = [
            'min' => '1.7.5.0',
            'max' => _PS_VERSION_
        ];

        parent::__construct();
        $this->displayName = $this->l('Sample Back Office Controller');
        $this->description = $this->l('PrestaShop 1.7 sample Back Office controller with Symfony and Twig');
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
    }

    public function hookdisplayAdminNavBarBeforeEnd($params)
    {
        $sfContainer = SymfonyContainer::getInstance();
        return $sfContainer->get('twig')
            ->render('@Modules/kb_sample/views/templates/admin/menu.html.twig', [
                'in_symfony' => $this->isSymfonyContext(),
                'categ_title' => 'Framework',
                'ctr_title' => 'Configure',
                'ctr_url' => $sfContainer->get('router')->generate(
                    'kb_sample_index',
                    array(),
                    UrlGeneratorInterface::ABSOLUTE_URL
                ),
            ]);
    }
}
