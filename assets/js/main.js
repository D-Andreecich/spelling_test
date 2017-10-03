/**
 * Created by D-Andreevich on 27.09.2017.
 */

console.log('load js');

//console.log(JSON.parse(data));


function add_word() {
    var num_i = document.getElementById ('id_word').value;
    var originDiv = document.getElementById('input_word_'+num_i);
    /*var span = document.createElement('span');
    var text = document.createTextNode(num_i);
    span.appendChild(text);
    originDiv.appendChild(span);*/

    document.getElementById('id_word').value = ++num_i;//+document.getElementById('id_word').value+1;

    var cloneDiv = originDiv.cloneNode(true);

    cloneDiv.id = 'input_word_'+num_i;
    cloneDiv.getElementsByTagName('span')[0].innerText = num_i + ')';
    cloneDiv.getElementsByTagName('input')[0].name = 'original_word_'+num_i;
    cloneDiv.getElementsByTagName('input')[0].value = '';
    cloneDiv.getElementsByTagName('input')[1].name = 'modified_word_'+num_i;
    cloneDiv.getElementsByTagName('input')[1].value = '';
    cloneDiv.getElementsByTagName('input')[2].name = 'options_for_word_'+num_i;
    cloneDiv.getElementsByTagName('input')[2].value = '';
    cloneDiv.getElementsByTagName('input')[3].name = 'rules_for_word_'+num_i;
    cloneDiv.getElementsByTagName('input')[3].value = '';

    originDiv.parentNode.insertBefore(cloneDiv, originDiv);
}

function del_word() {
    var num_i = document.getElementById ('id_word').value;
    if (num_i != 1){
        var originDiv = document.getElementById('input_word_'+num_i);
        document.getElementById('id_word').value = --num_i;//+document.getElementById('id_word').value+1;
        originDiv.remove();
    }

}

function options_words(id){
    console.log('option_id = '+id);
}

function check_test() {
    console.log('test_on');
    // while ()
}