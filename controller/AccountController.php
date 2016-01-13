<?php

class AccountController extends \BaseController {

    /**
     * Display a dashboard page
     *
     * @return Response
     */
    public function dashboard() {
        $data=Document::listData();
        return View::make('account.dashboard',array('list'=>$data));
    }

    

}
