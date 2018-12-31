<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8"/>
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
         background: url("map.jpg");
         padding: 0px;
         background-repeat: no-repeat;
         background-size: 600px 600px;
         }
      </style>
      <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
      <script>
      <?php
      $dbhost = "localhost";
      $dbuser = "root";
      $dbpass = "root";
      $database="mysql";
      $conn = new mysqli($dbhost, $dbuser, $dbpass,$database);
      $sql = "SELECT JSON_string FROM mysql.first_test WHERE name = 'AIIMS' limit 1";
      $result = mysqli_query($conn, $sql);
      $row = mysqli_fetch_assoc($result);
      ?>
       alert("F");
       var tr = '<?php echo $row['JSON_stringy'] ;?>';
       alert(tr);
         //SAMPLE=>{"cords":[{"value":5626,"connected_nodes":[4726],"Tags":["entry"]},{"value":3226,"connected_nodes":[4726,3229,2226],"Tags":[]},{"value":3229,"connected_nodes":[3226],"Tags":["stairs","help desk"]},{"value":2226,"connected_nodes":[3226,2240],"Tags":[]},{"value":2240,"connected_nodes":[2226],"Tags":[]},{"value":4726,"connected_nodes":[3226,5626,4750],"Tags":[]},{"value":4750,"connected_nodes":[4726],"Tags":["gents washroom","ladies washroom"]}]}
         var cords = [];
         var connected_nodes = [];
         for (var temp = 0; temp < 3600 ; temp++) {
           connected_nodes[temp] = [];
         }
         var edge_index = -1;
         var Node_select = false;
         var Edge_select = false;
         var select = 0;
         var src_bool = false;
         var dest_bool = false;
         var src = -1,dest = -1;
         var init_node = -1;
         var fin_node = -1;

         function clk(i){
            if(Node_select){
              //redify(i);
              select = 0;
              if (find(i,cords) == -1){
                cords.push(i);
                redify(i);
              }
              else{
                alert("You have already selected the node (;-;)");
              }
            }
            else if (Edge_select) {
              if (find(i,cords) == -1) {
                alert("Please select one of the registered points");
              }
              else{
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
                }
              }
            }
            else if(dest_bool){
             dest = i;
             shortest_path();
             src_bool = false;
             dest_bool = false;
            }
            else if(src_bool){
             src = i;
             dest_bool = true;
            }
         }

         function shortest_path(){
            var pred = [];
            var dist = [];
            if(BFS(pred,dist)==false){
             alert("selecte n`odes are not connected");
             return;
            }

            var path = [];
            var crawl = dest;
            path.push(crawl);
            var ai = 1;

            console.log("dest:"+dest);
            console.log("src:"+src);

            while(pred[find(crawl,cords)] != -1){
             console.log("path:"+path);
             console.log("crawl:"+crawl+" "+find(crawl,cords));
             path.push(pred[find(crawl,cords)]);
             crawl = pred[find(crawl,cords)];
             ai++;
             if(ai == 1000)
               return;
            }

            for(var b=0;b<path.length;b++){
             blue(path[b]);
            }
            return;

         }


         function BFS(pred, dist){
           var queue = [];
           var visited = [];

           for(var b=0;b<cords.length;b++){
             visited[b] = false;
             dist[b] = 100000;
             pred[b] = -1;
           }

           visited[find(src,cords)] = true;
           dist[find(src,cords)] = 0;
           queue.push(src);
           var o = 0;

           while(queue.length != 0){
             var u = queue.shift();    //equivalent to pop
             var inde = find(u,cords);
             o++;
             for(var b=0;b<connected_nodes[inde].length; b++){
               if(length(u,connected_nodes[inde][b])+dist[find(u,cords)]<dist[find(connected_nodes[inde][b],cords)] ){
                 console.log("u:"+u+" "+length(u,connected_nodes[inde][b]));
                 visited[find(connected_nodes[inde][b],cords)] = true;
                 dist[find(connected_nodes[inde][b],cords)] = dist[find(u,cords)] +length(u,connected_nodes[inde][b]);
                 pred[find(connected_nodes[inde][b],cords)] = u;
                 queue.push(connected_nodes[inde][b]);
                 o++;
                 if(o>100)
                   return false;
               }
             }
             if(o>100)
               return false;

           }

           if(dist[find(dest,cords)]==100000)
               return false;
           return true;

         }

         function length(A,B){
           var x1 = Math.floor(A/100);
           var x2 = Math.floor(B/100);
           var y1 = A%100;
           var y2 = B%100;

           var z = Math.pow((x2-x1),2)+Math.pow((y2-y1),2);
           console.log("A,B:"+A+" "+B+"z: "+z);
           return Math.sqrt(z);
         }

         function map(){
           src_bool = true;
         }

         function find(key,array){   //returns the index at which key is store in array
           for (var i = 0; i < array.length; i++) {
             if (array[i] == key) {
               return i;
             }
           }
           return -1;
         }

         function greenify(i){
           document.getElementById(i).style.backgroundColor = "lawngreen";
         }
         function redify(i){
           document.getElementById(i).style.backgroundColor = "red";
         }
         function yellow(i){
           document.getElementById(i).style.backgroundColor = "yellow";
         }
         function blue(i) {
           document.getElementById(i).style.backgroundColor = "blue";
         }
         function stop(){
           Node_select = false;
           Edge_select = false;
           select = 0;
         }
         function path(x,y){
             var a,b,c,d,e,f,g;
             a = Math.floor(x/100); b = x%100;
             c = Math.floor(y/100); d = y%100;
             e = Math.floor((a+c)/2);
             f = Math.floor((b+d)/2);
             if (e==a & f==b) {
               g = 100*c +b ;
             //  greenify(g);
             }
             else if (e==c & f==d) {
               g = 100*a +d ;
             //  greenify(g);
             } else {
               g = 100*e + f;
               greenify(g);
               path(g,x);
               path(g,y);
             }
         }
         function finalpath(x,y){
           path(x,y);
           redify(x);
           redify(y);
         }
         function Nodeselect(){
           Node_select = true;
           Edge_select = false;
           select = 0;
         }
         function Edgeselect(){
           Node_select = false;
           Edge_select = true;
         }
         function debug(){
           var strin = "";
           for (var i = 0; i < connected_nodes[0].length; i++) {
             strin  = strin + " " + connected_nodes[0][i];
           }
           document.getElementById('test').innerHTML = strin;
         }
         function display(){
           var str = "";
           for(var j=0;j<cords.length;j++){
             str+=cords[j]+", ";
           }
           document.getElementById("test").innerHTML = str;

           str = "";
           for(j=0;j<connected_nodes.length;j++){
             for (var k=0; k < connected_nodes[j].length; k++) {
               str+= connected_nodes[j][k]+", "
             }
             if(connected_nodes[j].length!=0)
               str+=":"+j+"||";
           }
           document.getElementById("testing").innerHTML = str+" "+cords.length+" "+connected_nodes.length;
         }

      </script>
   </head>
   <body>
      <h1>Sample grid</h1>
      <p id = "mapping"></p>
      <div id="example2">
         <div class="grid-container">
            <script type="text/javascript">
               for(var i=0;i<60;i++){
                  for (var j=0;j<60 ;j++ ) {
                     var k =100*i + j;
                     document.write("<div class=\"grid-item\" id = \""+k+"\" onclick =\"clk("+
                        k+")\"></div>");   
               }}
            </script>
         </div>
      </div>
      <button type="button" onclick ="finalpath(cords[0],cords[1])" >JOIN</button>
      <button id = "Node" type="button" onclick ="Nodeselect()" >Node</button>
      <button id = "Edge" type="button" onclick ="Edgeselect()" >Edge</button>
      <button id = "Stop" type="button" onclick ="stop()" >Stop</button>
      <button id = "Display" type="button" onclick ="display()" >Display</button>
      <button id = "Debug" type="button" onclick ="debug()" >Debug</button>
      <button id = "Map" type="button" onclick="map()">Map</button>
      <!--<p id = "response">Clicked at => </p>-->
      <p id = "test"></p>
      <p id = "testing"></p>
      <p id = "dis"></p>
   </body>
</html>
