@section('main')
@extends('layouts.master')

<div class="row">
    <div class="panel panel-info clearfix">
        <div class="col-lg-12">
            {{Form::open(array('url'=>'document/write','class'=>"form-horizontal" ,'role'=>"form",'id'=>"document-edit"))}}
            <div class="row">
            <div class="col-lg-6 col-md-6">
                <div id="text_editor" class="row">
                    <div class="panel panel-info no_box_shadow">        
                        <div class="maine_heading_cont">
                            <div class="panel-heading">
                               <h3 class="panel-title bariol-thin">Tools </h3>
                            </div>
                            <input class="btn btn-primary save_btn" name="submit" type="submit" value="Save"/>
                            <a class="btn btn-default" target="_blank" href="{{$docData->google_expo_link}}" type="button">Export {{ HTML::image('packages/users/images/export_icon.png', 'Export') }}</a>                       
                        </div>
                    <div class="clear"></div>
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                            <div class="panel panel-default no_box_shadow">                              
                                <a class="panel_acordian" role="button" data-toggle="collapse" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                   <i class="fa fa-minus-square"></i><i class="fa fa-plus-square"></i>Standard Objections
                              </a>                                
                              <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
                                            <select class="selectpicker objection_selectpicker" name="objections_id">
                                                <option value="0">Add Standard Objections</option>
                                         @foreach ($obj as $o)
                                         <option value="{{$o->id}}" 
                                                 @if($docData->objections_id==$o->id)
                                                 selected="selected"
                                                  @endif
                                                 >{{$o->objection}}</option>
                                         @endforeach
                                       </select>
                                       </div>
                                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                            <button type="button" class="btn muted_btn" data-toggle="modal" data-target="#myObjectionsForm"><i class="fa fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                              </div>
                            </div>
                     
                            <div class="panel panel-default no_box_shadow">                              
                                <a class="panel_acordian" role="button" data-toggle="collapse" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                   <i class="fa fa-minus-square"></i><i class="fa fa-plus-square"></i>Copy Tools</a>                                
                              <div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                <div class="panel-body edit-tools">                                    
                                    <ul class="clearfix">
                                            <li>
                                                <span onclick="ifFormate(0)" aria-hidden="true" class="text-bold well" ent="bold"></span>
                                            </li>
                                            <li>
                                                <span onclick="ifFormate(1)" aria-hidden="true" class="text-italic well"></span>
                                            </li>
                                            <li>
                                                <span onclick="ifFormate(3)" aria-hidden="true" class="text-underline well"></span>
                                            </li>
                                            <li>
                                                <span onclick="ifFormate(8)" aria-hidden="true" class="text-strike well"></span>
                                            </li>
                                            <li>
                                                <span onclick="ifFormate(7)" aria-hidden="true" class="text-subscript well"></span>
                                            </li>
                                            <li>
                                                <span onclick="ifFormate(6)" aria-hidden="true" class="text-superscript well"></span>
                                            </li>
                                            <li>
                                                <span onclick="ifFormate(14)" aria-hidden="true" class="text-list-ol well"></span>
                                            </li>
                                            <li>
                                                <span onclick="ifFormate(15)" aria-hidden="true" class="text-list well"></span>
                                            </li>                                            
                                            <li>
                                                <span onclick="ifFormate(13)" aria-hidden="true" class="text-indent well"></span>
                                            </li>
                                            <li>
                                                <span onclick="ifFormate(16)" aria-hidden="true" class="text-outdent well"></span>
                                            </li>
                                            <li>
                                                <span onclick="ifFormate()" aria-hidden="true" class="text-blockqoute well"></span>
                                            </li>
                                            <li>
                                                <span onclick="ifFormate(11)" aria-hidden="true" class="text-align-left well"></span>
                                            </li>
                                            <li>
                                                <span onclick="ifFormate(12)" aria-hidden="true" class="text-align-right well"></span>
                                            </li>                                            
                                            <li>
                                                <span onclick="ifFormate(9)" aria-hidden="true" class="text-align-center well"></span>
                                            </li>
                                            <li>
                                                <span onclick="ifFormate(10)" aria-hidden="true" class="text-align-justify well"></span>
                                            </li>
                                            
                                            <li>
                                                <span onclick="ifFormate(17)" aria-hidden="true" class="text-attachment well"></span>
                                            </li>                                            
                                            <li>
                                                <span onclick="ifFormate(4)" aria-hidden="true" class="text-undo well"></span>
                                            </li>
                                            <li>
                                                <span onclick="ifFormate(5)" aria-hidden="true" class="text-redo well"></span>
                                            </li>
                                            <li>
                                                <select class="selectpicker "><option>STYLES</option></select>
                                            </li>
                                        </ul>
                                </div>
                              </div>
                            </div>
                    
                            <div class="panel panel-default no_box_shadow">                              
                                <a class="panel_acordian" role="button" data-toggle="collapse" href="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                                   <i class="fa fa-minus-square"></i>
                                   <i class="fa fa-plus-square"></i>
                                   Case Name <small class="text-muted">(required)</small>                                   
                                </a>                                
                              <div id="collapseThree" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                <div class="panel-body">
                                    <input type="text" placeholder="case name..." name="case_name" value="{{$docData->case_name}}">
                                </div>
                              </div>
                            </div>
                     
                            <div class="panel panel-default no_box_shadow">                              
                                <a class="panel_acordian" role="button" data-toggle="collapse" href="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                                   <i class="fa fa-minus-square"></i>
                                   <i class="fa fa-plus-square"></i>
                                   Document Name <small class="text-muted">(required)</small>                                   
                                </a>                                
                              <div id="collapseFour" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                <div class="panel-body">
                                    <input type="text" placeholder="document name..." name="document_name" value="{{$docData->document_name}}">
                                </div>
                              </div>
                            </div>
                    
                            <div class="panel panel-default no_box_shadow">                              
                                <a class="panel_acordian" role="button" data-toggle="collapse" href="#collapseFive" aria-expanded="true" aria-controls="collapseFive">
                                   <i class="fa fa-minus-square"></i>
                                   <i class="fa fa-plus-square"></i>
                                   Deadline                                   
                                </a>                                
                              <div id="collapseFive" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                <div class="panel-body row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"><input type="text" data-provide="datepicker" value="{{$docData->deadline}}" name="deadline" class="date-picker" placeholder="select deadline...">
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="text_line_height">
                                            <span class="pull-left">Send a reminder:</span> 
                                            <div class="checkboxOne">
                                             <input type="checkbox" name="is_reminder_allow" id="checkboxOneInput" value="1" @if($docData->is_reminder_allow==1) checked="checked" @endif>
                                             <label for="checkboxOneInput">a</label>
                                            </div>
                                        </div>
                                   </div>
                              </div>
                            </div>
                    
                            <div class="panel panel-default no_box_shadow">                              
                                <a class="panel_acordian" role="button" data-toggle="collapse" href="#collapseSix" aria-expanded="true" aria-controls="collapseSix">
                                   <i class="fa fa-minus-square"></i>
                                   <i class="fa fa-plus-square"></i>
                                   Search &amp; replace                                   
                                </a>                                
                              <div id="collapseSix" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12"><input type="text" id="searchInDoc" name="search" class="" placeholder="search..."></div>
                                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                            <button type="button" class="btn muted_btn " onclick="ifFormate(18,this)">{{ HTML::image('packages/users/images/editor_find.png', 'Search') }}</button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-7 col-md-6 col-sm-7 col-xs-12"><input type="text" id="replaceWith" name="replace" class="" placeholder="replace with..."></div>
                                        <div class="col-lg-5 col-md-6 col-sm-5 col-xs-12">
                                            <button type="button" onclick="replaceAll()" class="btn muted_btn">All</button>
                                            <button type="button" onclick="replaceOneByOne()" class="btn muted_btn dev-search-replace">Replace</button>                                            
                                        </div>
                                    </div>                     
                                </div>
                              </div>
                            </div>
                  
                            <div class="panel panel-default no_box_shadow">                              
                                <a class="panel_acordian" role="button" data-toggle="collapse" href="#collapseSeven" aria-expanded="true" aria-controls="collapseSeven">
                                   <i class="fa fa-minus-square"></i>
                                   <i class="fa fa-plus-square"></i>
                                   Footer preset                                   
                                </a>                                
                              <div id="collapseSeven" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                <div class="panel-body">
                                    
                                    <div class="row">
                                        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
                                            <select class="selectpicker footer_selectpicker" name="footer_id">
                                                <option value="">select a preset...</option>
                                           @foreach ($foo as $fo)
                                         <option value="{{$fo->id}}" 
                                                 @if($docData->footer_id==$fo->id)
                                                 selected="selected"
                                                  @endif
                                                 >{{$fo->footer}}</option>
                                         @endforeach
                                        </select>
                                       </div>
                                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                            <button type="button" class="btn muted_btn add_footer" data-toggle="modal" data-target="#myfooterForm"><i class="fa fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                              </div>
                            </div>
                     </div>
                    
                    
                    </div>
                </div>                
                
            <!--<input type="hidden" id="frameData" name="frameData">-->
            <input type="hidden" name="id" value="{{$id}}">
            </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <a class="btn btn-primary pull-right" id="previewDocBtn" iframeUrl="{{$docData->google_embed_link}}" data-toggle="modal" data-target="#previewDoc">Preview <i class="fa fa-eye"></i></a>
                <div class="clear"></div>
                <div class="loading">{{ HTML::image('packages/users/images/loading.gif') }}</div>
                <textarea id="docEditor" name="frameData" style="visibility: hidden;">{{$file}}</textarea>
                
            </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
 <!-- Objective Form -->
    <div id="myObjectionsForm" class="modal fade" role="dialog">
        {{Form::open(array('url' => 'objections/save','class'=>"form-horizontal" ,'role'=>"form", 'id'=>"objections-form"))}}
        <div class="modal-dialog add_objection">
            <div class="modal-content">
                <div class="modal-body">
                    <textarea class="form-control" name="objection" placeholder="standard objection..."></textarea>
                </div>
                <div class="modal-footer">
                    <input type="hidden" value="from_document" name="switch_page">
                    <input type="hidden" value="{{$id}}" name="doc_id">
                    <button type="submit" name="submit" id="add_objection" class="btn btn-primary ">Create</button>
                    <button type="button" class="btn btn-warning " data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
        {{ Form::close() }}
    </div>
 
 <!-- Objective Form -->
    <div id="myfooterForm" class="modal fade" role="dialog">
        {{Form::open(array('url' => 'document/footer','class'=>"form-horizontal" ,'role'=>"form", 'id'=>"footer-form"))}}
        <div class="modal-dialog add_objection">
            <div class="modal-content">
                <div class="modal-body">
                    <textarea class="form-control" name="footer_preset" placeholder="Footer Presets..."></textarea>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="submit" id="add_footer" class="btn btn-primary ">Create</button>
                    <button type="button" class="btn btn-warning " data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
        {{ Form::close() }}
    </div>
 
 <div id="previewDoc" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close pull-right" data-dismiss="modal">&times;</button>
          <a class="btn btn-default pull-right" target="_blank" href="{{$docData->google_expo_link}}" type="button">Export {{ HTML::image('packages/users/images/export_icon.png', 'Export') }}</a>        
        <h4 class="modal-title">@if($docData->document_name) {{$docData->document_name}} @else {{$docData->name}} @endif</h4>
      </div>
      <div class="modal-body">
             <div id="iouter">
                 <div class="iinner">
<iframe src="" id="fiframe" width="900px" height="700" align="center"></iframe>
                 </div>
          </div>
        
      </div>
    </div>

  </div>
</div>
 
 
<!-- <div id="previewDoc" class="modal fade" role="dialog">
     <div>sdfsdfsdfsdfd</div>
     <iframe src="" id="fiframe" width="60%" height="80%" align="center"></iframe>
 </div>-->
<script type="text/javascript">
//var _theframe = document.getElementById("fiframe");
//_theframe.contentWindow.location.href = _theframe.src; 

</script>
<style>
  
  
</style>
@stop