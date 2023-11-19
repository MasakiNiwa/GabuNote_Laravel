@for($i=0; $i<count($records); $i++)
<div class='records' tabindex='0'>
    <input type='hidden' value='{{$records[$i]->id}}' />
    <div class='delete_bar border_none flexbox_row'>
        <span>{{sprintf("%02d", $i + 1)}}</span>
        <span class='flexitem_grow'></span>
        <button class='record_delete_btn'>×</button>
    </div>
    <div class='border_none'>
        学習日：{{$records[$i]->studyday}}<br>
        達成度：{{$records[$i]->achievement}} <progress max='5' value='{{$records[$i]->achievement}}'></progress><br>
        学習時間：{{$records[$i]->studytime}}<br>
        見直し時間：{{$records[$i]->additionalstudytime}}<br>
    </div>
</div>
@endfor