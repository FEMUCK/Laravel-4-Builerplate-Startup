@extends('admin.layouts.admin')

@section('main')

<div class="row">
	<div class="col-lg-12">
		<h1>ประเภทโพสท์ทั้งหมด</h1>

        @if ($errors->any())
        	<div class="alert alert-danger">
        	    <ul>
                    {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                </ul>
        	</div>
        @endif
    </div>
    <div class=" col-lg-4">
    <?php $parent_categories = Category::lists('name', 'id'); 
    	$parent_categories = [ '0' => 'ไม่มีประเภทหลัก'] + $parent_categories;
    	$category_id = Input::old('category_id') ? Input::old('category_id') : Input::get('category_id');
    	$submittext = isset($category) ? 'แก้ไข' : 'เพิ่มประเภทใหม่';
    ?>
    @if(!isset($category))
    	{{ Form::open(array('route' => 'admin..categories.store', 'class' => 'form-horizontal')) }}
	@else
		{{ Form::model($category, array('class' => 'form-horizontal', 'method' => 'PATCH', 'route' => array('admin..categories.update', $category->id))) }}
	@endif
		    <div class="panel panel-default">
		    	<div class="panel-heading">
		            เพิ่มประเภทโพสท์
		        </div>
		    	<div class="panel-body">
		    		<div class="form-group">
			            
			            <div class="col-sm-12">{{ Form::label('name_th', 'ชื่อภาษาไทย:', array('class'=>'control-label')) }}
			              {{ Form::text('name_th', Input::old('name_th'), array('class'=>'form-control', 'placeholder'=>'ชื่อภาษาไทย')) }}
			            </div>
			        </div>

		    		<div class="form-group">
			            <div class="col-sm-12">
			            {{ Form::label('name_en', 'ชื่อภาษาอังกฤษ:', array('class'=>'control-label')) }}
			              {{ Form::text('name_en', Input::old('name_en'), array('class'=>'form-control', 'placeholder'=>'ชื่อภาษาอังกฤษ')) }}
			            </div>
			        </div>

		    		<div class="form-group">
			            <div class="col-sm-12">
			            {{ Form::label('category_id', 'ประเภทหลัก:', array('class'=>'control-label')) }}
			              {{ Form::select('category_id', $parent_categories, $category_id, array('class'=>'form-control', 'placeholder'=>'ประเภทหลัก')) }}
			            </div>
			        </div>
				</div>
				<div class="panel-footer">
       				 {{ Form::submit($submittext, array('class' => 'btn  btn-primary', 'data-disable-with'=>"กำลังบันทึก...")) }}
	            </div>
		    </div>
		{{ Form::close() }}
    </div>

    <div class="panel col-lg-8">	
    	
		<div  class="tree well">
			<ul>
				<li><span><i class="fa fa-home fa-fw"></i>Root</span>
				<ul id="sortable">
		@if ($categories->count())
					@foreach ($categories as $category)
						
					<li>
						<span><i class="fa fa-tablet fa-fw"></i>{{{ $category->name }}}</span>
						<span>{{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('admin..categories.destroy', $category->id))) }}
		                        {{ Form::submit('Delete', array('class' => 'btn btn-danger btn-xs', 'data-confirm' => 'Are you sure?')) }}
		                    {{ Form::close() }}
		                    {{ link_to_route('admin..categories.edit', 'Edit', array($category->id), array('class' => 'btn btn-info btn-xs')) }}
		          		</span>
		          		<span>{{ link_to_route('admin..categories.create', 'เพิ่ม sub category', array('category_id' => $category->id), array('class' => 'btn btn-primary btn-xs')) }}</span>
					
		          		<?php $subcategories = Category::where('category_id', $category->id)->get(); ?>
		          		@if($subcategories->count() > 0 )
		          			<ul id="sortable">
		          			@foreach ($subcategories as $subcategory)
		          				<li>
		          				<span><i class="fa fa-tablet fa-fw"></i>{{{ $subcategory->name }}}</span>
												<span>{{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('admin..categories.destroy', $subcategory->id))) }}
				                        {{ Form::submit('Delete', array('class' => 'btn btn-danger btn-xs', 'data-confirm' => 'Are you sure?')) }}
				                    {{ Form::close() }}
				                    {{ link_to_route('admin..categories.edit', 'Edit', array($subcategory->id), array('class' => 'btn btn-info btn-xs')) }}
				          		</span>
		          				</li>
							@endforeach		
		          			</ul>
		          		@endif
					</li>
					@endforeach	
		@else
					<li>
						<span>ยังไม่มีประเภทโพสท์</span>
					</li>
		@endif	
				</ul>
				</li>
			</ul>
		</div>
    </div>
</div>
@stop
