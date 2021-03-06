<?php


class jobs_table
{
    private $_dbh;
    private $_table_name = 'jobs';
    public function __construct()
    {
        $this->_dbh = new db_connection($this->_table_name);
    }



    public function retrieve_all_jobs()
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

    public function retrieve_all_jobs_with_cat_id($job_cat_id)
    {
        $query = "SELECT * from ".$this->_table_name." where job_cat = ".$job_cat_id;
        $result = $this->_dbh->query($query);
        $trans_data = array();
        while($row = mysqli_fetch_assoc($result))
        {
            $trans_data[] = $row;
        }
        return $trans_data;
    }

    public function retrieve_all_jobs_with_country_id($country_id)
    {
        $query = "SELECT * from ".$this->_table_name." where country_id = ".$country_id;
        $result = $this->_dbh->query($query);
        $trans_data = array();
        while($row = mysqli_fetch_assoc($result))
        {
            $trans_data[] = $row;
        }
        return $trans_data;
    }

    public function retrieve_all_jobs_with_keyword($keyword)
    {
        $query = "SELECT * from ".$this->_table_name." where job_title like '%".$keyword."%' ";
        $result = $this->_dbh->query($query);
        $trans_data = array();
        while($row = mysqli_fetch_assoc($result))
        {
            $trans_data[] = $row;
        }
        return $trans_data;
    }

    public function retrieve_all_jobs_with_country_id_and_cat_id($country_id, $job_cat_id)
    {
        $query = "SELECT * from ".$this->_table_name." where country_id = ".$country_id." and job_cat = ".$job_cat_id;
        $result = $this->_dbh->query($query);
        $trans_data = array();
        while($row = mysqli_fetch_assoc($result))
        {
            $trans_data[] = $row;
        }
        return $trans_data;
    }

    public function retrieve_all_jobs_with_all_parameters($country_id, $job_cat_id, $keyword)
    {
        $query = "SELECT * from ".$this->_table_name." where country_id = ".$country_id." and job_cat = ".$job_cat_id." and job_title like '%".$keyword."%' ";
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


    public function retrieve_job_by_id($job_id)
    {
        $query = "SELECT * from ".$this->_table_name." where id ='".$job_id."'";
        $result = $this->_dbh->query($query);
        $result_data = mysqli_fetch_assoc($result);
        if($result_data['id'] and !empty($result_data['id']))
        {
            return $result_data;
        }
        return false;
    }


    public function retrieve_all_jobs_with_company_id($company_id)
    {
        $query = "SELECT * from ".$this->_table_name." where company_id = ".$company_id;
        $result = $this->_dbh->query($query);
        $trans_data = array();
        while($row = mysqli_fetch_assoc($result))
        {
            $trans_data[] = $row;
        }
        return $trans_data;
    }


}