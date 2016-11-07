// SPARQLエンドポイントURL
var endpoint = "http://lod.hozo.jp/repositories/expo15";
// SPARQLクエリ
var query = (function () {/*
select distinct * where { ?uri <http://linkdata.org/property/rdf1s2680i#question> ?question;
<http://linkdata.org/property/rdf1s2680i#choice1> ?choise1;
<http://linkdata.org/property/rdf1s2680i#choice2> ?choise2;
<http://linkdata.org/property/rdf1s2680i#choice3> ?choise3;
<http://linkdata.org/property/rdf1s2680i#choice4> ?choise4;
<http://linkdata.org/property/rdf1s2680i#answer> ?answer_no;
<http://linkdata.org/property/rdf1s2680i#kaisetsu> ?kaisetsu.
bind(concat('</p>解説：',str(?kaisetsu),'</p>') as ?correct)
bind(concat('</p>解説：',str(?kaisetsu),'</p>') as ?incorrect) } ORDER BY RAND() LIMIT 10
*/}).toString().match(/\n([\s\S]*)\n/)[1];

// クイズアプリの表示設定
var quizJSON = {
    "info": {
        "name":    "関西オープンデータEXPO'15クイズ",
        "main":    "<p>関西オープンデータEXPO'15 ハンズオンBで作成されたクイズアプリです。</p>",
        "results": "<p>このアプリのクイズデータは、http://linkdata.org/work/rdf1s2680i のデータを使用しています。</p>",
        "level1":  "すばらしい!",
        "level2":  "なかなかです",
        "level3":  "普通です",
        "level4":  "まだまだです",
        "level5":  "残念でした" // no comma here
    }
};

var label_correct = "<p><span>正解</span></p>";
var label_incorrect = "<p><span>不正解</span></p>";