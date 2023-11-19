@for($i=0; $i<count($records); $i++)
<div class='record_list_group'>
    <input type='hidden' value='{{$records[$i]->parentpath}}{{$records[$i]->id}}/' />
    <b>{{$records[$i]->name}}</b><br>
    学習日: {{$records[$i]->studyday}}<br>
    達成度: {{$records[$i]->achievement}}<br>
    学習時間: {{$records[$i]->studytime}}<br>
    見直し時間: {{$records[$i]->additionalstudytime}}<br>
</div>
@endfor