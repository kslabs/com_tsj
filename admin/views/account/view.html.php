<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

/**
 * TSJ View
 */
class TSJViewAccount extends JView
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
      $isNew = ($this->item->account_id == 0);
      JToolBarHelper::title($isNew ? JText::_('NEW') : JText::_('EDIT'));
      JToolBarHelper::save('account.save');
      JToolBarHelper::cancel('account.cancel', $isNew ? 'JTOOLBAR_CANCEL' : 'JTOOLBAR_CLOSE');

      $this->assignRef('account', $this->item);
   }

   /**
    * Method to set up the document properties
    *
    * @return void
    */
   protected function setDocument()
   {
      //$isNew = ($this->item->street_id < 1);
      $document = JFactory::getDocument();
      $document->setTitle($isNew ? JText::_('COM_TSJ_ACCOUNT_CREATING')
      : JText::_('COM_TSJ_ACCOUNT_EDITING'));

      $document->addScript(JURI::root() . $this->script);
      $document->addScript(JURI::root() . "/administrator/components/com_tsj/views/account/submitbutton.js");
      JText::script('COM_TSJ_TSJ_ERROR_UNACCEPTABLE');
   }
}