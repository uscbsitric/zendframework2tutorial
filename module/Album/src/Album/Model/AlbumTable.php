<?php
namespace Album\Model;

 // Add these import statements:
 use Album\Model\Album;
 use Album\Model\AlbumTable;
 use Zend\Db\ResultSet\ResultSet;
 use Zend\Db\TableGateway\TableGateway;
 
 // as per http://stackoverflow.com/questions/18961988/how-to-get-an-instance-of-servicemanager-into-a-model-in-zf2?rq=1#
 use Zend\ServiceManager\ServiceLocatorAwareInterface;
 use Zend\ServiceManager\ServiceLocatorInterface;

 class AlbumTable implements ServiceLocatorAwareInterface
 {
     protected $tableGateway;
     protected $serviceLocator;

     public function __construct(TableGateway $tableGateway)
     {
         $this->tableGateway = $tableGateway;
     }

     public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
     {
     	$this->serviceLocator = $serviceLocator;
     }
      
     public function getServiceLocator()
     {
     	return $this->serviceLocator;
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