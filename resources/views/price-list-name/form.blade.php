    {{ csrf_field() }}
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name" class="control-label">Price List Name</label>
                <input type="text" placeholder="Main Price List" class="form-control" id="name" name="name" required value="{{ $list->name or old('name') }}">

                @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="is_active" {{ $list->is_active or old('is_active') ? 'checked' : '' }}> Is Active?
                    </label>
                </div>
            </div>

        </div>

        <div class="col-sm-6">
            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                <label for="description" class="control-label">Description</label>
                <textarea rows="5" class="form-control" id="description" name="description">{{ $list->description or old('description') }}</textarea>

                @if ($errors->has('description'))
                    <span class="help-block">
                        <strong>{{ $errors->first('description') }}</strong>
                    </span>
                @endif
            </div>
        </div>

    </div>

    <div class="form-group">
        <input type="submit" class="btn btn-success" value="Save">
        <a href="{{ route('price-list-name.index') }}" class="btn btn-danger">Back</a>
    </div>




