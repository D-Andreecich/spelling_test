/**
 * Created by D-Andreevich on 27.09.2017.
 */

console.log('load js');

function defaultSelect() {
    var selectElement = document.getElementsByClassName('selectpicker');
    for (var i = 0; i < selectElement.length; i++) {
        selectElement[i].options['0'].selected = "selected";
    }
}

function add_word() {
    defaultSelect();
    var num_i = document.getElementById('id_word').value;
    var originDiv = document.getElementById('input_word_' + num_i);
    /*var span = document.createElement('span');
     var text = document.createTextNode(num_i);
     span.appendChild(text);
     originDiv.appendChild(span);*/

    document.getElementById('id_word').value = ++num_i;//+document.getElementById('id_word').value+1;

    var cloneDiv = originDiv.cloneNode(true);

    cloneDiv.id = 'input_word_' + num_i;
    cloneDiv.getElementsByTagName('span')[0].innerText = num_i + ')';
    cloneDiv.getElementsByTagName('input')[0].name = 'original_word_' + num_i;
    cloneDiv.getElementsByTagName('input')[0].value = '';
    cloneDiv.getElementsByTagName('input')[1].name = 'modified_word_' + num_i;
    cloneDiv.getElementsByTagName('input')[1].value = '';
    cloneDiv.getElementsByTagName('input')[2].name = 'options_for_word_' + num_i;
    cloneDiv.getElementsByTagName('input')[2].value = '';
    cloneDiv.getElementsByTagName('input')[3].name = 'rules_for_word_' + num_i;
    cloneDiv.getElementsByTagName('input')[3].value = '';

    if(cloneDiv.getElementsByTagName('input')[4] && cloneDiv.getElementsByTagName('input')[5]){
        cloneDiv.removeChild(cloneDiv.getElementsByTagName('input')[4]);
        cloneDiv.removeChild(cloneDiv.getElementsByTagName('input')[4]);
    }

    originDiv.parentNode.insertBefore(cloneDiv, originDiv);
}

function del_word() {
    defaultSelect();
    var num_i = document.getElementById('id_word').value;
    if (num_i != 1) {
        var originDiv = document.getElementById('input_word_' + num_i);
        document.getElementById('id_word').value = --num_i;//+document.getElementById('id_word').value+1;
        originDiv.remove();
    }
}

/*function options_words(id){
 console.log('option_id = '+id);
 }

 function check_test() {
 console.log('test_on');
 }*/

function addOptionsText(idSelect, arrayData) {
    var select = document.getElementById(idSelect);
    for (var i in arrayData) {
        var option = document.createElement("option");
        option.text = arrayData[i].substr(0, 90);
        option.value = i;
        select.appendChild(option);
    }
}

function addOptions(idSelect, arrayData) {
    var tempOption = document.getElementById(idSelect).options[0];
    document.getElementById(idSelect).innerHTML= '';
    document.getElementById(idSelect).options[0] = tempOption;
    var select = document.getElementById(idSelect);
    for (var i in arrayData) {
        var option = document.createElement("option");
        option.text = arrayData[i][idSelect];
        option.value = arrayData[i][idSelect];
        select.appendChild(option);
    }
}

function setValue(id) {
    var select = document.getElementById(id);
    var dataId = select.getAttribute('data-id') + document.getElementById('id_word').value;
    var val = select.value;
    document.getElementsByName(dataId)["0"].value = val;
}

function addWords() {
    var text = document.getElementById('inputTest').value;
    var tempArrRulesWords = [];
    var temp = [];
    var word = '';
    for (var i in arrRulesWords.words) {
        word = arrRulesWords.words[i]['original_word'];
        if (text.search(word) != -1) {
            if (temp.indexOf(word) == -1) {
                temp[i] = arrRulesWords.words[i]['original_word'];
                tempArrRulesWords[i] = arrRulesWords.words[i];
            }
        }
    }
    // addOptions('original_words', arrRulesWords.words);
    addOptions('original_word', tempArrRulesWords);
    // addOptions('modified_word', arrRulesWords.words);
    addOptions('modified_word', tempArrRulesWords);

}

function goAddOptoins(){
    /**
     * addWords();
     */
    //    addOptions('original_words', arrRulesWords.words);
    //    addOptions('modified_word', arrRulesWords.words);
    addWords();

    addOptions('rules_for_word', arrRulesWords.rules);
    addOptions('options', arrRulesWords.words);
}

function setText(id) {
    var select = document.getElementById(id);
    var dataId = select.getAttribute('data-id');
    var name = select.value;
    document.getElementsByName(dataId)["0"].value = arrText[name];

    addWords();
}