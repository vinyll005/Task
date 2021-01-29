<?php

//              TASK #1

final class Item
{

    /**
     *
     * @property  int $id
     * @property string $name
     * @property int $status
     * @property bool $changed
     * 
     */

    private int $id;
    private string $name;
    private int $status;
    private bool $changed = false;
    
        
    /**
     * Class constructor
     *
     * @param  mixed $object_id
     * @return void
     */

    public function __construct(int $object_id)
    {
        $this->id = $object_id;

        Item::init();
    }
    
    /**
     * Take name, status from DB and fill it in properties
     *
     * @return void
     */

    private static function init() 
    {
        $object = Item::getObjectById($this->id);

        $this->name = $object['name'];
        $this->status = $object['status'];
    }
    
    /**
     * Change name or status to the new value
     *
     * @param  mixed $property
     * @param  mixed $value
     * @return void
     */

    public function __set($property, $value)
    {
        switch ($property) {

            case 'name':
                if(!empty($value) && is_string($value)) {
                    $this->name = $value;
                    $this->changed = true;
                    break;
                }   else {
                    echo 'Wrong type of property, it should be string';
                    break;
                }
                
            case 'status':
                if(!empty($value) && is_int($value)) {
                    $this->status = $value;
                    $this->changed = true;
                    break;
                }   else {
                    echo 'Wrong type of property, it should be integer';
                    break;
                }
                
        }
    }
    
    /**
     * Get current value of property 
     *
     * @param  mixed $property
     * @return void
     */

    public function __get($property)
    {
        switch ($property) {
            case 'name':
                return $this->name;
                break;
            
            case 'status':
                return $this->status;
                break;
            case 'id':
                return $this->id;
                break;
        }
    }
    
    /**
     * Save new values of properties in DB
     *
     * @return void
     */

    public function save()
    {
        if($this->changed)  {
            Item::saveNewValues($this->id, $this->name, $this->status);
        }   else {
            echo 'Nothing changed!';
        }
    }


    //           SQL QUERIES ( Optional )

    public static function getDbConnection()
    {
        $db = mysqli_connect('localhost', 'root', '', 'shop');
        return $db;
    }

    private static function getObjectById($id)
    {
        $db = Item::getDbConnection();

        $request = $db->prepare("SELECT * FROM objects WHERE id = ?");
        $request->bind_param('s', $db);
        $request->execute();

        $result = $request->get_result();
        $resArr = $result->fetch_assoc();

        return $resArr;
    }

    private static function saveNewValues($id, $name, $status)
    {
        $db = Item::getDbConnection();

        $request = $db->prepare("UPDATE objects SET name = ?, status = ? WHERE id = ?");
        $request->bind_param('sss', $name, $status, $db);
        $request->execute();
    }
    
}

?>