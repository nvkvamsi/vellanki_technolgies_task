
@if (!isset($elements))
    <div class="alert alert-danger" role="alert">
        Elements are required
    </div>
@else

    @foreach ($elements as $element)
        @if($element['method'] === 'input')
            <div class="form-group mt-2">
                <label for="{{ $element['key'] }}">
                    {{ $element['label'] }}
                    @if(isset($element['required']) && $element['required'])
                        <span style="color: red">*</span>
                    @endif
                </label>
                <input 
                    class="form-control myInput" 
                    autocomplete="off" 
                    type="{{ $element['type'] }}" 
                    placeholder="{{ $element['place_holder'] }}" 
                    name="{{ $element['key'] }}" 
                    value="{{ isset($data) ? $data->{$element['key']} : '' }}" 
                    id="{{ $element['key'] }}" 
                    @if(isset($element['required']) && $element['required']) required @endif
                    @if(isset($element['readonly']) && $element['readonly']) readonly @endif
                >
            </div>
        @elseif($element['method'] === 'text-area')
            <div class="form-group mt-2">
                <label for="{{ $element['key'] }}">
                    {{ $element['label'] }}
                    @if(isset($element['required']) && $element['required'])
                        <span style="color: red">*</span>
                    @endif
                </label>
                <textarea class="form-control myInput" placeholder="{{ $element['place_holder'] }}" id="{{ $element['key'] }}" name="{{ $element['key'] }}" @if(isset($element['required']) && $element['required']) required @endif> {{ isset($data) ? $data->{$element['key']} : '' }}</textarea>
            
            </div>
        @endif
    @endforeach


@endif