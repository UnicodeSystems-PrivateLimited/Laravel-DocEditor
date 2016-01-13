@section('main')
@extends('layouts.master')
<div class="row">
<!--    <div class="alert-box success">
        @if(Session::has('success'))
        <p class="success">{{ Session::get('success') }}</p>
        @endif
        @if($errors->first('objection'))
        <p class="error">{{ $errors->first('objection') }}</p>
        @endif
    </div>-->
<div class="panel panel-info no_box_shadow">
        <div class="panel-heading pull-left">
            <h3 class="panel-title bariol-thin">Standard Objections</h3>
        </div>
        <button type="button" class="btn btn-info pull-right btn-lg header_add" data-toggle="modal" data-target="#myObjectionsForm">+</button>
        <div class="clear"></div>
        <div class="panel-body document_table">
        {{Form::open(array('class'=>"form-horizontal" ,'role'=>"form",'id'=>"objections-list"))}}
        <div class="row">
            <div class="table-responsive">
                <table id="objections_table" class="table">
                <thead>
        
                    <tr>
                        <th class="ojection_search">
                            <span class="obj_txt">Objection</span> 
                            <span class="glyphicon glyphicon-search" onclick="$(this).closest('form').submit();"></span> | 
                            @if (isset($search['search']))
                            <input name="search" class="search-input" value="{{ $search['search'] }}" placeholder="Search Objections">
                            @else
                            <input name="search" class="search-input" value="" placeholder="Search Objections">
                            @endif
                        </th>
                        <th><a href="#" class="" id="obj-sel-all-del" data-url="{{URL::action('ObjectionsController@delete')}}" >Delete Selected</a> </th>
                        <th align="center">
                                    <div class="checkboxOne">
  		                       <input type="checkbox" value="1" id="checkboxOneInput" name="" />
	  	                       <label for="checkboxOneInput">&nbsp;</label>
  	                            </div>
                                </th>
                    </tr>

                </thead>
            <tbody id="objections-list">
                    @foreach ($data as $obj)
                    <tr>
                        <td>{{ $obj->objection }}</td>
                        <td><a class="glyphicon glyphicon-trash" href="{{URL::action('ObjectionsController@delete',array('id'=>$obj->id))}}"></a> 
                            <a class="dev-objection-edit glyphicon glyphicon-pencil" data-toggle="modal" data-target="#myObjectionsForm" href="#" data-id="{{ $obj->id }}"></a>          
                        </td>
                        <td><input type="checkbox" name="del[]" value="{{ $obj->id }}"></td>
                    </tr>    
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" align="center">
                            {{ $data->links()}}
                            <a style="padding-left:24px; padding-right:60px;" class="btn btn-info pull-right btn-lg add_doc_btn" href="#" data-toggle="modal" data-target="#myObjectionsForm">ADD STANDARD OBJECTIONS <span>+</span></a>                            
                        </td>
                    </tr>
                </tfoot>
            </table>
            </div>
            </div>
            {{ Form::close() }}
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
                    <button type="submit" name="submit" class="btn btn-primary ">Create</button>
                    <button type="button" class="btn btn-warning " data-dismiss="modal">Cancel</button>
                </div>
            </div>
            {{ Form::hidden('id')}}
        </div>
        {{ Form::close() }}
    </div>
</div>
@stop
