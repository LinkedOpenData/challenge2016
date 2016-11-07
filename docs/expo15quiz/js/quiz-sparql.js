
var startQuizBySparql = function() {

	qr = sendQuery(endpoint, query);
    qr.fail(
        function (xhr, textStatus, thrownError) {
            $('body').modalmanager('removeLoading');
            alert("Error: A '" + textStatus+ "' occurred.");
        }
    );
    qr.done(
        function (json) {
            dataJson = [];
            for(var i=0;i<json.results.bindings.length;i++) {
            	var quizjson = json.results.bindings[i];
            	var quizdata = {};

            	if (typeof quizjson.question != "undefined") {
            		quizdata["q"] = quizjson.question.value;
            	}
            	else { continue; }

            	if (typeof quizjson.correct != "undefined") {
            		quizdata["correct"] = label_correct+quizjson.correct.value;
            	}
            	else { continue; }

            	if (typeof quizjson.incorrect != "undefined") {
            		quizdata["incorrect"] = label_incorrect+quizjson.incorrect.value;
            	}
            	else { continue; }

				quizdata["a"] = []
            	if (typeof quizjson.answer != "undefined") {
            		quizdata.a.push({"option": quizjson.answer.value,"correct": true});
            	}

            	for (var j=0;j<10;j++) {
            		var label = "choise"+(j+1);
            		var correct = (typeof quizjson.answer_no != "undefined" && label === "choise"+quizjson.answer_no.value) ? true : false;
            		if (typeof quizjson[label] != "undefined") {
        				quizdata.a.push({"option": quizjson[label].value,"correct": correct});
            		}
            		else { break; }
            	}
            	dataJson.push(quizdata);
            }
            quizJSON.questions = dataJson;
            $('#slickQuiz').slickQuiz({
            	checkAnswerText:  '回答',
            	nextQuestionText: '次へ &raquo;',
            	questionCountText: '%current 問目（全 %total問)',
            	preventUnansweredText: '一つ以上回答してください。',
            	randomSortQuestions: true,
                randomSortAnswers: true,
                preventUnanswered: true,
				//perQuestionResponseAnswers: true,
                completionResponseMessaging: true,
            });
        }
    );
}
