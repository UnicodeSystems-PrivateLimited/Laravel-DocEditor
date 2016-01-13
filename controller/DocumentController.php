<?php

class DocumentController extends \BaseController {

    public function index() {
        $data = Document::listData();
        return View::make('document.list', array('list' => $data));
    }

    public function add() {
        $data = Document::listData1();
        return View::make('document.add',array('list' => $data));
    }

    public function edit($id = '') {
        $data = Document::find($id);
        $document = $data->converted_name;
        $fileNameSent = basename($document, ".docx");
        $path = asset('/uploads/compiled_html');
        $htmlName = $path . '/'. $fileNameSent . '.html';
        $obj=Objections::getObj();
        $foo=Footer::getObj();
        $fileData = '';
        $fileData=file_get_contents($htmlName);
        return View::make('document.edit', array('file' => $fileData, 'id' => $id,'docData'=>$data,'obj'=>$obj,'foo'=>$foo));
    }
    public function edit1($id = '') {
        $data = Document::find($id);
        $document = $data->converted_name;
        $fileNameSent = basename($document, ".pdf");
        $path = asset('/uploads/compiled_html');
        $htmlName = $path . '/'. $fileNameSent . '.html';
        $obj=Objections::getObj();
        $foo=Footer::getObj();
        $fileData=file_get_contents($htmlName);
        return View::make('document.edit', array('file' => $fileData, 'id' => $id,'docData'=>$data,'obj'=>$obj,'foo'=>$foo));
    }

    public function delete() {
        $input = Input::all();
        if (isset($input['id']) && $input['id'])
            Document::find($input['id'])->delete();
        return Redirect::to('document');
    }
    public function delete1() {
        $input = Input::all();
        if (isset($input['id']) && $input['id'])
            Document::find($input['id'])->delete();
        return Redirect::to('document/add');
    }
    
    public function delete_all() {
        $input = Input::all();
        Document::delAll($input);
        return Redirect::to('document');
    }
    public function turn_on_reminder() {
        $input = Input::all();
        Document::updatOnAll($input);
        return Redirect::to('document');
    }
    public function turn_off_reminder() {
        $input = Input::all();
        Document::updatOffAll($input);
        return Redirect::to('document');
    }
    
    public function write() {
        $input = Input::all();
        $data = Document::find($input['id']);
         $document = $data->converted_name;
        $fileNameSent = basename($document, ".pdf");
        $saveFile= public_path() . '/uploads/compiled_html/'. $fileNameSent.'.html';
        if(isset($input['frameData'])&&$input['frameData']){
        $ff = fopen($saveFile, 'w');
            fwrite($ff, $input['frameData']);
            fclose($ff);
        }
        $modifiedFile = public_path() . '/uploads/compiled_html/'. $fileNameSent.'.html';
        $document_name = (!empty($data->document_name))?$data->document_name:$data->name;
        $downloadUrl  = Document::updateHtmlGoogleDoc($document_name,$modifiedFile,$data->google_doc_id,$input['id']);
        $data->case_name=$input['case_name'];
        $data->document_name=$input['document_name'];
        if(isset($input['objections_id'])&&$input['objections_id'])
        $data->objections_id=$input['objections_id'];
        if(isset($input['deadline'])&&$input['deadline'])
        $data->deadline=$input['deadline'];
        if(isset($input['is_reminder_allow'])&& $input['is_reminder_allow']){
            $data->is_reminder_allow=1;
        } else {
            $data->is_reminder_allow=0;
        }
        if(isset($input['footer_id'])&&$input['footer_id'])
        $data->footer_id=$input['footer_id'];
       // echo $data->is_reminder_allow;exit;
        $data->save();
        if($input['footer_id']){
             $footerData = Footer::find($input['footer_id']);
             Document::docScriptRun($data->google_doc_id,$footerData->footer);
        }
       
        
        //Document::docScriptRun($data->google_doc_id);
        //exit;
        //$convertedData = Document::HtmlToDocUpload($saveFile);
        return Redirect::to('document/edit/'.$data->id);
    }

    public function upload() {
//        $target_file=storage_path().'/document/'.Input::file('file')->getClientOriginalName();
//        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
//             Document::saveDoc(time().Input::file('file')->getClientOriginalName());
//         }  
        $input = Input::all();
        $mimeType = array('application/zip','application/msword','application/pdf','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','application/vnd.ms-office','application/vnd.ms-excel','application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        
        $file = Input::file('file');
       
        if (!in_array($file->getMimeType(), $mimeType)) {
            return Response::json('Unsupported file type.', 400);
        }
        $filename = str_random(12);
        $origFilename = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
         if(in_array($extension, array('doc','docx'))){
            $destinationPath = public_path() . '/uploads/docs';
        } else {
            $destinationPath = public_path() . '/uploads/pdf';
        }
        $upload_success = Input::file('file')->move($destinationPath, $filename . '.' . $extension);
        sleep(5);
        if ($upload_success) {
            $id = Document::saveDoc($origFilename, $filename, $extension);
            return Response::json(array('success' => 200, 'id' => $id));
        } else {
            return Response::json('error', 400);
        }
        
    }

    function getClient() {
        $client = new Google_Client();
        $client->setApplicationName(APPLICATION_NAME);
        $client->setScopes(array('https://www.googleapis.com/auth/drive'));
        $client->setClientId('854111737727-shq9f7hus9goo57ve38lpdn1v2v6i5qc.apps.googleusercontent.com');
        $client->setClientSecret('-3pT2W-uRYVGpuGBszHfhoT7');
        $client->setRedirectUri('http://localhost/beta/google-api-php-client/googleDrive.php');
        $client->setAccessType('offline');
        //  $client->setApprovalPrompt('force');
        $credentialsPath = $this->expandHomeDirectory(CREDENTIALS_PATH);
        if (file_exists($credentialsPath)) {
            $accessToken = file_get_contents($credentialsPath);
        } else {
            // Request authorization from the user.
            $authUrl = $client->createAuthUrl();
            if (!isset($_GET['code'])) {
                /*    Location */
//                header('Location:' . $authUrl);
                return Redirect::to($authUrl);
            }
            $authCode = trim(fgets(STDIN));
            // Exchange authorization code for an access token.
            $accessToken = $client->authenticate($_GET['code']);
            // Store the credentials to disk.
            if (!file_exists(dirname($credentialsPath))) {
                mkdir(dirname($credentialsPath), 0700, true);
            }
            file_put_contents($credentialsPath, $accessToken);
        }
        $client->setAccessToken($accessToken);

        // Refresh the token if it's expired.
        if ($client->isAccessTokenExpired()) {
            $client->refreshToken($client->getRefreshToken());
            file_put_contents($credentialsPath, $client->getAccessToken());
        }
        return $client;
    }

    function expandHomeDirectory($path) {
        $homeDirectory = getenv('HOME');
        if (empty($homeDirectory)) {
            $homeDirectory = getenv("HOMEDRIVE") . getenv("HOMEPATH");
        }
        return str_replace('~', realpath($homeDirectory), $path);
    }
    
//    public function export($id=''){
//        $data = Document::find($id);
//        $document_name = (!empty($data->case_name))?$data->case_name:$data->document_name;
//        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
//        header("Content-Disposition: attachment; filename=$document_name.docx");
//        header("Content-Transfer-Encoding: binary");
//        header("Content-Length: ".filesize($data['google_expo_link']));
//        readfile("$htmlName");
//    }
    
    public function deadline_update()
    {
        $updateId = Input::get('updateId');
        $changedDate = Input::get('changedDate');
        $formatedDate = date("M, jS  Y",strtotime($changedDate));
        $document = Document::find($updateId);
        $document->deadline = $changedDate;
        if($document->save()){
            $suData = array('success'=>true);
        }
        echo json_encode($suData);
        exit();
    }
    
    public function save_footer()
    {
        $input = Input::all();
        $rules = array(
            'footer_preset' => 'required',
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->passes()) { 
         $lastObj = Footer::saveFooter($input);
         Session::flash('success', 'Save Successfully');
         return Response::json(array('success'=>TRUE,'id'=>$lastObj,'label'=>$input['footer_preset']), 200);
        }  else {
         return Redirect::to('objective')->withErrors($validator)->withInput();
        }
    }
    public function reminder_mail(){
//        $data=DB::table('users')
//        ->join('document',function($j){ $j->on('users.id', '=', 'document.user_id')->where('document.is_reminder_allow', '=', 1);})
//        ->select('email', 'is_reminder_allow','case_name', 'document_name','deadline')
//        ->where('document.deadline','=',date('Y-m-d'))
//        ->get();
//        try {
//         foreach ($data as $key => $v) {
//          Mail::send('email.reminder', array('case_name' => $v->case_name,'doc_name'=>$v->document_name), function($message) use ($v) {
//              $message->to($v->email,'Doc')->subject('Reminder');
//           });
//         }
//        } catch (Exception $exc) {
//        }
         $data=DB::table('users')
        ->join('document',function($j){ $j->on('users.id', '=', 'document.user_id')->where('document.is_reminder_allow', '=', 1);})
        ->select('email', 'first_reminder_time','first_reminder_duration', 'second_reminder_time','second_reminder_duration','case_name','document_name','deadline')
        ->get();
         try {
         foreach ($data as $key => $v) {
          if($v->deadline){
              $flag=FALSE;
              $Date = date('Y-m-d');
              $firstRimnder=$secondRimnder=NULL;
              if($v->first_reminder_time&&$v->first_reminder_duration)
              $firstRimnder = date('Y-m-d', strtotime('+'.$v->first_reminder_time.' '.$v->first_reminder_duration, strtotime($Date)));
              if($v->second_reminder_time&&$v->second_reminder_duration)
              $secondRimnder= date('Y-m-d', strtotime('+'.$v->second_reminder_time.' '.$v->second_reminder_duration, strtotime($Date)));
            if($firstRimnder&&(strtotime($v->deadline)==strtotime(date('Y-m-d', strtotime($firstRimnder))))){
                 $flag=TRUE;
             } else if($secondRimnder&&(strtotime($v->deadline)==strtotime(date('Y-m-d', strtotime($secondRimnder))))){
                 $flag=TRUE;
            }elseif (strtotime($Date)==strtotime($v->deadline)) {
                 $flag=TRUE;
            }
            if($flag){
           Mail::send('email.reminder', array('case_name' => $v->case_name,'doc_name'=>$v->document_name), function($message) use ($v) {
              $message->to($v->email,'Doc')->subject('Reminder');
          });}
          }
         }
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
      exit;
    }
   
    public function show_reminder()
    {
        $documents = Document::getFirstReminder();
        return(json_encode($documents));
    }
    
     public function show_reminder_2()
    {
        $documents = Document::getSecondReminder();
        return(json_encode($documents));
    }

}
