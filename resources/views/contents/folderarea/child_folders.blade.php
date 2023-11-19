@for($i=0; $i<count($folders); $i++)
<div class='folders'>
    <input type='hidden' value='{{$folders[$i]->parentpath}}{{$folders[$i]->id}}/' />
    <div class='delete_bar border_none flexbox_row'>
        <span>{{sprintf("%02d", $i + 1)}}</span>
        <span class='flexitem_grow'></span>
        <button class='folder_delete_btn'>×</button>
    </div>
    <div class='border_none'>
        <b>{{$folders[$i]->name}}</b><br>
        学習：{{$folders[$i]->count}}回<br>
        累計：{{$folders[$i]->sum_time}}<br>
        最終日：{{$folders[$i]->lastday}}
    </div>
</div>
@endfor