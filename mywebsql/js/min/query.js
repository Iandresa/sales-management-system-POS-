/*
    http://mywebsql.net/license
*/
var _init=!1,resultInfo="",editTableName="",currentQuery="",queryID="",editKey=[],totalRecords=0,totalPages=1,currentPage=1,numRecords=0,sql_delimiter=";\n";function initStart(){if(_init)return!0;_init=!0;loadUserPreferences();(x=$.cookies.get("sql_commandEditor"))&&setSqlCode(x);showNavBtns("query","queryall");commandEditor.focus()}
function getResults(a){xfrm=getFrame();0==a?x=xfrm.document.getElementById("results").innerText?xfrm.document.getElementById("results").innerText:xfrm.document.getElementById("results").textContent?xfrm.document.getElementById("results").textContent:xfrm.document.getElementById("results").innerHTML:1==a?x=xfrm.document.getElementById("results").innerHTML:2==a&&(x=xfrm.document.getElementById("title").innerHTML);return x}
function queryGo(a){strQuery=getSqlCodeSelection();strMsg=__("all selected");""==strQuery&&(strQuery=getSqlCode(),strMsg=__("all"));""==$.trim(strQuery)?jAlert(__("Please type in one or more queries in the sql editor!"),__("Execute query"),function(){focusEditor()}):(querySaveCache(strQuery),1==a?(msg=str_replace("{{SELECTED}}",strMsg,__("Are you sure you want to execute {{SELECTED}} queries?")),optionsConfirm(msg,"query.all",function(a,c,d){if(a){d&&optionsConfirmSave(c);wrkfrmSubmit("queryall",
"","",strQuery)}})):wrkfrmSubmit("query","","",strQuery),focusEditor())}
function queryDelete(){qBig="";discardRows=[];checked=$("#result_form input:checked").not(".check-all");if(0==checked.length)return"";checked.each(function(){row=$(this).parent().parent();row.hasClass("n")?discardRows.push(row):qBig+=makeDeleteClause(row)});checked.prop("checked",!1);$("#dataTable input.check-all").prop("checked",!1);$(discardRows).each(function(){this.remove()});if(0<arguments.length&&!0==arguments[0])return qBig;showNavBtns("query","queryall");""!=qBig&&wrkfrmSubmit("queryall",
"","",qBig)}
function querySave(){editRows=$("#dataTable tbody tr.x").add("#dataTable tbody tr.n");if(0==editRows.length)return"";qBig="";editRows.each(function(){upd=(newRecord=$(this).hasClass("n"))?"insert into "+BACKQUOTE+editTableName+BACKQUOTE+" set ":"update "+BACKQUOTE+editTableName+BACKQUOTE+" set ";whr=st="";editCols=$(this).find("td.x");editCols.each(function(){data=$(this).data("edit");newRecord&&"object"!=typeof data&&(data={setNull:!0,value:""});"object"==typeof data&&(txt="",f=getFieldName($(this).index()-2),
txt=data.setNull?"NULL,":'"'+data.value.replace(/\\/g,"\\\\").replace(/\"/g,'\\"')+'",',st+=BACKQUOTE+f+BACKQUOTE+"="+txt)});""!==st&&(st=st.substr(0,st.length-1),qBig=newRecord?qBig+(sql_delimiter+upd+st):qBig+(sql_delimiter+upd+st+makeWhereClause($(this))))});$("#dataTable tbody .x").add("#dataTable tbody .n").removeClass("x n").data("edit",null);if(0<arguments.length&&!0==arguments[0])return qBig;showNavBtns("query","queryall");wrkfrmSubmit("queryall","","",qBig)}
function queryGenerate(){del=queryDelete(!0);sql=querySave(!0)+del;setSqlCode(sql,1);showNavBtns("query","queryall")}
function queryAddRecord(){num=$("#dataTable tbody tr").length+1;row='<tr class="row n"><td class="tj">'+num+'</td><td class="tch"><input type="checkbox" /></td>';for(i=0;i<fieldInfo.length;i++)txt=fieldInfo[i].blob?'<span class="data">NULL</span>':"NULL",cls=fieldInfo[i].blob?"edit blob tnl":"edit tnl",row+='<td class="'+cls+'" nowrap="wrap">'+txt+"</td>";row+="</tr>";row=$(row);row.find("td.edit").bind(editOptions.editEvent,editOptions.editFunc);row.find("input").click(function(){showNavBtn("delete",
"gensql")});$("#dataTable tbody").append(row);$(".ui-layout-data-center").tabs("select",0);setTimeout(function(){bottom=$("#results-div").prop("scrollHeight");$("#results-div").prop("scrollTop",bottom)},50)}
function queryCopyRecord(){checked=$("#result_form input:checked").not(".check-all");if(0==checked.length)return"";checked.each(function(){old_row=$(this).parent().parent();num=$("#dataTable tbody tr").length+1;row=$(old_row).clone(!0,!0);row.addClass("n").removeClass("ui-state-active");td=row.children("td");td.find("input").prop("checked",!1);td.eq(0).text(num);for(i=0;i<fieldInfo.length;i++)current=td.eq(i+2),current.addClass("x"),(is_null=fieldInfo[i].autoinc||current.find("span.blob").length)&&
current.text("NULL").addClass("tnl"),txt=current.find("span.d").length?current.find("span.d").text():current.html(),data={setNull:is_null,value:txt},current.data("edit",data);$("#dataTable tbody").append(row)});checked.prop("checked",!1);$("#dataTable input.check-all").prop("checked",!1);showNavBtn("update","gensql");row.trigger("click");$(".ui-layout-data-center").tabs("select",0);setTimeout(function(){bottom=$("#results-div").prop("scrollHeight");$("#results-div").prop("scrollTop",bottom)},50)}
function queryRefresh(){if(""==currentQuery)return jAlert(__("Failed to refresh the results."),__("Refresh results"),function(){focusEditor()}),!1;wrkfrmSubmit("query","","",currentQuery);focusEditor()}function transferQuery(){htm=sql_delimiter+getResults(0);setSqlCode(htm,1);setPageStatus(!1);commandEditor.focus()}
function transferResultMessage(a,b,c){resultInfo="";$("#messages-div").html(getResults(1));document.getElementById("timeCounter").innerHTML=b;document.getElementById("messageContainer").innerHTML=c;$(".ui-layout-data-center").tabs("select",1);$("#messages-div").prop("scrollTop",0).prop("scrollLeft",0);commandEditor.canHighlight()&&(div=$("#messages-div div.sql-text"),0<div.length&&(code=div.html2txt(),obj_lines=$('<div class="sql_lines"></div>'),obj_out=$('<pre class="sql_output cm-s-default"></pre>'),
div.html("").append(obj_lines).append(obj_out),commandEditor.highlightSql($("#messages-div pre.sql_output"),$("#messages-div div.sql_lines"),code)));setPageStatus(!1);showNavBtns("query","queryall")}
function transferInfoMessage(){resultInfo="";$("#info-div").html(getResults(1));$(".ui-layout-data-center").tabs("select",2);$("#info-div").attr("scrollTop",0).prop("scrollLeft",0);commandEditor.canHighlight()&&(div=$("#info-div div.sql-text"),0<div.length&&(code=div.html2txt(),obj_lines=$('<div class="sql_lines"></div>'),obj_out=$('<pre class="sql_output cm-s-default"></pre>'),div.html("").append(obj_lines).append(obj_out),commandEditor.highlightSql($("#info-div pre.sql_output"),$("#info-div div.sql_lines"),
code)));0<$("#infoTable").length&&setupTable("infoTable",{highlight:!0,selectable:!0,editable:!1,sortable:!0});setPageStatus(!1);showNavBtns("query","queryall");$("#quick-info-search").bind("keyup",function(){$("#infoTable").setSearchFilter($(this).val())})}
function transferResultGrid(a,b,c){resultInfo="";$("#results-div").html("<form id='result_form' name='resForm' method='post' action='#' onsubmit='return false;'>"+getResults(1)+"</form>");-1==a?document.getElementById("recordCounter").innerHTML="&nbsp;":document.getElementById("recordCounter").innerHTML=totalRecords+" record(s)";document.getElementById("timeCounter").innerHTML=b;document.getElementById("messageContainer").innerHTML=c;$("#headerResults").html(getResults(2));numRecords=a;0<a&&setupResults();
$(".ui-layout-data-center").tabs("select",0);$("#results-div").prop("scrollTop",0).prop("scrollLeft",0);if(1<totalPages){str=__("Results page:")+"&nbsp;";str+=1==currentPage?'<span class="page">'+__("Previous")+"</span>":'<a href="javascript:goPage('+(currentPage-1)+')">'+__("Previous")+"</a>";str+='<select id="page_selector" name="page" onchange="javascript:goPage(this.value)">';for(i=1;i<=totalPages;i++)str+=i==currentPage?'<option selected="selected" value="'+i+'">'+i+"</option>":'<option value="'+
i+'">'+i+"</option>";str+="</select>";str+=totalPages==currentPage?'<span class="page">'+__("Next")+"</span>":'<a href="javascript:goPage('+(currentPage+1)+')">'+__("Next")+"</a>";$("#pagingContainer").html(str)}else $("#pagingContainer").html("");setPageStatus(!1);""==editTableName?showNavBtns("query","queryall"):showNavBtns("addrec","query","queryall")}function getFieldInfo(a){return fieldInfo[a]}function getFieldName(a){return fieldInfo[a].name}
function makeWhereClause(a){str=" where ";if(0==editKey.length)for(i=0;i<fieldInfo.length;i++){if(td=a.find("td").eq(i+2),!td.find("span.blob").length){if(td.data("defText"))val=td.data("defText");else{var b=td.find("span.d");val=b.length?b.text():td.text()}str+=BACKQUOTE+getFieldName(i)+BACKQUOTE+"='"+val+"' and "}}else for(i=0;i<fieldInfo.length;i++)-1!=editKey.indexOf(getFieldName(i))&&(td=a.find("td").eq(i+2),val=td.data("defText")?td.data("defText"):td.text(),str+=BACKQUOTE+getFieldName(i)+BACKQUOTE+
"='"+val+"' and ");return str.substr(0,str.length-5)}function makeDeleteClause(a){return str=sql_delimiter+"delete from "+BACKQUOTE+editTableName+BACKQUOTE+" "+makeWhereClause(a)}function querySaveCache(){$.cookies.set("sql_commandEditor",getSqlCode(),{path:EXTERNAL_PATH})}
function vwBlb(a,b,c){span=$(a);fi=getFieldInfo(span.parent("td").index()-(""==editTableName?1:2));name=fi.name;tr=span.parent().parent();taskbar.openModal("blob-editor","?q=wrkfrm&type=viewblob&id="+b+"&name="+name+"&blobtype="+c+"&query="+queryID,500,300)}function vwTxt(a,b){msg=str_replace("{{SIZE}}",b,__("Text Data [{{SIZE}}]"));span=$(a).siblings("span.d");fi=getFieldInfo(span.parent("td").index()-(""==editTableName?1:2));name=fi.name;jAlert(span.html(),msg)}function loadUserPreferences(){}
function resultSelectAll(){check=$("#dataTable input.check-all").prop("checked");$("#dataTable input").prop("checked",check);check?showNavBtn("delete","gensql"):hideNavBtn("delete","gensql")}function getSqlCode(){ed=currentEditor();return ed.getCode()}function setSqlCode(a,b){commandEditor.setCode(1==b?commandEditor.getCode()+a:a);1==b&&commandEditor.jumpToLine(commandEditor.lastLine());switchEditor(0)}function getSqlCodeSelection(){ed=currentEditor();return ed.getSelection()}
function getSelRecCount(){checked=$("#dataTable input:checked").not(".check-all");return checked.length}function getHistoryText(a){txt="";if(a&&!historyCurItem)return txt;obj=a?historyCurItem.find("td.hst"):$("#sql-history .hst");for(i=0;i<obj.length;i++)txt+=$(obj[i]).html()+"\n";return txt}function historyClear(){optionsConfirm(__("Clear command history?"),"history.clear",function(a,b,c){a&&(c&&optionsConfirmSave(b),$("#sql-history").html("<tbody></tbody>"))})}
function setupResults(){setupTable("dataTable",{highlight:!0,selectable:!0,editable:""!=editTableName,sortable:!0});""!=editTableName&&$("#dataTable input").not("check-all").click(function(){showNavBtn("delete","copyrec","gensql")})}function postSortTable(){}function goPage(a){wrkfrmSubmit("query","table",a,editTableName)}$.fn.html2txt=function(){txt=$(this).html().replace(/<br>/ig,"\n").replace(/&amp;/g,"&").replace(/&lt;/g,"<").replace(/&gt;/g,">").replace(/&quot;/g,'"');return $.trim(txt)};
$.fn.outerHTML=function(a){return a?this.before(a).remove():jQuery("<p>").append(this.eq(0).clone()).html()};$.getSelectedText=function(){if(window.getSelection)return window.getSelection();if(document.getSelection)return document.getSelection();var a=document.selection&&document.selection.createRange();return a.text?a.text:""};
