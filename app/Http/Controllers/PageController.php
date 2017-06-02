<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use App\UserList;

class PageController extends BaseController
{
    public function renderLists($key = 'list'){
        $user = Auth::user();

        $listController = new ListController();
        $list = $listController->getItem();

        return view('lists', ['list' => $list]);
    }

}