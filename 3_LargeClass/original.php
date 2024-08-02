<?php
class Item {
    private $id;
    private $price;

    public function __construct($id,$price)
    {
        $this->setId($id);
        $this->setPrice($price);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }


}

class Customer {
    private $id;
    public function __construct($id)
    {
        $this->setId($id);
    }
    public function getId(){
        return $this->id;
    }
    public function setId($id){
        $this->id = $id;
    }
}

class DAO {

    public function insertOrder($customer,$total): int
    {
        $sql = "INSERT INTO orders (customer_id, total) VALUES (?, ?)";
        $param = [$customer->getId() ,$total];
        return $this->executeSQL($sql , $param);
    }
    public function insertOrderItem($oderId,$item){
        $param = [$oderId, $item->getId()];
        $sql = "INSERT INTO order_items (order_id, item_id) VALUES (?, ?)";
        $this->executeSQL($sql , $param);
    }
    protected function getPDO(): PDO
    {
        $db = new PDO('mysql:host=localhost;dbname=testdb' , 'root' , '');
        $db->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
        return $db;
    }
    protected function executeSQL(string $sql , array $param): int
    {
        $db = $this->getPDO();
        $query = $db->prepare($sql);
        $query->execute($param);
        return $db->lastInsertId();
    }
}
class Order
{
    private  $items = [];
    private $customer;
    private $dao;

    public function getDao(): DAO
    {
        if(is_null($this->dao)){
            $this->dao = new DAO();
        }
        return $this->dao;
    }


    public function addItem(Item $item)
    {
        $this->items[spl_object_hash($item)] = $item;
    }


    public function removeItem(Item $item)
    {
        $index = spl_object_hash($item);
        if (isset($this->items[$index])) {
            unset($this->items[$index]);
        }
    }


    public function setCustomer(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function getCustomer(){
        return $this->customer;
    }
    private function calculateTotal()
    {
        return array_sum(array_map(function (Item $item) {
            return $item->getId();
        } , $this->items));
    }


    public function saveOrder()
    {
        $oderId = $this->getDao()->insertOrder($this->getCustomer(),$this->calculateTotal());
         foreach ($this->items as $item) {
             $this->getDao()->insertOrderItem($oderId,$item);
        }
    }

}
