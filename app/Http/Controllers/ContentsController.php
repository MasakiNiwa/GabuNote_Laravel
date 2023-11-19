<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Studyitem;

class ContentsController extends Controller
{
    //時間表記の変更(秒⇒日・時間・分・秒)
    private function time_convert($time)
    {
        $m = floor($time/60);
            $s = $time % 60;
        $h = floor($m/60);
            $m = $m % 60;
        $d = floor($h/24);
            $h = $h %60;
        
        if($d>0){
            return "{$d}日{$h}時間{$m}分{$s}秒";
        }elseif($h>0){
            return "{$h}時間{$m}分{$s}秒";
        }
        elseif($m>0){
            return "{$m}分{$s}秒";
        }else{
            return "{$s}秒";
        }
    }

    //レコードリストを表示
    public function show_recent_records(Request $request)
    {   
        $record = null;
        if($request->filter == -1){
            $records = Studyitem::where('type', 1)->get();
        }else{
            $records = Studyitem::where('type', 1)->where('achievement', $request->filter)->get();
        }

        foreach($records as $record){
            $record['studytime'] = $this->time_convert($record['studytime']);
            $record['additionalstudytime'] = $this->time_convert($record['additionalstudytime']);
        }

        return view('/contents/recordlistarea/recent_records', compact('records'));
    }

    //学習比率グラフのデータ作成
    public function folder_chart(Request $request)
    {
        $folders = Studyitem::where('parentpath', $request->path)->where('type', 0)->get();
        foreach($folders as $folder){
            $target_path = $folder->parentpath.$folder->id.'/%';
            $for_stats = Studyitem::where('parentpath', 'LIKE', $target_path)->where('type', 1)->get();
            $sum_study = $for_stats->sum('studytime');
            $sum_addstudy = $for_stats->sum('additionalstudytime');
            $folder['sum_time'] = floor(($sum_study + $sum_addstudy)/60);
        }
        
        return $folders;
    }

    //達成度グラフのデータ作成
    public function record_chart(Request $request)
    {
        $records = Studyitem::where('parentpath', $request->path)->where('type', 1)->get();
        
        return $records;
    }

    //上位フォルダのリストを表示
    public function show_ancestor_folders(Request $request)
    {
        $path = $request->path;
        $ancestors = [];
        $num = 0;

        while($path != '/'){
            //上位フォルダがある場合は、親フォルダパスとフォルダIDを分離
            if(preg_match('/^(.*\/)([0-9]+)\/$/',$path,$id)){
                $folder = Studyitem::find($id[2]);
                if($num != 0){
                    $ancestors[] = ['path' => $id[0], 'name' => $folder->name];
                }
                $num++;
                $path = $id[1];
            }else{
                break;
            }
        }
        $ancestors[] = ['path' => '/', 'name' => 'ルートディレクトリ'];

        return view('/contents/folderarea/ancestor_folders', compact('ancestors'));
    }

    //フォルダ名を表示
    public function show_folder_name(Request $request)
    {
        if($request->path == "/"){
            $foldername = "ルートディレクトリ";
            return $foldername;
        }else{
            //正規表現で親フォルダのIDを抜き出す
            preg_match('/^.*\/([0-9]+)\/$/',$request->path ,$id);
            $folder = Studyitem::find($id[1]);
            return $folder->name;
        }
    }

    //フォルダ名を更新
    public function update_folder(Request $request)
    {
        $folder = Studyitem::findOrFail($request->id);
        $folder->name = $request->name;
        $folder->save();
    }

    //新しいフォルダを作成
    public function new_folder(Request $request)
    {
        $studyitem = new Studyitem();
        $studyitem->parentpath = $request->parentpath;
        $studyitem->name = $request->name;
        $studyitem->type = 0;
        $studyitem->save();
    }

    //現在の学習フォルダの累計学習時間の表示
    public function show_total_time(Request $request)
    {  
        $for_stats = Studyitem::where('parentpath', 'LIKE', join([$request->path, '%']))->where('type', 1);
        $sum_study = $for_stats->sum('studytime');
        $sum_addstudy = $for_stats->sum('additionalstudytime');
        $total_time = $this->time_convert($sum_study + $sum_addstudy);

        return view('/contents/folderarea/total_time', compact('total_time'));
    }

    //子学習フォルダを表示
    public function show_child_folder(Request $request)
    {
        $folders = Studyitem::where('parentpath', $request->path)->where('type', 0)->get();
        foreach($folders as $folder){
            $target_path = $folder->parentpath.$folder->id.'/%';
            $for_stats = Studyitem::where('parentpath', 'LIKE', $target_path)->where('type', 1)->get();
            $folder['count'] = $for_stats->count();
            $sum_study = $for_stats->sum('studytime');
            $sum_addstudy = $for_stats->sum('additionalstudytime');
            $folder['sum_time'] = $this->time_convert($sum_study + $sum_addstudy);
            $folder['lastday'] = Studyitem::where('parentpath', 'LIKE', $target_path)->where('type', 1)->max('studyday');
        }

        return view('/contents/folderarea/child_folders', compact('folders'));
    }

    //学習フォルダを削除
    public function delete_folder(Request $request)
    {
        //正規表現でフォルダのIDを抜き出す
        preg_match('/^.*\/([0-9]+)\/$/',$request->path ,$id); 
        //フォルダの子孫を削除
        $folders = Studyitem::where('parentpath', 'LIKE', join([$request->path, '%']));
        $folders->delete();
        //フォルダ自体を削除
        $folder = Studyitem::findOrFail($id[1]);
        $folder->delete();
    }

    //子学習レコードの平均達成度を表示
    public function show_achievement(Request $request)
    {
        $avg_achievement = Studyitem::where('parentpath', $request->path)->where('type', 1)->avg('achievement');
        $avg_achievement = sprintf("%1.1f", $avg_achievement);

        return view('/contents/folderarea/avg_achievement', compact('avg_achievement'));
    }

    //子学習レコードを表示
    public function show_child_record(Request $request)
    {
        $records = Studyitem::where('parentpath', $request->path)->where('type', 1)->get();

        foreach($records as $record){
            $record['studytime'] = $this->time_convert($record['studytime']);
            $record['additionalstudytime'] = $this->time_convert($record['additionalstudytime']);
        }

        return view('/contents/folderarea/child_records', compact('records'));
    }

    //学習レコードを削除
    public function delete_record(Request $request)
    {
        $record = Studyitem::findOrFail($request->id);
        $record->delete();
    }

    //クリックした既存レコード情報を取得
    public function get_record_info(Request $request)
    {
        $record = Studyitem::findOrFail($request->id);

        //studytime(sec)をh･m･sに分解
        $s = $record->studytime % 60;
        $m = floor($record->studytime / 60);
        $h = floor($m /60);
        $m = $m % 60;
        $record['studytime_h'] = $h;
        $record['studytime_m'] = $m;
        $record['studytime_s'] = $s;
        //additionalstudytime(sec)をh･m･sに分解
        $s = $record->additionalstudytime % 60;
        $m = floor($record->additionalstudytime / 60);
        $h = floor($m /60);
        $m = $m % 60;
        $record['add_studytime_h'] = $h;
        $record['add_studytime_m'] = $m;
        $record['add_studytime_s'] = $s;

        return $record;
    }

    //編集した学習レコードを登録
    public function save_record(Request $request)
    {
        $studyitem = null;

        //未登録ID(-1)ならば新規作成、登録IDならば更新
        if($request->id == -1){
            $studyitem = new Studyitem();
            $studyitem->parentpath = $request->parentpath;
            $studyitem->type = 1;
        }else{
            $studyitem = Studyitem::findOrFail($request->id);
        }

        $studyitem->name = $request->title;
        $studyitem->studyday = $request->studyday;
        $studyitem->achievement = $request->achievement;
        $studyitem->studytype = $request->studytype;
        $studyitem->studytime = $request->studytime;
        $studyitem->additionalstudytime = $request->addstudytime;
        $studyitem->studymemo = $request->memo;

        $studyitem->save();
    }
}
