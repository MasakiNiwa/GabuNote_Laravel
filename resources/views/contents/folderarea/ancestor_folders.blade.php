@for($i=0; $i<count($ancestors); $i++)
    <option value="{{ $ancestors[$i]['path'] }}">{{ $ancestors[$i]['name'] }}</option>
@endfor