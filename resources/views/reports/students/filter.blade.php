
 <div class="form-group  pull-left col-md-3">
   {!! Form::label('faculity', 'Faculity ') !!}
    <?php $faculities[0] = 'Choose faculity' ?>
   {!! Form::select('faculity',$faculities,0, ['class'=>'form-control','id'=>'faculities']) !!}
   {!! $errors->first('faculity','<label class="has-error">:message</label>') !!} 
</div>

 <div id="department_section"  class="col-md-3 pull-left">
   {!! Form::label('Departments', 'Department') !!}
    
   {!! Form::select('department',['Select faculity first'],null ,
                   ['class'=>'form-control','id'=>'departments']) !!}
  </select>
  
 </div>
  
<div  id="department_level" class="col-md-2 pull-left">
   {!! Form::label('level', 'Level') !!}

   {!! Form::select('level',['Select department first'],null ,
                   ['class'=>'form-control','id'=>'departmentlevel']) !!}
</div>



<div class="col-md-2 pull-left">
{!! Form::label('search', ' ') !!}
  {!! Form::submit('Search', ['class' => 'form-control btn btn-success']) !!}

</div>
<div class="col-md-2 pull-left">
{!! Form::label('search', ' ') !!}
<a href="{!! URL::full() !!}{!! strpos(URL::full(),'?') ?'&':'/?' !!}export=1" class="form-control btn btn-success"> <i class="fa fa-file-excel-o"> </i> Export </a>
</div>