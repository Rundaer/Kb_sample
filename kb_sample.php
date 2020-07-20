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

use PrestaShop\Module\Kb_Sample\Install\InstallerFactory;

if (!defined('_PS_VERSION_')) {
    exit;
}

require_once __DIR__.'/vendor/autoload.php';

class Kb_Sample extends Module
{
    public function __construct()
    {
        $this->name = 'kb_sample';
        $this->author = 'Konrad Babiarz';
        $this->version = '1.0.0';
        $this->ps_versions_compliancy = ['min' => '1.7.6.0', 'max' => _PS_VERSION_];

        parent::__construct();

        $this->displayName = $this->l('Sample module');
        $this->description = $this->l('Sample description for module');
    }

    public function install()
    {
        if (!parent::install()) {
            return false;
        }

        $installer = InstallerFactory::create();

        return $installer->install($this);
    }

    public function uninstall()
    {
        $installer = InstallerFactory::create();

        return $installer->uninstall() && parent::uninstall();
    }
}
