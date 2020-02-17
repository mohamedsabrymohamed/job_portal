<?php


class users_jobs_table
{
    private $_dbh;
    private $_table_name = 'users_jobs';
    public function __construct()
    {
        $this->_dbh = new db_connection($this->_table_name);
    }



    public function retrieve_all_user_jobs()
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

    public function retrieve_all_user_jobs_by_company_id($company_id)
    {
        $query = "SELECT * from ".$this->_table_name." where company_id =".$company_id;
        $result = $this->_dbh->query($query);
        $trans_data = array();
        while($row = mysqli_fetch_assoc($result))
        {
            $trans_data[] = $row;
        }
        return $trans_data;
    }

    public function retrieve_all_user_approved_jobs_by_user_id($user_id)
    {
        $query = "SELECT * from ".$this->_table_name." where user_id=".$user_id." and status = 1";
        $result = $this->_dbh->query($query);
        $trans_data = array();
        while($row = mysqli_fetch_assoc($result))
        {
            $trans_data[] = $row;
        }
        return $trans_data;
    }


    public function retrieve_all_user_applied_jobs_by_user_id($user_id)
    {
        $query = "SELECT * from ".$this->_table_name." where user_id=".$user_id;
        $result = $this->_dbh->query($query);
        $trans_data = array();
        while($row = mysqli_fetch_assoc($result))
        {
            $trans_data[] = $row;
        }
        return $trans_data;
    }

    public function retrieve_user_jobs_by_id($id)
    {
        $query = "SELECT * from ".$this->_table_name." where id ='".$id."'";
        $result = $this->_dbh->query($query);
        $result_data = mysqli_fetch_assoc($result);
        if($result_data['id'] and !empty($result_data['id']))
        {
            return $result_data;
        }
        return false;
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


    public function approve_job($job_id)
    {

        $query = "UPDATE  ".$this->_table_name." SET status = 1 where id =".$job_id." ";

        $result = $this->_dbh->query($query);

        if($result)
        {
            return true;
        }
        return false;
    }

    public function reject_job($job_id)
    {

        $query = "UPDATE  ".$this->_table_name." SET status = 2 where id =".$job_id." ";

        $result = $this->_dbh->query($query);

        if($result)
        {
            return true;
        }
        return false;
    }

    public function under_review_job($job_id)
    {

        $query = "UPDATE  ".$this->_table_name." SET status = 3 where id =".$job_id." ";
        $result = $this->_dbh->query($query);

        if($result)
        {
            return true;
        }
        return false;
    }





}