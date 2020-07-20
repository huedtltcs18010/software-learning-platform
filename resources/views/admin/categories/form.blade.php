<div class="p-3">

    <div class="form-group row">
        {{ Form::label('name', 'Name', ['class' => 'col-sm-2 col-form-label']) }}
        <div class="col-sm-4">
            {{ Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) }}
        </div>
    </div>

    <div class="form-group row">
        {{ Form::label('description', 'Description', ['class' => 'col-sm-2 col-form-label']) }}
        <div class="col-sm-6">
            {{ Form::textarea('description', null, ['class' => 'form-control basic_editor']) }}
        </div>
    </div>

    <div class="form-group row">
        {{ Form::label('status', 'Status', ['class' => 'col-sm-2 col-form-label']) }}
        <div class="col-sm-3">
            {{ Form::select('status', [0 => 'Inactive', 1 => 'Active'], null, ['class' => 'form-control']) }}
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-2"></div>
        <div class="col-sm-3">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
        </div>
    </div>

</div>
