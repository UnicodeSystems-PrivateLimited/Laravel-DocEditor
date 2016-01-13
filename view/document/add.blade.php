    
@section('main')
@extends('layouts.master')
<div class="inner-container">
    <div class="drag-drop-section">
    {{Form::open(array('url' => 'document/upload','class'=>"dropzone form-horizontal" ,'role'=>"form", 'id'=>"my-awesome-dropzone"))}}
    {{ Form::close() }}
    <div class="text-center drag_contant">
        <a href="#" class="btn brown_btn">Browse for file</a>
        <div class="clear" style="height: 5px;"></div>
        <p class="small text_gray">Only "pdf" files supported</p>
    </div>
    </div>
 
    @if(!empty($list))
    <h2 class="background-heading">Recently Uploaded / Edited</h2>
    <div class="panel-body document_table">
            
        <div class="row">
                    {{Form::open(array('url' => 'document/action', 'id'=>"objections-list"))}}
                    <div id="drag_drop_table" class="table-responsive">
                        <table class="table">
                        <thead>
                            <tr>
                                <th>Documents</th>                                
                                <th>Posted</th>  
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="document-list">
                            @foreach ($list as $doc)
                            <tr>
                                <td>{{ $doc->name }} </td>
                                
                                <td><span>{{date('M, jS  Y',  strtotime($doc->created_at))}}</span> </td>
                                                                                                                                            
                                <td class="action">
                                    <a href="{{URL::action('DocumentController@delete1',array('id'=>$doc->id))}}" class="glyphicon glyphicon-trash">
                                    </a>
                                    <a class="dev-objection-edit glyphicon glyphicon-pencil" data-toggle="modal"  href="{{URL::action('DocumentController@edit1',array('id'=>$doc->id))}}" >                                        
                                    </a>
                                </td>
                            </tr>    
                            @endforeach
                        </tbody>
                        
                    </table>
                  </div>
                    {{ Form::close() }}
            </div>
        </div>
    @else
    
    <div class="text-center no_document_msg">
        {{ HTML::image('packages/users/images/file_con.png', 'New Document') }}
        <h3 class="text_gray f_jallaOneRegular">No Document Available Yet</h3>
        <p class="text_gray f_jallaOneRegular">Upload a document by dragging the pdf into the box above or upload<br> 
            using the "<a href="#" class="cantarellRegular">Browse for File</a>" button</p>
    </div>
    @endif
</div>
@stop