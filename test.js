var n1=0;
var skipped;
var answered;
var tot_ques=questions.length;
function display_question (n) {
	var j=n;
	j++;
	for(var i = 0,len = questions.length;i < len; i++){
    	if(questions[i]['ques-id'] == questions_id[n]){
	       var ques = questions[i]['question'];
	    }
	}

	document.getElementById("question").innerHTML = ques;
	document.getElementById("question.no").innerHTML = "Question No: "+pad(j);
	document.getElementById("skipped").innerHTML = "Skipped : "+skipped;
	document.getElementById("answered").innerHTML = "Answered : "+answered;
	document.getElementById(questions_id[n]).removeAttribute("class");
	document.getElementById(questions_id[n]).setAttribute("class","active");
	document.getElementById("tag"+n).removeAttribute("class");
	if (skipped_ques.length) {
	//	document.getElementById("ans").innerHTML = skipped_ques.indexOf(n);
	};
	var j=0;
	n1=n;
	function makeRadioButton(name, value, text) {
		var radio_home = document.getElementById("choice");
    	var label = document.createElement("label");
    	var radio = document.createElement("input");
    	var br = document.createElement("br");
    	radio.type = "radio";
    	radio.name = name;
    	radio.value = value;
    	radio.setAttribute("onclick","Enablesubmit(this)" );
    	label.style.width="100%";
    	label.appendChild(br);
    	label.appendChild(radio);
    	label.appendChild(document.createTextNode(text));
    	radio_home.appendChild(label);
  	}
  	function makeButton(name, value,action,type) {
		var button_home = document.getElementById("button");
    	button = document.createElement("button");
    	var br = document.createElement("br");
    	button.type = "button";
    	button.name = name;
    	button.innerHTML = value;
    	if(type=="submit"){
    		button.id="submit";
    		button.setAttribute("disabled","true");
    	}
    	button.setAttribute("class","btn btn-primary");
    	button.setAttribute("onclick",action );
    	button_home.appendChild(button);
  	}
	for(var i = 0,len = options.length;i < len; i++){
    	if(options[i]['ques-id'] == questions_id[n]){
	        makeRadioButton(options[i]['ques-id'], options[i]['option-id'], options[i]['option']);
	    }
	}
	makeButton("skip","Skip","skip1("+n+");");
	makeButton("submit","Submit","submit1("+n+");","submit");	
	Cookies.set("current",n);
}
function skip1 (n) {
	index=skipped_ques.indexOf(n);
	remove_element("choice");
	remove_element("button");
	if(index==-1){
		skipped_ques.push(n);
		skipped=skipped_ques.length;
		Cookies.set('skipped_ques', skipped_ques);
		Cookies.set('skipped', skipped);
	}

	document.getElementById(questions_id[n]).removeAttribute("class");
	next_question(n);
}
function submit1 (n) {
	var ansid = get_value(questions_id[n]);
	answers.push({"ques-id":questions_id[n],"ans-id":ansid});
	answered=answers.length;
	answered_ques.push(n);
	Cookies.set('answers', answers);
	Cookies.set('answered', answered);
	Cookies.set('answered_ques', answered_ques);
	document.getElementById(questions_id[n]).setAttribute("class","disabled");
	document.getElementById("tag"+n).removeAttribute("onclick");
	remove_element("question");
	remove_element("choice");
	remove_element("button");
	index=skipped_ques.indexOf(n);
	if(index!=-1){
		skipped_ques.splice(index, 1);
		// alert("splice");
		skipped=skipped_ques.length;
		Cookies.set('skipped_ques', skipped_ques);
		Cookies.set('skipped', skipped);
	}
	if (answered==tot_ques) {
		ajax_post();
	}
	else{
		next_question(n);
	}
}
function next_question(n){
	n=n+1;
	// alert("next:"+n);
	if(n==tot_ques){
		n=0;
	}
	index=answered_ques.indexOf(n);
	if (index==-1) {
		display_question(n);
	}
	else{
		next_question(n);
	}
	
}
function skip2 (arg) {
	index=skipped_ques.indexOf(n1);
	remove_element("choice");
	remove_element("button");
	if(index==-1){
		skipped_ques.push(n1);
		skipped=skipped_ques.length;
		Cookies.set('skipped_ques', skipped_ques);
		Cookies.set('skipped', skipped);
	}
	// document.getElementById(questions_id[n1]).removeAttribute("class");
	arg-=1;
	document.getElementById(questions_id[n1]).removeAttribute("class");
	next_question(arg);
}
function get_value (qid) {
	var radios = document.getElementsByName(qid);
	for (var i = 0, length = radios.length; i < length; i++) {
    	if (radios[i].checked) {
        return radios[i].value;
    	}
	}
}
function remove_element(tagname) {
    var myNode = document.getElementById(tagname);
    while (myNode.firstChild) {
	    myNode.removeChild(myNode.firstChild);
	}
}
function Enablesubmit (val) {
    var sbmt = document.getElementById("submit");

    if (val.checked == true)
    {
        sbmt.disabled = false;
    }
    else
    {
        sbmt.disabled = true;
    }
}
function pad(n) {
    return (n < 10) ? ("0" + n) : n;
}
function makequestionbutton () {
		var questionbutton_home = document.getElementById("pagination");
		for (var i = 0,count=1; i < questions.length; i++,count++) {
			var litag = document.createElement("li");
			var atag= document.createElement("a");
			atag.setAttribute("onclick","skip2("+i+")" );
			atag.setAttribute("id","tag"+i);
			atag.innerHTML=count;
			litag.appendChild(atag);
			if (answered_ques.indexOf(i)!=-1) {
				litag.setAttribute("class","disabled");
				atag.setAttribute("class","disabled");
				atag.removeAttribute("onclick");
			};
			litag.setAttribute("id",questions_id[i]);
			questionbutton_home.appendChild(litag);
		};
}
function checkcookie(){
	var questions_id1 = Cookies.getJSON('questions_id');
	var detail1 = Cookies.getJSON('detail');
	var answers1 = Cookies.getJSON('answers');
	var answered1 = Cookies.get('answered');
	var answered_ques1 = Cookies.getJSON('answered_ques');
	var skipped_ques1 = Cookies.getJSON('skipped_ques');
	var skipped1 = Cookies.get('skipped');
	var current = Cookies.get("current");
	if(typeof(current) == 'undefined' || current === null){
		skipped=0;
		answered=0;
		// alert("first");
		Cookies.set('questions_id', questions_id);
		Cookies.set('detail', detail);
		makequestionbutton();
		display_question(0);
	}
	else{
		if(typeof(answered1) == 'undefined' || answered1 === null){
			answered1=0;
		}
		if(typeof(skipped1) == 'undefined' || skipped1 === null){
			skipped1=0;
		}
		if(typeof(answered_ques1) == 'undefined' || answered_ques1 === null){
			answered_ques1=[];
		}
		if(typeof(skipped_ques1) == 'undefined' || skipped_ques1 === null){
			skipped_ques1=[];
		}
		if(typeof(answers1)!= 'undefined'){
			answers=answers.concat(answers1);
		}
		questions_id = questions_id1;
		detail = detail1;
		answered = answered1;
		skipped = skipped1;
		skipped_ques=skipped_ques1;
		answered_ques1 = answered_ques1.filter(function(v){return v!==''});
		answered_ques=answered_ques1;
		makequestionbutton();
		display_question(current);
	}
}
checkcookie();