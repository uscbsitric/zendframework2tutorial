<?php
namespace Album\Model;

 // Add these import statements:
 use Album\Model\Album;
 use Album\Model\AlbumTable;
 use Zend\Db\ResultSet\ResultSet;
 use Zend\Db\TableGateway\TableGateway;
 

 class AlbumTable
 {
     protected $tableGateway;

     public function __construct(TableGateway $tableGateway)
     {
         $this->tableGateway = $tableGateway;
     }
     // Add this method:
     public function getServiceConfig()
     {
     	return array('factories' => array('Album\Model\AlbumTable' =>  function($sm)
										     					  	   {
											     						$tableGateway = $sm->get('AlbumTableGateway');
											     						$table = new AlbumTable($tableGateway);
											     						return $table;
											     					   },
     									 'AlbumTableGateway' 	   => function($sm)
								     								  {
											     						$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
											     						$resultSetPrototype = new ResultSet();
											     						$resultSetPrototype->setArrayObjectPrototype(new Album());
											     						return new TableGateway('album', $dbAdapter, null, $resultSetPrototype);
								     								  },
     									),
     			   );
     }
      
     public function fetchAll()
     {
         $resultSet = $this->tableGateway->select();
         return $resultSet;
     }

     public function getAlbum($id)
     {
         $id  = (int) $id;
         $rowset = $this->tableGateway->select(array('id' => $id));
         $row = $rowset->current();
         if (!$row)
         {
             throw new \Exception("Could not find row $id");
         }
         return $row;
     }

     public function saveAlbum(Album $album)
     {
         $data = array('artist' => $album->artist,
             		   'title'  => $album->title,
         			  );

         $id = (int) $album->id;
         if ($id == 0)
         {
         	$this->tableGateway->insert($data);
         }
         else
         {
             if ($this->getAlbum($id))
             {
                 $this->tableGateway->update($data, array('id' => $id));
             }
             else
             {
                 throw new \Exception('Album id does not exist');
             }
         }
     }

     public function deleteAlbum($id)
     {
         $this->tableGateway->delete(array('id' => (int) $id));
     }
 }