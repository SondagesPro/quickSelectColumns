/**
 * @file quickcolumnselect part of quickSelectColumns LimeSUrvey Plugin
 * @author Denis Chenu
 * @copyright Denis Chenu <http://www.sondages.pro>
 * @copyright Ysthad <http://www.ysthad.com>

 * @license magnet:?xt=urn:btih:1f739d935676111cfff4b4693e3816e664797050&dn=gpl-3.0.txt GPL-v3-or-Later
 */

$(function() {
  var htmlQuickColumn="";
  htmlQuickColumn=htmlQuickColumn+"<label for='quickselectcolumn' class='quickselectcolumn-label clearfix'>Sélection rapide</label>";
  htmlQuickColumn=htmlQuickColumn+"<a href='#' id='quickselectcolumn-copycode'><strong>↓</strong> copier les codes</a> | <a href='#' id='quickselectcolumn-pastecode'><strong>↑</strong> coller les codes</a>";
  htmlQuickColumn=htmlQuickColumn+"<textarea name='quickselectcolumn' id='quickselectcolumn'  class='clearfix quickselectcolumn-textarea'></textarea>";
  $(htmlQuickColumn).insertAfter("#colselect");
});

$(document).on("click","#quickselectcolumn-copycode",function(){
    $("#quickselectcolumn").text("");
    labelarray=new Array();
    $("#colselect option:selected").each(function(){
        labelarray.push($(this).data('emcode'));
    });
    $("#quickselectcolumn").val(labelarray.join(' , '));
  return false;
});
$(document).on("click","#quickselectcolumn-pastecode",function(){
    $("#colselect").val("");
    textlabels=$("#quickselectcolumn").val();
    labelarray=textlabels.split(',');
    $.each(labelarray, function(index, value) {
        textlabel=$.trim(value);
        console.log(value);
        if(textlabel && textlabel!=""){
            $('#colselect option[data-emcode="'+textlabel+'"]').prop("selected",true);// Selection du label exact
            $('#colselect option[data-emcode^="'+textlabel+'_"]').prop("selected",true);// Selection du label de la question correspondante
        }
    });
  return false;

});
