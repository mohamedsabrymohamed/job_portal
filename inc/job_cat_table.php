<?php


class job_cat_table
{
    private $_dbh;
    private $_table_name = 'job_cat';
    public function __construct()
    {
        $this->_dbh = new db_connection($this->_table_name);
    }



    public function retrieve_all_job_cat()
    {
        $query = "SELECT * from ".$this->_table_name."";
        $result = $this->_dbh->query($query);
        $trans_data = array();
        while($row = mysqli_fetch_assoc($result))
        {
            $trans_data[] = $row;
        }
        return $trans_data;
    }



    public function add_new_data(array $summery_data)
    {
        if($summery_data)
        {
            return $this->_dbh->insert($summery_data);

        }
        return false;
    }

    public function update_data(array $user_data,$condition)
    {
        return $this->_dbh->update($user_data, $condition);
    }


    public function delete_data($productid)
    {
        $product_id = $productid;

        $query = "DELETE FROM ".$this->_table_name." WHERE id =".$product_id." ";

        $result = $this->_dbh->query($query);

        if($result)
        {
            return true;
        }
        return false;
    }





}