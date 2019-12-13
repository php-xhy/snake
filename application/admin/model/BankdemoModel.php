<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/3/12
 * Time: 15:17
 */

namespace app\admin\model;
use app\admin\validate\BankdemoValidate;
use traits\model\SoftDelete;
use think\Model;
use think\Db;
use think\Validate;
class BankdemoModel extends Model
{

    use SoftDelete;
    protected $deleteTime = 'delete_time';
    // 确定链接表名
    protected $name = 'bankdemo';

    /**
     * 查询
     * @param $where
     * @param $offset
     * @param $limit
     */
    public function getArticlesByWhere($where, $offset, $limit)
    {
        return $this->where($where)->limit($offset, $limit)->order('id desc')->select();

    }

    /**
     * 根据搜索条件获取所有数据数量
     * @param $where
     */
    public function getAllBankdemo($where)
    {
        return $this->where($where)->count();
        //SELECT * FROM `s_bankdemo` WHERE  `test1` IN ('like','%嗯%') ORDER BY `id` DESC LIMIT 0,10
        //SELECT * FROM `snake_articles` WHERE `title` LIKE '%啦%' ORDER BY id desc LIMIT 0,10
    }

    /**
     * 添加
     * @param $param
     */
    public function addBankdemo($param)
    {
        try{
            $validate = validate('BankdemoValidate');
            if($validate->check($param))
            {
                $this->save($param);
                return msg(1, url('bankdemo/index'), 'ok');
            }else{
                // 验证失败 输出错误信息
                return msg(-1, '', $validate->getError());
            }

        }catch (\Exception $e){
            return msg(-2, '', $e->getMessage());
        }
    }

    /**
     * 编辑
     * @param $param
     */
    public function editbankDemo($param)
    {
        try {
            $validate = validate('BankdemoValidate');

            if ($validate->check($param))
            {
                $this->save($param, ['id' => $param['id']]);
                return msg(1, url('bankdemo/index'), 'ok');
            }else{
                // 验证失败 输出错误信息
                return msg(-1, '', $validate->getError());
            }
        } catch (\Exception $e) {
            return msg(-2, '', $e->getMessage());
        }

    }

    /**
     * 根据test的id 获取test的信息
     * @param $id
     */
    public function getOneBankdemo($id)
    {
        return $this->where('id', $id)->find()->toArray();
    }

    /**
     * 删除test
     * @param $id
     */
    public function delBankdemo($id)
    {
        try{

            $this->where('id', $id)->delete();
            return msg(1, '', 'ok');

        }catch(\Exception $e){
            return msg(-1, '', $e->getMessage());
        }
    }




}