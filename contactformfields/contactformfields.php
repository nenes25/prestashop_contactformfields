<?php

/**
 * 2007-2016 PrestaShop.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 *  @author    Hennes Hervé <contact@h-hennes.fr>
 *  @copyright 2013-2016 Hennes Hervé
 *  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *  http://www.h-hennes.fr/blog/
 */
class contactformfields extends Module {

    public function __construct() {
        
        $this->name = 'contactformfields';
        $this->tab = 'others';
        $this->author = 'hhennes';
        $this->version = '0.1.0';
        $this->need_instance = 0;

        parent::__construct();

        $this->displayName = $this->l('contactformfields');
        $this->description = $this->l('contactformfields description');
    }

    public function install() {
        if (!parent::install() || !$this->registerHook('contactFormAdditionnalFields') || !$this->registerHook('actionAddContactFormFieldsToEmail')) {
            return false;
        }

        return true;
    }

    public function uninstall() {
        if (!parent::uninstall()) {
            return false;
        }

        return true;
    }
    
    /**
     * Hook spécifique créé par le module pour afficher les nouveaux champs
     * @param array $params
     */
    public function hookContactFormAdditionnalFields($params){
        
        /**
         * Pour l'instant on mets les champs en statique
         * Mais l'intéret du hook est de permettre que ce soit administrable via le bo plus tard
         * 
         */
        echo $this->display(__FILE__,'hookContactFormAdditionnalFields.tpl');
    }
    
    /**
     * Validation des champs additionnels du formulaire
     * 
     * @param type $params
     */
    public function hookActionValidateContactFormAdditionnalFields($params) {
        
    }
    
    /**
     * Ajout des données à l'email
     * @param array $params[var_list] => passé par référence
     */
    public function hookActionAddContactFormFieldsToEmail($params) {
        
        //On mets en forme le contenu qu'on veut rajouter dans l'email
        $emailContent = '<span>Additionnal Email fields <br />';
        
        if ( Tools::getValue('additionnal_info1') )
            $emailContent.= 'Additionnal Field 1 : '.Tools::getValue('additionnal_info1').'<br />';
        if ( Tools::getValue('additionnal_info2') )
            $emailContent.= 'Additionnal Field 2 : '.Tools::getValue('additionnal_info2');
        
        $emailContent .= '</span>';
        
        //On le rajoute dans une variable
        $params['var_list']['{contact_additionnal_fields}'] = $emailContent;
    }

}
