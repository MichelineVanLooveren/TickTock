<?php

//functie om alle lijsten uit te lezen
class Lijst
{
    private $list_name;

    public function createList()
    {
        echo $this->getList_name();
        //connectie leggen met db tl_list
        $conn = Db::getInstance();
        $statement = $conn->prepare('INSERT into tl_list (list_name, user_id) VALUES (:list_name, 1)'); //nu user_id hard coded 1 meegegeven, daarna user_id uit session halen
        $statement->bindParam(':list_name', $this->list_name); //SQL-injectie tegengaan via PDO
        var_dump($statement->execute());
    }

    /**
     * Get the value of list_name.
     */
    public function getList_name()
    {
        return $this->list_name;
    }

    /**
     * Set the value of list_name.
     *
     * @return self
     */
    public function setList_name($list_name)
    {
        $this->list_name = $list_name;

        return $this;
    }
}
