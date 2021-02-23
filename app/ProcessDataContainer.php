<?php

namespace App;

class ProcessDataContainer
{

    public function addData($data)
    {
        $connection = new ConnectionClass();
        return $connection->createData('todo_data', '(name,status,created_at,updated_at)', '("' . $data . '",1 ,NOW() , NOW() )');
    }

    public function editData($id)
    {
        return $this;
    }

    public function deleteData($id, $doneData = 'aceNaki')
    {
        $connection = new ConnectionClass();
        if ($doneData!='aceNaki') {
            return $connection->deleteData('todo_data', 'status=' . $doneData);
        } else {
            return $connection->deleteData('todo_data', 'id=' . $id);
        }
    }

    public function getData($status)
    {
        $connection = new ConnectionClass();
        $data = [];
        $datas = null;
        if ($status == 2) {
            $datas = $connection->getData('todo_data', 'id is not null');

        } else {
            $datas = $connection->getData('todo_data', 'status=' . $status);
        }
        foreach ($datas as $key => $row) {
            $data[$key]['id'] = $row[0];
            $data[$key]['name'] = $row[1];
            $data[$key]['status'] = $row[2];
        }
        return $data;
    }

}