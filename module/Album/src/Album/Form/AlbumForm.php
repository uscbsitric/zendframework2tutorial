<?php
	namespace Album\Form;
	
	use Zend\Form\Form;
	
	class AlbumForm extends Form
	{
		public function __construct($name = null)
		{
			parent::__construct('album'); // setting the name of the form as the parent constructor is formed

			$this->add(array('name' => 'id',
							 'type' => 'Hidden'
							)
					  );
			
			$this->add(array('name'    => 'title',
							 'type'    => 'Text',
							 'options' => array('label' => 'Title')
							)
					  );
			$this->add(array('name'    => 'artist',
							 'type'    => 'Text',
							 'options' => array('label' => 'Artist')
							)
					  );
			
			$this->add(array('name'	   => 'submit',
							 'type'    => 'Submit',
							 'options' => array('value' => 'Go',
							 					'id'    => 'submitbutton'
											   )
							)
					  );
		}
	}