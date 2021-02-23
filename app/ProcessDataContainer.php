<?php

namespace App;

class ProcessDataContainer
{

    public function addData($data)
    {
        $connection = new ConnectionClass();
        return $connection->createData('todo_data', '(name,status,created_at,updated_at)', '("' . $data . '",1 ,NOW() , NOW() )');
    }

    public function editData($id, $data)
    {
        return $this;
    }

    public function deleteData($id)
    {
        return $this;
    }

    public function getData($status)
    {
        $connection = new ConnectionClass();
        if ($status == 2) {
            $datas = $connection->getData('todo_data', 'id is not null');
        } else {
            $datas = $connection->getSingleData('todo_data', 'status='.$status);
        }
        $data = [];
        foreach ($datas as $key => $row) {
            $data[$key]['id'] = $row[0];
            $data[$key]['name'] = $row[1];
            $data[$key]['status'] = $row[2];
        }
        return $data;
    }

}