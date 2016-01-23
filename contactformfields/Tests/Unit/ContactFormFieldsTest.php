<?php

$exec_dir = str_replace('modules/contactformfields', '', trim(shell_exec('pwd')));
include_once $exec_dir . 'config/config.inc.php';

class ContactFormFieldsTest extends PHPUnit_Framework_TestCase {

    //Pour tests locaux @ToDo : de manière dynamique
    protected $_baseDir;
    
    //Nom du module
    protected $_moduleName = 'contactformfields';
    
    //Instance du module
    protected $_moduleInstance;

    /**
     * Surcharge pour gérer le contexte du chemin
     */
    public function __construct($name = null, array $data = [], $dataName = '') {
        
        //Définition du chemin par défaut
        $this->_baseDir = str_replace('modules/'.$this->_moduleName, '', trim(shell_exec('pwd')));
        
        //Instanciation du module
        $this->_moduleInstance = ModuleCore::getInstanceByName($this->_moduleName);
        
        parent::__construct($name, $data, $dataName);
    }
    
    /**
     * Vérification que le module est installé (via la méthode prestashop)
     * @group contactformfields_install
     */
    public function testModuleIsInstalled() {
        $this->assertTrue(ModuleCore::isInstalled($this->_moduleName));
    }

    /**
     * Vérifie que l'installation des overrides (fichiers) du module est OK
     * @group contactformfields_install
     */
    public function testInstallOverrides() {

        $filesOverride = array(
            'controllers/front/ContactController.php',
        );

        foreach ($filesOverride as $file) {
            $this->assertFileExists($this->_baseDir . 'override/' . $file);
        }
    }

    /**
     * On vérifie que les nouveaux hooks du modules sont bien créés
     * @group contactformfields_install
     */
    public function testNewHooksExist() {
        
        $this->assertNotFalse(HookCore::getIdByName('contactFormAdditionnalFields'));
        $this->assertNotFalse(HookCore::getIdByName('actionAddContactFormFieldsToEmail'));
    }
    
    /**
     * On vérifie que le module est bien greffé sur les nouveaux hooks
     * @depends testNewHooksExist
     * @group contactformfields_install
     */
    public function testModuleIsHooked() {
        
        $this->assertNotFalse($this->_moduleInstance->isRegisteredInHook('contactFormAdditionnalFields'));
        $this->assertNotFalse($this->_moduleInstance->isRegisteredInHook('actionAddContactFormFieldsToEmail'));
    }

}
