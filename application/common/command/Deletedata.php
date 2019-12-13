<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/8/14
 * Time: 19:44
 */

namespace app\common\command;


use think\console\Command;
use think\console\Input;
use think\console\Output;

class Deletedata extends Command
{



    protected function configure(){
        $this->setName('delete')
            ->setDescription("Delete table data")
            ->addArgument('str');
    }

    protected function execute(Input $input,Output $output)
    {
          $str = $input->getArgument('str');
          if($str=='127.0.0.1'){
              $output->warning('localhost');
               return ;
          }
          $output->warning($str.'arr');


    }

}