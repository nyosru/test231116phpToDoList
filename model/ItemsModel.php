<?php

namespace model;

use controller\service\dbService;

class ItemsModel extends \controller\service\dbService
{

    public function getPages($on_page, $now_page = 1): array
    {
        $res = $this->getCount('Task');
        $res['max'] = ceil($res['count']/$on_page);
        $res['now'] = $now_page  <= $res['max'] ? $now_page  : 1;

        $res['links'] = [];
        for( $i = 1; $i <= $res['max']; $i++ ) {
            $res['links'][] = [
                'link' => 'page='.$i,
                'number' => $i,
                'active' => $i == $res['now']
            ];
        }

        return $res;
    }

    public function getItems($page=1): array
    {
        $res = $this->getData('Task',null, $page);
        return $res;
    }

    /**
     * @param array $data [ 'title' ==> string 200 , 'mail' => string 200, 'opis' TEXT, finished BOOL ]
     * @return void
     */
    public function add(array $data)
    {
        $this->insert('Task', $data);
    }

    public function deleteItem(int $id)
    {
        $this->delete('Task', $id);
    }

    /**
     * @param int $id
     * @param array $update данные что обновим ( ключ значение )
     * @return void
     */
    public function updateItem(int $id, array $update ): void
    {
        $this->update('Task', $id, $update);
    }

}