<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>学習分析ノート GabuNote</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/moment@^2"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-moment@^1"></script>
        <link rel="stylesheet" href="{{asset('css/pagestyle.css')}}">
        <link rel="stylesheet" href="{{asset('css/partsdesign.css')}}">
    </head>
    <body>
        <header>
            <span>学習分析ノート</span>
            <span id="titlename">GabuNote</span>
            <hr>
        </header>
        <main class="flexbox_row">
            <div class="flexitem50 flexitem_grow flexbox_column" id="record_list_area">
                <div class="flexbox_row border_none areabar">
                    <span class="flexitem_grow areaname">レコードリスト</span>
                    <button type="button" id="go_folder">フォルダ</button>
                </div>
                <div class="flexbox_row border_none">
                    <span>達成度:</span>
                    <select id="record_list_achievement">
                        <option value="-1">－</option>
                        <option value="5">5：手応えあり！</option>
                        <option value="4">4：つかみ始めた</option>
                        <option value="3">3：OK</option>
                        <option value="2">2：あともう少し</option>
                        <option value="1">1：少し学べた</option>
                        <option value="0">0：学習開始</option>
                    </select>
                </div>
                <div class="flexitem_grow scroll border_none" id="record_list">
                </div>
            </div>
            <div class="flexitem50 flexitem_grow flexbox_column" id="folder_block">
                <div class="flexbox_row border_none areabar">
                    <button type="button" id="go_recordlist">リスト</button>
                    <span class="flexitem_grow areaname">フォルダ操作エリア</span>
                    <select id="graph_slect">
                        <option value="1">学習比率グラフ</option>
                        <option value="0">達成度グラフ</option>
                    </select>
                </div>
                <canvas id="folderChart"></canvas>
                <canvas id="recordChart"></canvas>
                <div class="flexbox_row border_none">
                    <button type="button" id="homebtn">HOME</button>
                    <button type="button" id="returnbtn">UP</button>
                    <input type="text" disabled value="/" class="flexitem_grow" id="parentpath_view" />
                    <button type="button" id="next_view_btn">移動</button>
                    <span>上位フォルダ：</span>
                    <select class="flexitem_grow" id="ancestor_folders">
                    </select>
                </div>
                <div class="flexbox_row border_none">
                    <span>フォルダ名：</span>
                    <input type="text" class="flexitem_grow" id="folder_name"/>
                    <button type="button" id="changenamebtn">変更</button>
                </div>
                <div class="flexitem_grow flexbox_row hidden border_none">
                    <div class="flexitem50 flexbox_column">
                        <h5>学習フォルダ</h5>
                        <div class="flexbox_row border_none">
                            <button type="button" id="add_folder">新規</button>
                        </div>
                        <div id="totaltime_area">
                        </div>
                        <div class="flexitem_grow scroll border_none" id="folder_selector">
                        </div>
                    </div>
                    <div class="flexitem50 flexbox_column">
                        <h5>学習レコード</h5>
                        <div class="flexbox_row border_none">
                            <button type="button" id="new_record">新規</button>
                        </div>
                        <div id="achievement_area">
                        </div>
                        <div class="flexitem_grow scroll border_none" id="record_selector">
                        </div>
                    </div>
                </div>               
            </div>
            <div class="flexitem50 flexitem_grow flexbox_column" id="edit_area">
                <div class="flexbox_row border_none areabar">
                    <button type="button" id="edit_return">戻る</button>
                    <span class="flexitem_grow areaname">学習レコード編集エリア</span>
                </div>
                <div class="border_none">
                    <div class="border_none">
                        上位フォルダ：<span id="parentfoldername"></span><br>
                        学習フォルダ：<span id="foldername"></span><br>
                        学習日：<input type="date" id="studyday"/>
                        達成度:<select id="input_achievement">
                            <option value="-1">－</option>
                            <option value="5">5：手応えあり！</option>
                            <option value="4">4：つかみ始めた</option>
                            <option value="3">3：OK</option>
                            <option value="2">2：あともう少し</option>
                            <option value="1">1：少し学べた</option>
                            <option value="0">0：学習開始</option>
                    </select><br>
                    学習タイプ：<select id="studytype">
                        <option value="-1">－</option>
                        <option value="1">テキスト学習</option>
                        <option value="2">問題学習</option>
                        <option value="3">講義形式</option>
                        <option value="4">試験形式</option>
                        <option value="5">実践</option>
                        <option value="0">その他</option>
                    </select><br>
                    </div>
                    <div class="border_none" id="input_date_area">
                        学習時間　：<input type="number" max="99" min="0" value="0" id="studytime_h" />時間<input type="number" max="59" min="0" value="0" id="studytime_m" />分<input type="number" max="59" min="0" value="0" id="studytime_s" />秒<br>
                        見直し時間：<input type="number" max="99" min="0" value="0" id="add_studytime_h" />時間<input type="number" max="59" min="0" value="0" id="add_studytime_m" />分<input type="number" max="59" min="0" value="0" id="add_studytime_s" />秒
                    </div>
                </div>
                <div class="flexbox_row border_none">
                    <span>タイトル：</span>
                    <input type="text" class="flexitem_grow" id="title" />
                    <button type="submit" id="submit_btn">登録</button>
                </div>
                <div id="record_info">
                    【書き込みチェック用】<br>
                    親フォルダ：<input type="text" disabled id="parent_path" /><br>
                    レコードID：<input type="text" disabled value="-1" id="record_id" />
                </div>
                <textarea class="flexitem_grow" id="memo_area"></textarea>
            </div>
        </main>
        <footer>
            <hr>
            Study! Note! Analyzed!
        </footer>
    </body>
</html>
<script>
    //ページ表示完了時に、フォルダ操作エリアにイベントを設定
    $(document).ready(function(){
        //移動ボタンにイベントを設定
        //フォルダパスを読み取って移動ボタンをonclickさせる
        //↑このイベントをフォルダ操作エリアの中心イベントにする
        let nextViewBtn = document.getElementById('next_view_btn');
        nextViewBtn.onclick = function(){
            //フォルダパスの読み取り
            let path = $('#parentpath_view').val();

            //子フォルダエリアを更新
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url:'{{ route("child_folder_view") }}',
                type:'POST',
                data:{
                    "path": path,
                }
            }).done(function(response){
                $('#folder_selector').html(response);

                //子フォルダをクリックした時に子フォルダに移動する
                $('.folders').click(function(){
                    $('#parentpath_view').val($(this).find(':first-child').val());
                    nextViewBtn.click();
                });

                //フォルダ削除ボタンをクリックしたときのイベント
                $('.folder_delete_btn').click(function(e){
                    e.stopPropagation();
                    let delete_confirm = window.confirm('フォルダを削除します\nフォルダに所属する全てのレコードが削除されます');
                    if(delete_confirm){
                        let path = $(this).parents('.folders').find(':first-child').val();
                        $.ajax({
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            url:'{{ route("delete_folder") }}',
                            type:'POST',
                            data:{
                                "path": path,
                            }
                        }).done(function(response){
                            nextViewBtn.click();
                            $('#record_list_achievement').change();
                        });
                    }
                });

            });

            //子レコードエリアを更新
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url:'{{ route("child_record_view") }}',
                type:'POST',
                data:{
                    "path": path,
                }
            }).done(function(response){
                $('#record_selector').html(response);

                //子レコードをクリックしたときのイベント
                $('.records').click(function(){
                    //子レコードの情報を取得
                    let id = $(this).find(':first-child').val();
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url:'{{ route("get_record_info") }}',
                        type:'POST',
                        data:{
                            "id": id,
                        }
                    }).done(function(response){
                        editor_input(response.studyday, response.achievement, response.studytype, response.studytime_h, response.studytime_m, response.studytime_s, response.add_studytime_h, response.add_studytime_m, response.add_studytime_s, response.name, response.studymemo, response.id);
                        //フォルダ名の設定
                        set_foldername();
                        //編集エリアに移動
                        $('#folder_block').hide();
                        $('#edit_area').css('display', 'flex');
                    });
                });

                //レコード削除ボタンをクリックしたときのイベント
                $('.record_delete_btn').click(function(e){
                    e.stopPropagation();
                    let delete_confirm = window.confirm('レコードを削除します');
                    if(delete_confirm){
                        let id = $(this).parents('.records').find(':first-child').val();
                        $.ajax({
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            url:'{{ route("delete_record") }}',
                            type:'POST',
                            data:{
                                "id": id,
                            }
                        }).done(function(response){
                            nextViewBtn.click();
                            $('#record_list_achievement').change();
                        });
                    }
                });
                
            });

            //フォルダ名を更新
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url:'{{ route("show_folder_name") }}',
                type:'POST',
                data:{
                    "path": path,
                }
            }).done(function(response){
                $('#folder_name').val(response);
            });

            //レコード累計学習時間を更新
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url:'{{ route("total_time_view") }}',
                type:'POST',
                data:{
                    "path": path,
                }
            }).done(function(response){
                $('#totaltime_area').html(response);
            });

            //子レコード達成度を更新
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url:'{{ route("achievement_view") }}',
                type:'POST',
                data:{
                    "path": path,
                }
            }).done(function(response){
                $('#achievement_area').html(response);
            });

            //レコード編集エリアの親フォルダパスを変更
            $('#parent_path').val(path);

            //学習比率グラフを更新
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url:'{{ route("folder_chart") }}',
                type:'POST',
                data:{
                    "path": path,
                }
            }).done(function(response){
                //グラフデータの入れ物を用意
                let graph_data = {
                    labels:[],
                    datasets:[{
                        data:[]
                    }]
                }

                //データを入力
                let labels = [];
                let data = [];
                for(let i=0; i<response.length; i++){
                    labels[i] = response[i]['name'];
                    data[i] = response[i]['sum_time'];
                }

                graph_data.labels = labels;
                graph_data.datasets[0].data = data;

                //チャートを更新
                folder_chart.data = graph_data;
                folder_chart.update();
            });

            //達成度グラフを更新
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url:'{{ route("record_chart") }}',
                type:'POST',
                data:{
                    "path": path,
                }
            }).done(function(response){
                //グラフデータの入れ物を用意
                let graph_data = {
                    labels:[],
                    datasets:[{
                        type: 'line',
                        label: '達成度',
                        data:[],
                        yAxisID: 'achievement',
                        borderWidth: 1
                    },{
                        type: 'bar',
                        label: '学習時間(分)',
                        data:[],
                        yAxisID: 'studytime',
                        borderWidth: 1
                    }]
                }

                //データを入力
                let labels = [];
                let time_data = [];
                let achievement_data = [];
                for(let i=0; i<response.length; i++){
                    labels[i] = response[i]['studyday'];
                    time_data[i] = Math.floor(response[i]['studytime']/60);
                    achievement_data[i] = response[i]['achievement'];
                }

                graph_data.labels = labels;
                graph_data.datasets[0].data = achievement_data;
                graph_data.datasets[1].data = time_data;

                //チャートを更新
                record_chart.data = graph_data;
                record_chart.update();
            });

            //上位フォルダ名をリストボックスに設定
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url:'{{ route("show_ancestor_folders") }}',
                type:'POST',
                data:{
                    "path": path
                }
            }).done(function(response){
                $('#ancestor_folders').html(response);
                //編集エリアに上位フォルダ名を転記
                $('#parentfoldername').text($('#ancestor_folders').find(':first-child').text());
            });
        }

        //グラフエリアを初回作成
        let ctx_folder = document.getElementById('folderChart');
        let folder_chart = new Chart(ctx_folder, {
            type: 'pie',
            data: {
                labels:[],
                datasets:[{
                    data:[]
                }]
            },
            options: {}
        });

        let ctx_record = document.getElementById('recordChart');
        let record_chart = new Chart(ctx_record, {
            data: {},
            options: {
                scales: {
                    x: {
                        type: 'time',
                        time: {
                            unit: 'day',
                            displayFormats: {
                                day: 'YYYY/MM/DD'
                            }
                        }
                    },
                    achievement: {
                        type:'linear',
                        position: 'left',
                        beginAtZero: true,
                        max: 5,
                        ticks: {
                            stepSize: 1,
                            suggestedMax: 5
                        }
                    },
                    studytime: {
                        type:'linear',
                        position: 'right',
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        //グラフエリアの切り替え
        let graph_select = document.getElementById('graph_slect');
        graph_select.onchange = function(){
            let foldergraph = document.getElementById('folderChart');
            let recordgraph = document.getElementById('recordChart');
            if(this.value == 0){
                foldergraph.style.display = 'none';
                recordgraph.style.display = 'block';
            }else if(this.value == 1){
                recordgraph.style.display = 'none';
                foldergraph.style.display = 'block';
            }
        }
        graph_select.onchange();


        //新しいフォルダの追加
        $('#add_folder').click(function(){
            //作成するフォルダ名の入力画面
            let name_prompt = prompt('作成するファイル名を指定してください','(New Folder)');
            if(name_prompt){
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url:'{{ route("new_folder") }}',
                    type:'POST',
                    data:{
                        "parentpath": $('#parentpath_view').val(),
                        "name": name_prompt
                    }
                }).done(function(response){
                    //フォルダの追加が完了したらフォルダ操作エリアを更新
                    nextViewBtn.click();
                });
            }
        });

        //編集エリア入力
        function editor_input(studyday, input_achievement, studytype, studytime_h, studytime_m, studytime_s, add_studytime_h, add_studytime_m, add_studytime_s, title, memo_area, record_id){
            document.getElementById('studyday').value = studyday;
            document.getElementById('input_achievement').value = input_achievement;
            document.getElementById('studytype').value = studytype;
            document.getElementById('studytime_h').value = studytime_h;
            document.getElementById('studytime_m').value = studytime_m;
            document.getElementById('studytime_s').value = studytime_s;
            document.getElementById('add_studytime_h').value = add_studytime_h;
            document.getElementById('add_studytime_m').value = add_studytime_m;
            document.getElementById('add_studytime_s').value = add_studytime_s;
            document.getElementById('title').value = title;
            document.getElementById('memo_area').value = memo_area;
            document.getElementById('record_id').value = record_id;
        }

        //新規学習レコードの追加
        $('#new_record').click(function(){
            //フォルダ名の設定
            set_foldername();
            //編集エリアのクリア
            let today = new Date();
            let today_value = today.getFullYear() +"-"+ ('00' + (today.getMonth()+1)).slice(-2) +"-"+ ('00' + today.getDate()).slice(-2);
            editor_input(today_value, -1, -1, 0, 0, 0, 0, 0, 0, '', '', -1);
            //編集エリアに移動
            $('#folder_block').hide();
            $('#edit_area').css('display', 'flex');
        });

        //HOMEボタン
        $('#homebtn').click(function(){
            //親フォルダパスをルートに設定
            $('#parentpath_view').val('/');
            //移動ボタンをclick
            $('#next_view_btn').click();
        });

        //戻るボタン
        $('#returnbtn').click(function(){
            //現在の親フォルダパスを読込
            let path = $('#parentpath_view');
            //一つ上のフォルダパスに修正
            if(path.val() != '/'){
                let pattern = /^(.*\/)[0-9]+\/$/;
                let result = pattern.exec(path.val());
                path.val(result[1]);
            }
            //移動ボタンをonclick
            $('#next_view_btn').click();
        });

        //上位フォルダリスト選択時に移動
        $('#ancestor_folders').change(function(){
            //上位フォルダが選択されたらパスを設定
            $('#parentpath_view').val($(this).val());
            //移動ボタンをクリック
            $('#next_view_btn').click();
        });

        //フォルダ名変更ボタン
        $('#changenamebtn').click(function(){
            let path = $('#parentpath_view').val();
            //ルートディレクトリ(/)の時は動かさない
            if(path != '/'){
                let changename_confirm = window.confirm('フォルダ名を変更します');
                if(changename_confirm){
                    //入力フォルダ名を読込
                    let name = $('#folder_name').val();
                    //フォルダIDを抽出
                    let pattern = /^.*\/([0-9]+)\/$/;
                    let result = pattern.exec(path);
                    let id = result[1];
                    //ajaxを設定
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url:'{{ route("update_folder") }}',
                        type:'POST',
                        data:{
                            "id": id,
                            "name": name
                        }
                    }).done(function(response){
                        //フォルダの追加が完了したらフォルダ操作エリアを更新
                        nextViewBtn.click();
                    });
                }
            }
        });

        //レコードリストに移動
        let gorecordlsitbtn = document.getElementById('go_recordlist');
        gorecordlsitbtn.onclick = function(){
            let folderarea = document.getElementById('folder_block');
            let listarea = document.getElementById('record_list_area');
            let gofolderareabtn = document.getElementById('go_folder');
            gofolderareabtn.style.display = 'inline';
            folderarea.style.display = 'none';
            listarea.style.display = 'flex';
        }

        //編集エリアにフォルダ名を転記
        function set_foldername(){
            let foldernamearea = document.getElementById('folder_name');
            let edit = document.getElementById('foldername');
            edit.innerText = foldernamearea.value;
        }

        //初回表示のために移動ボタンのonclickを発生させる
        nextViewBtn.click();
    });

    //ページ表示完了時に、レコードリストエリアにイベントを設定
    $(document).ready(function(){
        //達成度フィルタに変更があったらリストを表示する
        $('#record_list_achievement').change(function(){
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url:'{{ route("recent_records_view") }}',
                type:'POST',
                data:{
                    "filter": $(this).val(),
                }
            }).done(function(response){
                $('#record_list').html(response);
            });
        });

        //フォルダエリアに移動
        $('#go_folder').click(function(){
            $('#record_list_area').hide();
            $('#folder_block').css('display', 'flex');
        });

        //初回表示のためにonchangeを発生させる
        $('#record_list_achievement').change();
    });

    //ページ表示完了時に、レコード編集エリアにイベントを設定
    $(document).ready(function(){
        //入力要素を変数にいれる
        let studyday_form = document.getElementById('studyday');
        let achievement_form = document.getElementById('input_achievement');
        let studytype_form = document.getElementById('studytype');
        let studytime_h_form = document.getElementById('studytime_h');
        let studytime_m_form = document.getElementById('studytime_m');
        let studytime_s_form = document.getElementById('studytime_s');
        let add_studytime_h_form = document.getElementById('add_studytime_h');
        let add_studytime_m_form = document.getElementById('add_studytime_m');
        let add_studytime_s_form = document.getElementById('add_studytime_s');
        let title_form = document.getElementById('title');
        let memo_form = document.getElementById('memo_area');
        let parentpath_form = document.getElementById('parent_path');
        let recordid_form = document.getElementById('record_id');

        //学習日入力欄に今日の日付を初期入力
        let today = new Date();
        studyday_form.value = today.getFullYear() +"-"+ (today.getMonth()+1) +"-"+ today.getDate();

        //未入力チェックをしてから登録ボタンにajaxを設定
        $('#submit_btn').click(function(){
            if((achievement_form.value==-1)||(studytype_form.value==-1)){
                alert('達成度か学習タイプが未入力です。');
            }else{
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url:'{{ route("save_record") }}',
                    type:'POST',
                    data:{
                        "studyday": studyday_form.value,
                        "achievement": achievement_form.value,
                        "studytype": studytype_form.value,
                        "studytime": (Number.parseInt(studytime_h_form.value,10)*3600 + Number.parseInt(studytime_m_form.value,10)*60 + Number.parseInt(studytime_s_form.value,10)),
                        "addstudytime": (Number.parseInt(add_studytime_h_form.value,10)*3600 + Number.parseInt(add_studytime_m_form.value,10)*60 + Number.parseInt(add_studytime_s_form.value,10)),
                        "title": title_form.value,
                        "memo": memo_form.value,
                        "parentpath": parentpath_form.value,
                        "id": recordid_form.value
                    }
                }).done(function(response){
                    //データ登録が成功したら、レコードリストを更新
                    $('#record_list_achievement').change();
                    //フォルダ操作エリアを更新
                    $('#next_view_btn').click();
                    //フォルダ操作エリアに移動
                    $('#edit_area').hide();
                    $('#folder_block').css('display', 'flex');
                });
            }
        });

        //フォルダ操作エリアに戻る
        $('#edit_return').click(function(){
            let confirm = window.confirm('編集を破棄して戻ります');
            if(confirm){
                $('#edit_area').hide();
                $('#folder_block').css('display', 'flex');
            }
        });
    });
</script>