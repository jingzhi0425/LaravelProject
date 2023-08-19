@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.product.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.product.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.product.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}">
                @if($errors->has('name'))
                <div class="invalid-feedback">
                    {{ $errors->first('name') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.product.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="bar_code_id">{{ trans('cruds.product.fields.bar_code_id') }}</label>
                <input class="form-control {{ $errors->has('bar_code_id') ? 'is-invalid' : '' }}" type="text" name="bar_code_id" id="bar_code_id" value="{{ old('bar_code_id', '') }}">
                @if($errors->has('bar_code_id'))
                <div class="invalid-feedback">
                    {{ $errors->first('bar_code_id') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.product.fields.bar_code_id_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="image_id">{{ trans('cruds.product.fields.image_id') }}</label>
                <select class="form-control select2 {{ $errors->has('image_id') ? 'is-invalid' : '' }}" name="image_id" id="image_id">
                    @foreach($images as $id => $entry)
                    <option value="{{ $id }}" {{ old('image_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('image_id'))
                <div class="invalid-feedback">
                    {{ $errors->first('image_id') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.product.fields.image_id_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="product_category_id">{{ trans('cruds.product.fields.product_category_id') }}</label>
                <select class="form-control select2 {{ $errors->has('product_category_id') ? 'is-invalid' : '' }}" name="product_category_id" id="product_category_id">
                    @foreach($product_categorys as $id => $entry)
                    <option value="{{ $id }}" {{ old('product_category_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('product_category_id'))
                <div class="invalid-feedback">
                    {{ $errors->first('product_category_id') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.product.fields.product_category_id_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('is_active') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="is_active" value="0">
                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', 0) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">{{ trans('cruds.product.fields.is_active') }}</label>
                </div>
                @if($errors->has('is_active'))
                <div class="invalid-feedback">
                    {{ $errors->first('is_active') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.product.fields.is_active_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>

@endsection