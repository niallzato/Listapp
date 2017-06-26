<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Redis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\UserList;
use function MongoDB\BSON\toJSON;

class ListController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $revision = '1.';
    //protected $ttl = 60*60*24*7;
    protected $ttl = 20;


    public function renderListTest($name){
        $user = Auth::user();
        $list = $this->getList($name);
        dd($list);
  //      return view('list');
//        //return view('list')->with('list', $list);
    }

    public function renderList($name){
        $user = Auth::user();
        $list = $this->getList($name);
        //dd($list);
        return view('list')->with('name', $name);
        //return view('list')->with('list', $list);
    }

    public function getLists($key = 'list'){
        $user = Auth::user();
        $lists = UserList::where('user_id', $user->id)->get()->toJson();

        return $lists;
    }


    public function getList($name){
        $user = Auth::user();
        $list = UserList::where('user_id', $user->id)->where('list_name',$name)->pluck('list')->toJson();

        return $list;
    }

    public function getItem($key = 'list', $name){
        $user = Auth::user();
        $list = Redis::get($this->revision.$user->id.$key.$name);
        if (empty($list)){
            $list = $this->getDB();
        }
        return $list;
    }

    public function add(Request $request, $name){
        $input = $request->all();
        $this->setFromPost($input, $name);
        return;
    }

    public function deleteItem(Request $request){
        $input = $request->all();
        $key = $input['name'];
        $this->deleteFromItem($key);
        return;
    }

    public function deleteList(){
        $user = Auth::user();
        Redis::del($this->revision.$user->id.'list');
        $this->delDB();
        return;
    }

    public function addList(Request $request){
        $input = $request->all();
        $key = $input['name'];
        $this->createListDB($key);
        return;
    }

    private function createListDB($key){
        $user = Auth::user();
        $userList = UserList::create(['user_id' => $user->id, 'list_name' => $key, 'list' => 'd']);

        $userList->save();
        return;
    }

    private function deleteFromItem($index){
        $user = Auth::user();
        $list = $this->getItem();
        $list = json_decode($list, true);
        unset($list[$index]);
        $list = json_encode($list);
        Redis::set($this->revision.$user->id.'list', $list);
        Redis::expire($this->revision.$user->id.'list', $this->ttl);
        $this->setDB($list);
        return;
    }

    private function setFromPost($request, $name){
        $user = Auth::user();
        $quant = $request['quant'];
        $item = $request['name'];
        $list = $this->getItem($name);

        if (empty($list)){
            $list[$item] = $quant;
            $list = json_encode($list);
        }
        else{
            $list = json_decode($list, true);
            $list[$item] = $quant;
            $list = json_encode($list);
        }
        Redis::set($this->revision.$user->id.'list', $list);
        Redis::expire($this->revision.$user->id.'list', $this->ttl);
        $this->setDB($list);
        return;
    }

    private function setDB($list){
        $user = Auth::user();
        $userList = UserList::updateOrCreate(['user_id' => $user->id], ['list' => $list]);

        $userList->save();
        return;
    }

    private function getDB(){
        $user = Auth::user();
        $list = UserList::where('user_id', $user->id)->first();
        Redis::set($this->revision.$user->id.'list', $list->list);

        return $list->list;
    }

    private function delDB(){
        $user = Auth::user();
        $userList = UserList::updateOrCreate(['user_id' => $user->id], ['list' => '']);

        $userList->save();
        return;
    }

}
