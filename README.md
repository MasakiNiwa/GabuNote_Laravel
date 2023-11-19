学習分析ノート GabuNote<br>
Laravel版です

【初期設定】<br>
①cp .env.example .env<br>
②.envファイルでデータベースを設定します<br>
③php aritisan migrate

SQLiteの場合の.envファイルの設定<br>
※sqliteに変更して、そのほかの行をコメントアウト<br>
DB_CONNECTION=sqlite<br>
#DB_HOST=127.0.0.1<br>
#DB_PORT=3306<br>
#DB_DATABASE=laravel<br>
#DB_USERNAME=root<br>
#DB_PASSWORD=