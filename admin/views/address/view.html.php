<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

/**
 * TSJ View
 */
class TSJViewAddress extends JView
{
   /**
    * View form
    *
    * @var         form
    */
   protected $form = null;

   /**
    * display method of TSJ view
    * @return void
    */
   public function display($tpl = null)
   {
      // Get data from the model
      $item = $this->get('Item');
      $form = $this->get('Form');
      $script = $this->get('Script');

      // Check for errors.
      if (count($errors = $this->get('Errors')))
      {
         JError::raiseError(500, implode('<br />', $errors));
         return false;
      }

      // Assign data to the view
      $this->item = $item;
      $this->form = $form;
      $this->script = $script;

      // Set the toolbar
      $this->addToolBar();

      // Display the template
      parent::display($tpl);

      // Set the document
      $this->setDocument();
   }

   /**
    * Setting the toolbar
    */
   protected function addToolBar()
   {
      JRequest::setVar('hidemainmenu', true);
      $isNew = ($this->item->address_id == 0);
      JToolBarHelper::title($isNew ? JText::_('NEW') : JText::_('EDIT'));
      JToolBarHelper::save('address.save');
      JToolBarHelper::cancel('address.cancel', $isNew ? 'JTOOLBAR_CANCEL' : 'JTOOLBAR_CLOSE');

      $this->assignRef('address', $this->item);
   }

   /**
    * Method to set up the document properties
    *
    * @return void
    */
   protected function setDocument()
   {
      $document = JFactory::getDocument();
      $document->setTitle($isNew ? JText::_('CREATING') : JText::_('EDITING'));
      $document->addScript(JURI::root() . $this->script);
      $document->addScript(JURI::root() . "/administrator/components/com_tsj/views/address/submitbutton.js");
      JText::script('COM_TSJ_TSJ_ERROR_UNACCEPTABLE');
   }
}