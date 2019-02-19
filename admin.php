<!DOCTYPE html>
<html>
<head>
  <style>
  .grid-container {
    display: inline-grid;
    grid-template-columns: auto auto auto auto auto auto auto auto auto auto auto auto auto auto auto auto auto auto auto auto auto auto auto auto auto auto auto auto auto auto auto auto auto auto auto auto auto auto auto auto auto auto auto auto auto auto auto auto auto auto auto auto auto auto auto auto auto auto auto auto;
    <!--background-color: #2345F4;-->
    padding: 0px;
  }
  .grid-item {
    <!--background-color: rgba(255, 255, 255, 0.8);-->
    border: 0px solid rgba(0, 0, 0, 0.8);
    padding:5px;
    font-size: 30px;
    text-align: center;
    opacity: 1;
  }
  #example2 {
    background: url("../map.jpg");
    padding: 0px;
    background-repeat: no-repeat;
    background-size: 600px 600px;
  }
  </style>


  <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
  <script type="application/javascript" >
  var name_temp;
  function myfunction(){
    var url_string = window.location.href; //window.location.href
    var url = new URL(url_string);
    var brad = url.searchParams.get("RN");
    name_temp = brad;
    // window.alert(b);
    var a="../" + brad;
    var elem = document.getElementById("example2");
    elem.style.background="url('" + a + "')";
    elem.style.backgroundRepeat="no-repeat";
    elem.style.backgroundSize="600px 600px";
  }
  var cords = [];
  var connected_nodes = [];
  var name_string = [];
  var description = [];
  var Tag_strings = [];
  for (var temp = 0; temp < 3600 ; temp++) {
    connected_nodes[temp] = [];
    Tag_strings[temp] = [];
    name_string[temp] = '';
    description[temp] = '';
  }
  var edge_index = -1;
  var Node_select = false;
  var Edge_select = false;
  var Tag = false;
  var delete_ = false;
  var select = 0;
  var tag_select = 0;
  var tag_index = -1;
  var finalJSON = '';
  var str;
  var str1 = '';
  var str2 = '';

  function clk(i){
    //alert("you have selected 2 points");
    /*<!--document.getElementById("response").innerHTML = resp;-->
    document.getElementById(i).style.backgroundColor = "red";
    <!--document.getElementById("test").innerHTML = cords.length;-->
    cords.push(i);*/
    if(Tag){
      if(tag_select == 1){
        alert("You have already selected a node");
        return;
      }
      tag_index = find(i,cords);
      if (tag_index == -1) {
        alert("Please select registered point");
        return;
      }
      tag_select = 1;
      yellow(i);
    } else if(Node_select){
      //red(i);
      select = 0;
      if (find(i,cords) == -1){
        cords.push(i);
        red(i);
      }
      else{
        alert("You have already selected the node");
      }
    } else if (Edge_select) {
      if (find(i,cords) == -1) {
        alert("Please select one of the registered points");
      }else{
        if(select == 0){
          blue(i);
          edge_index = find(i,cords);
          select = 1;
        }
        else{
          yellow(i);
          connected_nodes[edge_index].push(i);
          connected_nodes[find(i,cords)].push(cords[edge_index]);
          finalpath(i,cords[edge_index]);
          blue(cords[edge_index]);
        }
      }
    } else if (delete_) {
      var index_delete = find(i,cords);
      if(index_delete == -1){
        alert("Please select registered point");
      }
      else {

      for (var r = 0; r < connected_nodes[index_delete].length; r++) {

        //finaldelete(i,connected_nodes[index_delete][r]);
        valuedelete(i,connected_nodes[find(connected_nodes[index_delete][r],cords)]);
      }
      connected_nodes.splice(index_delete,1);
      Tag_strings.splice(index_delete,1);
      name_string.splice(index_delete,1);
      description.splice(index_delete,1);
      valuedelete(i,cords);
      display();

      }


      }
}
  function find(key,array){
    for (var i = 0; i < array.length; i++) {
      if (array[i] == key) {
        return i;
      }
    }
    return -1;
  }
  function green(i){
    document.getElementById(i).style.backgroundColor = "lawngreen";
    document.getElementById(i).style.opacity = "1";
  }
  function valuedelete(q,w){
    var ind = find(q,w);
    w.splice(ind,1);
  }
  function red(i){
    document.getElementById(i).style.backgroundColor = "red";
    document.getElementById(i).style.opacity = "1";
  }
  function yellow(i){
    document.getElementById(i).style.opacity = "1";
    document.getElementById(i).style.backgroundColor = "yellow";
  }
  function blue(i) {
    document.getElementById(i).style.opacity = "1";
    document.getElementById(i).style.backgroundColor = "blue";
  }
  function stop(){
    if(Edge_select){
      red(cords[edge_index]);
    }
    Node_select = false;
    Edge_select = false;
    select = 0;
    delete_  = false;
    Cancel_tag();
  }
  function path(x,y){
    var a,b,c,d,e,f,g;
    a = Math.floor(x/100); b = x%100;
    c = Math.floor(y/100); d = y%100;
    e = Math.floor((a+c)/2);
    f = Math.floor((b+d)/2);
    if (e==a & f==b) {
      g = 100*c +b ;
      green(g);
    }
    else if (e==c & f==d) {
      g = 100*a +d ;
      green(g);
    } else {
      g = 100*e + f;
      green(g);
      path(g,x);
      path(g,y);
    }
  }
  function deletepath(x,y){
    var a,b,c,d,e,f,g;
    a = Math.floor(x/100); b = x%100;
    c = Math.floor(y/100); d = y%100;
    e = Math.floor((a+c)/2);
    f = Math.floor((b+d)/2);
    if (e==a & f==b) {
      g = 100*c +b ;
      disappear(g);
    }
    else if (e==c & f==d) {
      g = 100*a +d ;
      disappear(g);
    } else {
      g = 100*e + f;
      disappear(g);
      deletepath(g,x);
      deletepath(g,y);
    }
  }
  function finaldelete(x,y){
    deletepath(x,y);
    //red(x);
    red(y);
  }
  function finalpath(x,y){
    path(x,y);
    red(x);
    red(y);
  }
  function Nodeselect(){
    if(Tag){
      alert("Please submit tag response or cancel it to proceed");
      return;
    }
    if(Edge_select & edge_index != -1){
      red(cords[edge_index]);
    }


    Node_select = true;
    Edge_select = false;
    delete_ = false;
    select = 0;
  }
  function Edgeselect(){
    if(Tag){
      alert("Please submit tag response or cancel it to proceed");
      return;
    }
    Node_select = false;
    Edge_select = true;
    delete_ = false;
  }
  /*function debug(){
  var strin = "";
  for (var i = 0; i < connected_nodes[0].length; i++) {
  strin  = strin + " " + connected_nodes[0][i];
}
document.getElementById('test').innerHTML = strin;
}*/
function display(){
  reset();
  for (var q = 0; q < cords.length; q++) {
    for (var w = 0; w < connected_nodes[q].length; w++) {
      finalpath(cords[q],connected_nodes[q][w]);
    }
  }
  for (var o = 0; o < cords.length; o++) {
    red(cords[o]);
  }
}
function Print(){
  console.log(cords,connected_nodes,Tag_strings,name_string,description);
}
function disappear(x){
  document.getElementById(x).style.backgroundColor = "";
}
function Delete(){
  if(Tag){
    alert("Please submit tag response or cancel it to proceed");
    return;
  }
  delete_ = true;
  Node_select = false;
  if(Edge_select){
    red(cords[edge_index]);
  }
  Edge_select = false;

}
function reset(){
  var kk = 0;
  for (var ii = 0; ii < 60; ii++) {
    for (var jj = 0; jj < 60; jj++) {
      kk = 100*ii + jj;
      document.getElementById(kk).style.backgroundColor = "";
    }
  }
}
function Submit(){

  Create_JSON();
  document.getElementById('json').innerHTML = finalJSON;
  Print();

  var name = name_temp.replace('.jpg','');
  alert("name : " + finalJSON);
  document.getElementById('name').innerHTML = name;
  if(name == ""){
    alert("Please enter a tag");
    return;
  }else{
    //alert("q");
    //alert($("#name").html());
    //alert("w");
    alert($("#json").html());
    send();
    alert("done");
  }


}
function send(){
  $.post("upload.php",{name: $("#name").html(),JSON_string: $("#json").html()});

}
function Update(){

  Create_JSON();
}
/*function Create_JSON(){
finalJSON = '{"cords":[';
for (var count = 0; count < cords.length; count++) {
str = '{"value":';
str += cords[count] + ',"connected_nodes":['
str1 = '';
for (var c = 0; c < connected_nodes[count].length; c++) {
str1 += connected_nodes[count][c] + ',';
}
str1 = str1.substring(0,str1.length-1);
str += str1;
str += '],"Tags":[';
str2 = '';
for (var y = 0; y < Tag_strings[count].length; y++) {
str2 += '"' + Tag_strings[count][y] + '",';
}
str2 = str2.substring(0,str2.length-1);
str += str2;
str += ']}'
finalJSON += str + ',';
}
finalJSON = finalJSON.substring(0,finalJSON.length - 1);
finalJSON += ']}' ;
}*/
function Create_JSON(){
  finalJSON = '{"cords":[';
  for (var count = 0; count < cords.length; count++) {
    str = '{"value":';
    str += cords[count] + ',"connected_nodes":['
    str1 = '';
    for (var c = 0; c < connected_nodes[count].length; c++) {
      str1 += connected_nodes[count][c] + ',';
    }
    str1 = str1.substring(0,str1.length-1);
    str += str1;
    str += '],"Tags":[';
    str2 = '';
    for (var y = 0; y < Tag_strings[count].length; y++) {
      str2 += '"' + Tag_strings[count][y] + '",';
    }
    str2 = str2.substring(0,str2.length-1);
    str += str2;
    str += '],"name":"';
    if (name_string[count] != '') {
      str += name_string[count];
    }
    str += '","description":"';
    if (description[count] != '') {
      str += description[count];
    }
    str += '"}';
    finalJSON += str + ',';
  }
  finalJSON = finalJSON.substring(0,finalJSON.length - 1);
  finalJSON += ']}' ;
  //alert(finalJSON);
}
function Cancel_tag(){
  if(tag_index != -1){
    red(cords[tag_index]);
  }
  document.getElementById('response_tag').innerHTML = '';
  document.getElementById('response_name').innerHTML = '';
  document.getElementById('response_description').innerHTML = '';
  document.getElementById('buttons').innerHTML = '';
  tag_index = -1;
  tag_select = 0;
  Tag = false;
}
function Submit_tag(){
  var input = document.getElementById('Tag_input').value;
  if(input == ""){
    alert("Please enter a tag");
    return;
  }
  if(tag_index == -1 || tag_select == 0){
    alert("Please select a node");
    return;
  }
  Tag_strings[tag_index].push(input);
  document.getElementById('Tag_input').value = "";
  //   document.getElementById('response').innerHTML = '';
  //   document.getElementById('buttons').innerHTML = '';
  //   if(tag_index != -1){
  //     red(cords[tag_index]);
  //   }
  // tag_index = -1;
  // tag_select = 0;
  // Tag = false;
}
function Submit_name(){

  var input = document.getElementById('Name_input').value;
  if(input == ""){
    alert("Please enter a name");
    return;
  }
  // alert(input);
  if(tag_index == -1 || tag_select == 0){
    alert("Please select a node");
    return;
  }
  if (name_string[tag_index] == '') {
    name_string[tag_index] = input;
  } else {
    alert("Name for this node is now replaced");
    name_string[tag_index] = input;
  }
  document.getElementById('Name_input').value = "";
  //   document.getElementById('response').innerHTML = '';
  //   document.getElementById('buttons').innerHTML = '';
  //   if(tag_index != -1){
  //     red(cords[tag_index]);
  //   }
  // tag_index = -1;
  // tag_select = 0;
  // Tag = false;
}
function Submit_description(){
  var input = document.getElementById('Description_input').value;
  if(input == ""){
    alert("Please enter a description");
    return;
  }
  if(tag_index == -1 || tag_select == 0){
    alert("Please select a node");
    return;
  }
  if (description[tag_index] == '') {
    description[tag_index] = input;
    // alert("description saved : " + input);
  } else {
    // alert("description of this node is now replaced");
    description[tag_index] = input;
  }
  document.getElementById('Description_input').value = "";
  //   document.getElementById('response').innerHTML = '';
  //   document.getElementById('buttons').innerHTML = '';
  //   if(tag_index != -1){
  //     red(cords[tag_index]);
  //   }
  // tag_index = -1;
  // tag_select = 0;
  // Tag = false;
}
function tagg(){
  if(Edge_select){
    red(cords[edge_index]);
  }
  //alert("PLease select a node");
  Tag = true;
  Node_select = false;
  Edge_select = false;
  delete_ = false;
  select = 0;
  document.getElementById('response_name').innerHTML = '<input type="text" id="Name_input"><button id = "Name_submit" type="button" onclick ="Submit_name()" >Submit name</button>';
  document.getElementById('response_description').innerHTML = '<input type="text" id="Description_input"><button id = "Description_submit" type="button" onclick ="Submit_description()" >Submit description</button>';
  document.getElementById('response_tag').innerHTML = '<input type="text" id="Tag_input"><button id = "Tag_submit" type="button" onclick ="Submit_tag()" >Submit tag</button>';
  document.getElementById('buttons').innerHTML = '<button id = "Tag_cancel" type="button" onclick ="Cancel_tag()" >Done</button>';
}
function mouseOver(i){
  if(Node_select){
    red(i);
    document.getElementById(i).style.opacity = "0.5";
  }
}
function mouseOut(i){
  if(Node_select){
    reset();
    display();
  }
}



</script>
</head>
<body>
<body onload="myfunction()">
<h1>Sample grid</h1>
<!-- <p>Name : <input type="text" id="name"></p> -->
<p id = "temporary"></p>
<div id="example2">
<div class="grid-container">
<script type="text/javascript">
for(var i=0;i<60;i++){
  for (var j=0;j<60 ;j++ ) {
    var k =100*i + j;
    document.write("<div class=\"grid-item\" id = \""+k+"\" onclick =\"clk("+k+")\" onmouseover = \"mouseOver("+k+")\" onmouseout = \"mouseOut("
    +k+")\"></div>");
  }}
  </script>
  </div>
  </div>
  <!--      <button type="button" onclick ="finalpath(cords[0],cords[1])" >JOIN</button> -->
  <button id = "Node" type="button" onclick ="Nodeselect()" >Node</button>
  <button id = "Edge" type="button" onclick ="Edgeselect()" >Edge</button>
  <button id = "Stop" type="button" onclick ="stop()" >Stop</button>
  <!--<button id = "Display" type="button" onclick ="display()" >Display</button>-->
  <!--<button id = "Debug" type="button" onclick ="debug()" >Debug</button>-->
  <!--<p id = "response">Clicked at => </p>-->
  <!--<button id = "Print" type="button" onclick ="Print()" >Print</button>-->
  <button id = "Delete" type="button" onclick ="Delete()" >Delete</button>
  <button id = "Tags" type="button" onclick ="tagg()" >Name</button>
  <p id = "response_name"></p>
  <p id = "response_tag"></p>
  <p id = "response_description"></p>
  <p id = "buttons"></p>
  <button id = "Submit" type="button" onclick ="Submit()" >Submit</button>
  <button id = "Update" type="button" onclick ="Update()" >Update</button>
  <p hidden id = "json"></p>
  <p hidden id = "name"></p>
  </body>
  </html>

  <!-- tags -> nearby services, multiple strings  -->
  <!-- name -> unique identifier for user ( and admin)  -->
  <!-- description -> unique string,describes the node  -->
