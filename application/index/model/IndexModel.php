<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/8/6
 * Time: 12:54
 */

namespace app\index\model;

use think\Model;
use think\Db;

class IndexModel extends Model
{

    // 设置完整的数据表（包含前缀）
    //protected $table = 'snake_demo';

    // 确定链接表名
    protected $name = 'demo';

    /**
     * @param $id
     * @return array
     */
    public function getID($id){
        return $this->get($id)->toArray();

        //return $this->where('id', $id)->find()->toArray();
        // return IndexModel::get($id)->toArray();
    }
}