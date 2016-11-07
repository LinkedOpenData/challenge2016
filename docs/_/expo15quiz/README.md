# SlickQuiz-SPARQL

jQueryクイズアプリ [SlickQuiz](https://github.com/jewlofthelotus/SlickQuiz) で SPARQLの検索結果を利用できるようにしました。

## デモ

<http://uedayou.net/SlickQuiz-SPARQL/>

利用データ：　[横浜検定問題・解答集](http://linkdata.org/work/rdf1s560i)

## 使い方

config.js の endpoint に SPARQLエンドポイントを、query に SPARQLクエリを入力してください。
queryは、/* ... */ の中に記述してください。

	// SPARQLエンドポイントURL
	var endpoint = "http://lodcu.cs.chubu.ac.jp/SparqlEPCU/api/yokohama_quiz";
	// SPARQLクエリ
	var query = (function () {/*
		select distinct * where { ?uri <http://linkdata.org/property/rdf1s560i#question> ?question;
		<http://linkdata.org/property/rdf1s560i#choice1> ?choise1;
		<http://linkdata.org/property/rdf1s560i#choice2> ?choise2;
		<http://linkdata.org/property/rdf1s560i#choice3> ?choise3;
		<http://linkdata.org/property/rdf1s560i#choice4> ?choise4;
		<http://linkdata.org/property/rdf1s560i#answer> ?answer_no;
		<http://linkdata.org/property/rdf1s560i#kaisetsu> ?kaisetsu.
		bind(concat('</p>解説：',str(?kaisetsu),'</p>') as ?correct)
		bind(concat('</p>解説：',str(?kaisetsu),'</p>') as ?incorrect) } ORDER BY RAND() LIMIT 10
	*/}).toString().match(/\n([\s\S]*)\n/)[1];

指定する変数に、以下のデータが入るように記述してください。


|変数|説明|
|:----------|:--------------|
|?question|問題文|
|?answer ※1|答え|
|?choise1<br> ?choise2<br> ?choise3<br> ...※2|選択肢|
|?correct|正解だったときに表示するメッセージ|
|?incorrect|不正解だったときに表示するメッセージ|
|?answer_no ※1|選択肢の中の答えの番号を指定※3|

※1: ?answer か ?answer_no どちらかあれば動きます。それ以外は必須  
※2: 選択肢の数はいくつでもかまいません。  
※3: 例えば、「1」だと「?choise1」が答えとして設定されます。  


また、quizJSON 内のデータを変更することで、アプリの名前や正解率に応じたメッセージをカスタマイズできます。

	var quizJSON = {
    	"info": {
        	"name":    "横浜検定クイズ", // アプリの名前(index.htmlのtitleタグも変更する必要があります)
        	"main":    "<p>横浜に関するクイズ集です。</p>", // アプリの説明
        	"results": "<p>このアプリのクイズデータは、http://linkdata.org/work/rdf1s560i のデータを使用しています。</p>", // クイズ終了時のメッセージ
        	"level1":  "すばらしい!",
        	"level2":  "なかなかです",
        	"level3":  "普通です",
        	"level4":  "まだまだです",
        	"level5":  "残念でした" // no comma here
    	}
	};


その他の使い方は、[SlickQuiz](https://github.com/jewlofthelotus/SlickQuiz) を参照してください。

## ライセンス

Copyright &copy; 2014 Hiroshi Ueda([@uedayou](https://twitter.com/uedayou)). Licensed under the [MIT license](http://www.opensource.org/licenses/mit-license.php).
