// データセット手動登録分
var datasets = [
{
	"@id":"http://lod.sfc.keio.ac.jp/challenge2014/show_status.php?id=d001",
	"title":"京都が出てくる本のデータ",
	"creator":"是住久美子",
	"homepage":"http://linkdata.org/work/rdf1s1294i",
	"license":"http://creativecommons.org/licenses/by/3.0",
	"description":"京都の公共図書館で働く図書館司書が作成した、京都が出てくる小説やマンガ・ライトノベル等のデータです。作品に出てくる京都の位置データに加え、おススメ度や内容紹介等が含まれています。",
	"available":"2014"
},
{
	"@id":"http://lod.sfc.keio.ac.jp/challenge2014/show_status.php?id=d002",
	"title":"図書館員が調べた京都のギモン",
	"creator":"是住久美子",
	"homepage":"http://linkdata.org/work/rdf1s1534i",
	"license":"http://creativecommons.org/licenses/by/3.0",
	"description":"国立国会図書館のレファレンス協同データベースに登録された、全国の図書館員が調べた京都のギモンの数々です。地理情報や関連する項目のDBpediaのURIが含まれています。",
	"available":"2014"
}
];

/*
// 雛形
{
	"@id":"http://lod.sfc.keio.ac.jp/challenge2014/show_status.php?id=d001",
	"title":"京都が出てくる本のデータ",
	"creator":"是住久美子",
	"homepage":"http://linkdata.org/work/rdf1s1294i",
	"license":"http://creativecommons.org/licenses/by/3.0",
	"description":"京都の公共図書館で働く図書館司書が作成した、京都が出てくる小説やマンガ・ライトノベル等のデータです。作品に出てくる京都の位置データに加え、おススメ度や内容紹介等が含まれています。",
	"available":"2014"
}
 */

var request = ['./data/data2011.json','./data/data2012.json','./data/data2013.json'];

var endpoint = "http://db.lodc.jp/sparql";

$(function(){
	var jqXHRList = [];

	for (var i = 0; i <= request.length; i++) {
    	jqXHRList.push($.ajax({
       		url: request[i],
       		type: 'GET',
        	dataType: 'text'
    	}));
	}

	$.when.apply(null, jqXHRList).done(function () {
	    var json = [];
	    for (var i = 0; i < arguments.length; i++) {
	        var result = arguments[i];
	        setLODChallengeDataSet($.parseJSON(result[0]));
	    }
	});

	// 手動登録分
	setLODChallengeDataSet(convJsonldToSparqlJson(datasets));

	$(document).on("click", ".list-group-item a", function(e){
       	e.preventDefault();
       	e.stopPropagation();
       	var url = $(this).attr('href');
       	if (url=="http://lod.sfc.keio.ac.jp/challenge/entries") {
       		showMetaDataSetInfoModal();
       	} else {
       		showDataSetInfoModal(url);
       	}
       	return false;
    });

});

var convJsonldToSparqlJson = function(jsonld) {
	var json = {"results":{"bindings":[]}};
	$.each(jsonld, function(i,val) {
		var val = {"id":{"value":val["@id"]}, "title":{"value":val["title"]}, "year":{"value":val["available"]}};
		json.results.bindings.push(val);
	});
	return json;
};

var setLODChallengeDataSet = function(json) {
	var year;
	$.each(json.results.bindings, function(i,val){
		$("#sparql-data"+val.year.value).append("<li class=\"list-group-item\"><a href=\""+val.id.value+"\">"+val.title.value+"</a></li>");
		if (typeof year == "undefined") {year = val.year.value};
	});
	var label = "#data"+year+"-count";
	$(label).removeClass("hide");
	$(label).html(json.results.bindings.length);
};

var showDataSetInfoModal = function(uri) {

	var metadata = $.grep(datasets, function(val){
		return val["@id"]==uri;
	});

	if (metadata.length==0) {
		showDataSetInfoModalFromEndpoint(uri);
	}
	else {
		var metadata = metadata[0];
		var table = createDetailTable(metadata["title"],metadata["description"],uri,metadata["homepage"],metadata["license"]);
		showModalWithLODCContents(metadata["title"], table, uri, true);
	}
}

var createDetailTable = function(title, description, uri, homepage, license) {
	var table = "<table class=\"table table-bordered table-striped\"><tr><th colspan=\"2\">応募作品情報</th></tr>";
		table +="<tr><td class=\"dataset-td;\">タイトル</td><td class=\"word-break\">"+title+"</td></tr>";
		table +="<tr><td class=\"dataset-td\">概要</td><td class=\"word-break\">"+description+"</td></tr>";
		table +="<tr><td class=\"dataset-td\">エントリー<br />ページ</td><td class=\"word-break\"><a href=\""+uri+"\" target=\"_blank\">"+uri+"</a></td></tr>";
		table +="<tr><td class=\"dataset-td\">データ<br />入手先</td><td class=\"word-break\"><a href=\""+homepage+"\" target=\"_blank\">"+homepage+"</a></td></tr>";
		table +="<tr><td class=\"dataset-td\">ライセンス</td><td class=\"word-break\">"+getLicenseString(license)+"</td></tr>";
		table +="</table>";
	return table;
}

var showDataSetInfoModalFromEndpoint = function(uri) {
	var query = "select distinct ?p ?o from <http://lod.sfc.keio.ac.jp/challenge/entries> where { ?s ?p ?o; <http://www.w3.org/2000/01/rdf-schema#seeAlso> <"+uri+">. }";
	console.log(query);
	$("#dataset-modal").html("");
	$("#dataset-modal").modal();
	sendQuery(endpoint, query)
	.fail(function (xhr, textStatus, thrownError) {
        $("#dataset-modal").html('<div class="modal fade" id="dataset-modal"><div class="modal-dialog"><div class="modal-content"><div class="modal-body">SPARQLエンドポイントからデータを取得できませんでした。</div></div></div></div>');
        $('body').append($modal);
        //$("#dataset-modal").modal();
    })
    .done(function (json) {
    	var title, url, homepage, creators, license, desc ="";
    	$.each(json.results.bindings, function(i,val){
    		if (val.p.value=="http://purl.org/dc/terms/title") {title = val.o.value;}
    		else if (val.p.value=="http://purl.org/dc/terms/license") {license = val.o.value;}
    		else if (val.p.value=="http://xmlns.com/foaf/0.1/homepage") {homepage = val.o.value;}
    		else if (val.p.value=="http://purl.org/dc/terms/creator") {creators = (creators!=""?",":"")+val.o.value;}
    		else if (val.p.value=="http://www.w3.org/2000/01/rdf-schema#seeAlso") {url = val.o.value;}
    		else if (val.p.value=="http://purl.org/dc/terms/description") {desc = val.o.value;}
		});
		var table = createDetailTable(title,desc,uri,homepage,license);
		showModalWithLODCContents(title, table, url);
    });
}

var getLicenseString = function(license) {
	if (license=="http://creativecommons.org/licenses/by/3.0") {
		license = "<a href=\""+license+"\" target=\"_blank\">CC-BY</a>";
	}
	else if (license=="http://creativecommons.org/publicdomain/mark/1.0") {
		license = "<a href=\""+license+"\" target=\"_blank\">Public Domain</a>";
	}

	return license;
}

var showMetaDataSetInfoModal = function() {
	var table = "<table class=\"table table-bordered table-striped\"><tr><th colspan=\"2\">メタデータ情報</th></tr>";
	table +="<tr><td style=\"min-width:100px;\">タイトル</td><td class=\"word-break\">LODチャレンジ2011～2013の応募作品データ</td></tr>";
	table +="<tr><td style=\"min-width:100px;\">概要</td><td class=\"word-break\"><a href=\"https://github.com/tsunagun/lodcworks\" target=\"_blank\">LODC Works</a>を利用して、LODチャレンジ2011～2013の応募作品のデータをRDF化しました。このデータセットのグラフURIは「http://lod.sfc.keio.ac.jp/challenge/entries」です。同名のデータセット応募作品<a href=\"http://lod.sfc.keio.ac.jp/challenge2012/show_status.php?id=d085\">LODC Works</a>とデータスキーマは同じです。</td></tr>";
	table +="<tr><td class=\"dataset-td\">データ<br />入手先</td><td class=\"word-break\"><p><a href=\"http://uedayou.net/lodchallenge/lodchallenge_entries_2011-2013.rdf\" target=\"_blank\">RDF/XML形式</a></p><p><a href=\"http://uedayou.net/lodchallenge/lodchallenge_entries_2011-2013.ttl\" target=\"_blank\">Turtle形式</a></p></td></tr>";
	table +="<tr><td style=\"min-width:100px;\">ライセンス</td><td class=\"word-break\">パブリックドメイン</td></tr>";
	table +="</table>";

	showModalWithLODCContents("LODチャレンジ2011～2013の応募作品データ", table, "http://lod.sfc.keio.ac.jp/challenge/entries", true);
}

var showModalWithLODCContents = function(title, body, uri, show) {
	if (typeof show =="undefined") {show=false;}
	$modal = $("#dataset-modal").html('<div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><h3 class="modal-title centering-class">'+title+'</h3></div><div class="modal-body">'+body+'<hr><h3 class="centering-class">このデータセットを検索</h3><form action="http://db.lodc.jp/sparql" target="_blank" method="get"><textarea name="query" rows="8" style="width:100%;">SELECT * \nFROM &lt;'+uri+'&gt;\nWHERE{\n    ?s ?p ?o .\n    #ここにトリプルパターンを追加してください\n}\nORDER BY ?s\nLIMIT 100\n</textarea><button type="submit" class="btn btn-primary" style="width:100%;">検索</a></form> </div></div></div>');
    $('body').append($modal);
    if(show)$("#dataset-modal").modal();
}
