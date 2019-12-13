<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/3/12
 * Time: 15:24
 */

namespace app\admin\controller;
use think\Controller;
use think\Db;
use app\admin\model\BankdemoModel;
class Bankdemo extends Base
{
    /**
     * Test列表
     * @return mixed
     */
    public function index()
    {
        //查询及返回数据
        if(request()->isAjax()){

            $param = input('param.');
            $limit = $param['pageSize'];
            $offset = ($param['pageNumber'] - 1) * $limit;

            $where = [];

            if (!empty($param['searchText'])) {
                $where[] = ['test1', 'like', '%' . $param['searchText'] . '%'];
            }
            $article = new BankdemoModel();
            $selectResult = $article->getArticlesByWhere($where, $offset, $limit);
            foreach($selectResult as $key=>$vo){
                $selectResult[$key]['id'] =  $vo['id'] ;
                $selectResult[$key]['operate'] = showOperate($this->makeButton($vo['id']));
            }

            $return['total'] = $article->getAllBankdemo($where);  //总数据
            $return['rows']  = $selectResult;
            return json($return);
        }
        return $this->fetch();

    }

    // 添加
    public function demoAdd() {

        if(request()->isPost()){
            $param = input('post.');
            unset($param['file']);
            $flag =  (new BankdemoModel())->addBankdemo($param);
            return $this->success($flag['msg'],$flag['data']);
        }
        return $this->fetch();
    }

    // 编辑
    public function bankdemoEdit() {

        if (request()->isPost()) {
            $param = input('post.');
            unset($param['file']);
            $flag = (new BankdemoModel())->editbankDemo($param);
            return $this->success($flag['msg'],$flag['data']);
        }

        $id = input('param.id');
        $this->assign([
            'bankdemo' => (new BankdemoModel())->getOneBankdemo($id),
        ]);
        return $this->fetch();
    }

    // 删除
    public function demoDel($id)
    {
        //软删除
        $data['id']=$id;
        if (BankdemoModel::destroy($data)) {
            $data['code'] = 1;
            $data['msg'] = '删除成功';
        } else {
            $data['code'] = 0;
            $data['msg'] = '删除失败';
        }
        return $data;

        /* //删除
           $role = new BankdemoModel();
           $flag = $role->delBankdemo($id);
           return json(msg($flag['code'], $flag['data'], $flag['msg']));
        */
    }


    /**
     * 删除选中订单
     * @return mixed
     */
    public function deleteMore()
    {
        if (request()->isAjax()) {
            $data = input('id/a');
            $delete_result = BankdemoModel::destroy($data);
            //$delete_result = BankdemoModel::where('id', 'in', $data)->delete();
            if ($delete_result) {
                $result['code'] = 1;
                $result['msg'] = '删除成功';
            } else {
                $result['code'] = 0;
                $result['msg'] = '删除失败';
            }
            return $result;
        }
    }


    /**
     * 拼装操作按钮
     * @param $id
     * @return array
     */
    private function makeButton($id)
    {
        return [
            '编辑' => [
                'auth' => 'bankdemo/bankdemoedit',
                'href' => url('bankdemo/bankdemoedit', ['id' => $id]),
                'btnStyle' => 'primary',
                'icon' => 'fa fa-paste'
            ],
            '删除' => [
                'auth' => 'bankdemo/demoDel',
                'href' => "javascript:demoDel(" .$id .")",
                'btnStyle' => 'danger',  //颜色
                'icon' => 'fa fa-trash-o' //标志
            ],
        ];
    }




}