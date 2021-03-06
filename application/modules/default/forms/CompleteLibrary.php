<?php
require_once 'elements/Autocomplete.php';

class Default_Form_CompleteLibrary extends Zend_Form {

    private $elementDecorators = array(
        'ViewHelper',
        array(array('data' => 'HtmlTag'), array('tag' => 'div', 'class' => 'element')),
        array('Errors', array('class' => 'help-error')),
        'Label',
        array(array('row' => 'HtmlTag'), array('tag' => 'li'))
    );
    
    private $checkboxDecorators = array(
        'ViewHelper',
        array(array('data' => 'HtmlTag'), array('tag' => 'div')),
        array('Errors', array('class' => 'help-error')),
        array('Label', array('class' => 'label-left')),
        array(array('row' => 'HtmlTag'), array('tag' => 'li', 'class' => 'chkbx'))
    );
    
    private $buttonDecorators = array(
        'ViewHelper',
        array(array('data' => 'HtmlTag'), array('tag' => 'div', 'class' => 'button')),
        array(array('row' => 'HtmlTag'), array('tag' => 'li')),
    );
    
    public function init() {
        $this->setAttrib('id', 'form_complete_library')
                ->setMethod('POST')
                ->setName('form_complete_library');

        $this->addElementsForm();
    }

    public function addElementsForm() {
        $auto = new Default_Form_Element_Autocomplete('tags');
        $auto->removeDecorator('Label');
        
        $modelCategory = new Model_Category();
        $categories = $modelCategory->getNamesFormFormatted();
        
        $categoriesSelect = new Zend_Form_Element_Select('form_document_library_category');
        $categoriesSelect->setRequired(true)
             ->setLabel('Catégorie')
             ->addMultiOptions($categories)
             ->setDecorators($this->elementDecorators);
        
        $publishButton = new Zend_Form_Element_Submit('publish');
        $publishButton->setLabel('Publier')
                      ->setDecorators($this->buttonDecorators)
                      ->setAttrib('class', 'btn btn-large btn-primary btn-left2');
        
        $saveButton = new Zend_Form_Element_Submit('save');
        $saveButton->setLabel('Sauvegarder')
                      ->setDecorators($this->buttonDecorators)
                      ->setAttrib('class', 'btn btn-large btn-right2');
        
        $this->addElements(array(
            $this->createElement('text', 'form_document_library_header', array('size' => '88'))->setRequired(true)->setLabel('Titre / Adresse d\'un site')->setDecorators($this->elementDecorators),
            $this->createElement('textarea', 'form_document_library_description', array('rows' => '7', 'cols' => '50'))->setRequired(true)->setLabel('Texte / Description de l\'adresse')->setDecorators($this->elementDecorators),
            $this->createElement('text', 'form_document_library_source', array('size' => '88'))->setRequired(true)->setLabel('Source (nom de l\'auteur / courant islamique / site de l\'article / origine du texte, etc)')->setDecorators($this->elementDecorators),
            $categoriesSelect,
            $this->createElement('text', 'tagsValues')->setRequired(true)->setLabel('Mots-clés')->setDecorators($this->elementDecorators)->addValidator(new Islamine_Validate_Tags()),
            $auto->setDecorators($this->elementDecorators),
            $this->createElement('hash', get_class().'_csrf', array('salt' => 'unique', 'timeout' => 3600))->setDecorators($this->elementDecorators),
            $publishButton,
            $saveButton
        ));
    }
    
    public function loadDefaultDecorators() {

        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'ul')),
            'Form'
        ));
    }

}

?>
