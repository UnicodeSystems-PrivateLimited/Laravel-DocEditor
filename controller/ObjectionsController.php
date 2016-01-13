<?php

class ObjectionsController extends \BaseController {

    public function index() {
        $input = Input::all();
         $rules = array(
            'search' => 'required',
        );
         if(isset($input['search'])){
            $validator = Validator::make(Input::all(), $rules);
            if ($validator->passes()) {
              $obj =Objections::search($input);
            }  else {
              $obj =Objections::search(array());
            } 
         }  else {
              $obj =Objections::search(array());
         }
        return View::make('objections.list',array('data'=>$obj,'search'=>$input));
    }

    public function save() {
        $input = Input::all();
        $rules = array(
            'objection' => 'required',
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->passes()) { 
         $lastObj = Objections::saveObjection($input);
         Session::flash('success', 'Save Successfully');
         if(isset($input['switch_page']) && $input['switch_page']=='from_document'){
                return Response::json(array('success'=>TRUE,'id'=>$lastObj,'label'=>$input['objection']), 200);
         } else {
             return Redirect::to('objective');
         }
        }  else {
         return Redirect::to('objective')->withErrors($validator)->withInput();
        }
    }
    public function delete(){
        $input = Input::all();
        Objections::del($input);
        return Redirect::to('objective');
    }

}
