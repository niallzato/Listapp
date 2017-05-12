<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Redis;
use Illuminate\Http\Request;

class ListController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private function setItem($request){
        $quant = $request['quant'];
        $item = $request['name'];
        $list = $this->getItem();

        if (empty($list)){
            $list[$item] = $quant;
            $list = json_encode($list);
            Redis::set('list', $list);
        }
        else{
            $list = json_decode($list, true);
            $list[$item] = $quant;
            $list = json_encode($list);

            Redis::set('list', $list);
        }
        return;
    }

    public function getItem(){
        $name = Redis::get('list');
        return $name;
    }

    public function add(Request $request){
        $input = $request->all();
        $this->setItem($input);
        return;
    }

    public function delete(){
        Redis::del('list');
        dd(Redis::get('list'));
    }
}
