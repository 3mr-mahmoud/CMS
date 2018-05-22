@extends('control.layout.default')
@section('form-title',__('labels.generalData'))  
@section('form')
            <form method="post">
                @include('components.localeSelector')
                @include('components.meta_description')
                @include('components.emails')
                <div class="form-group">
                    <label for="telephoneInput">{{ __('Validation.attributes.phonenumbers') }}</label>
                    <input class="form-control" id="telephoneInput" />
                    <ul id="telephoneList">
                    </ul>
                    <input name="telephones" type="hidden" id="telephonesArray">
                </div>
                <a href="javascript:void(0)" class="button btn-success" onclick="save(this)">@lang('labels.save')</a>
            </form>
@endsection

@section('js')
<script>
    var globalIndex = -1;
    window.telephones = [];
    input = document.querySelector("#telephoneInput");
    input.addEventListener('keyup', function(event){

        event.preventDefault();

        if(event.keyCode == 13) {
            addToList(this.value);
        }
    });
    function addToList(value) {
        input.value = '';
        globalIndex++;
        append(value);
        telephones.push(value);
        RenderArray();
    }
    function remove(el) {
        elIndex = el.parentNode.getAttribute('data-index');
        $(el).parent().empty();
        globalIndex--;
        telephones.splice(elIndex,1);
        RenderArray();
        RenderList();
    }
    function RenderArray() {
        $('#telephonesArray').val(JSON.stringify(telephones));
    }
    function RenderList() {
        $('#telephoneList').empty();
        telephones.forEach(append);
    }
    function Up(el) {
        elIndex = el.parentNode.getAttribute('data-index');
        if(elIndex == 0) return;
        telephones = ArrayMove(telephones,elIndex,elIndex-1);
        RenderArray();
        RenderList();
    }
    function Down(el) {
        elIndex = el.parentNode.getAttribute('data-index');
        if(elIndex == telephones.length) return;
        telephones = ArrayMove(telephones,elIndex,elIndex+1);
        RenderArray();
        RenderList();
    }

    function append(value, recivedIndex) {
        var usedIndex = recivedIndex != null ? recivedIndex : globalIndex; 
        $('#telephoneList').append(`
        <li class="telephone-item" data-index="`+usedIndex+`">`+value+`
        <i onClick="Up(this)" class="fa fa-long-arrow-up"></i>
     <i onClick="Down(this)" class="fa fa-long-arrow-down"></i>
     <i onClick="remove(this)" class="fa fa-close"></i>
        
        </li>
        `);
    }
</script>
@endsection