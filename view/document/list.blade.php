@section('main')
@extends('layouts.master')
<div class="row">
    <div class="panel panel-info no_box_shadow">
        <div class="panel-heading pull-left">
            <h3 class="panel-title bariol-thin">Documents</h3>
        </div>            
        <a class="btn btn-info pull-right btn-lg header_add"  href="{{ URL::to('document/add')}}">+</a>
        <div class="clear"></div>
        <div class="panel-body document_table">
            <div class="row">
                    {{Form::open(array('url' => 'document/action', 'id'=>"objections-list"))}}
                    <div class="table-responsive">
                        <table id="document_listing" class="table">
                        <thead>
                            <tr>                    
                                <th width="28%">Name</th>
                                <th width="24%">Case Name</th>
                                <th width="22%">Deadline</th>
                                <th width="15%">Reminder</th>
                                <th width="8%">
                                    <div class="dropdown">
                                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">Actions <i class="fa fa-angle-down"></i></a>
                                        <ul class="dropdown-menu">
                                          <li><a href="javascript:void(0);" id="remon-sel-all-del" data-url="{{URL::action('DocumentController@turn_on_reminder')}}">Turn On Reminder</a></li>
                                          <li><a href="javascript:void(0);" id="remoff-sel-all-del" data-url="{{URL::action('DocumentController@turn_off_reminder')}}">Turn Off Reminder</a></li>
                                          <li><a href="javascript:void(0);" id="doc-sel-all-del" data-url="{{URL::action('DocumentController@delete_all')}}">Delete</a></li>
                                        </ul>
                                      </div>
                                    
                                </th>
                                <th align="center" width="5%">
                                    <div class="checkboxOne">
  		                       <input type="checkbox" value="1" id="checkboxOneInput" name="" />
	  	                       <label for="checkboxOneInput">asdsd</label>
  	                            </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="document-list">
                            @foreach ($list as $doc)
                            <tr>
                                <td>{{ $doc->name }} </td>
                                <td>{{ $doc->case_name }} </td>
                                <td>@if($doc->deadline!='')
                                    <span style="color: @if(strtotime($doc->deadline)==strtotime(date('Y-m-d'))) red; @endif">{{date('M, jS  Y',  strtotime($doc->deadline))}}</span> 
                                    <a href="javascript:void(0);" class="ch_dp" data-id="{{$doc->id}}" data-date="{{$doc->deadline}}"><i class="fa fa-calendar"></i></a>
                                    @else ... @endif
                                </td>
                                <td>
                                    @if($doc->deadline)
                                    @if($doc->is_reminder_allow==1)
                                    <i class="fa fa-check-square"></i>
                                    @else
                                    <i class="fa fa-square-o"></i>
                                    @endif
                                    @endif
                                </td>
                                <td class="action">
                                    <a href="{{URL::action('DocumentController@delete',array('id'=>$doc->id))}}" class="glyphicon glyphicon-trash">
                                    </a>
                                    <a class="dev-objection-edit glyphicon glyphicon-pencil" data-toggle="modal"  href="{{URL::action('DocumentController@edit',array('id'=>$doc->id))}}" >                                        
                                    </a>
                                </td>
                                <td align="center"><input type="checkbox" name="allDoc[]" value="{{$doc->id}}"></td>
                            </tr>    
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="6" align="center">
                                   {{ $list->links()}}
                                   <a class="btn btn-info pull-right btn-lg add_doc_btn" href="{{ URL::to('document/add')}}">Add Document <span>+</span></a>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                  </div>
                    {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@stop