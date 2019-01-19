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
      // <?php
      // $dbhost = "localhost";
      // $dbuser = "root";
      // $dbpass = "root";
      // $database="mysql";
      // $conn = new mysqli($dbhost, $dbuser, $dbpass,$database);
      // $sql = "SELECT JSON_string FROM mysql.first_test WHERE name = 'AIIMS' limit 1";
      // $result = mysqli_query($conn, $sql);
      // $row = mysqli_fetch_assoc($result);
      // ?>

        var cords = [];
        var connected_nodes = [];

        for (var temp = 0; temp < 3600 ; temp++) {
            connected_nodes[temp] = [];
        }
         var tr = '<?php echo $row['JSON_string'] ;?>';
         //alert(tr);

        var src_tag,dest_tag;
        var src_bool = false,dest_bool = false;
        var src = -1,dest = -1;

        function clk(i){}

        function reset(){
          var kk = 0;
          for (var ii = 0; ii < 60; ii++) {
            for (var jj = 0; jj < 60; jj++) {
              kk = 100*ii + jj;
              document.getElementById(kk).style.backgroundColor = "";
            }
          }
        }

        function shortest_path(){

           var pred = [];

           var dist = [];

           if(BFS(pred,dist)==false){

            alert("selecte nodes are not connected");

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



           for(var b=0;b<(path.length)-1;b++){

            
            console.log(path[b]);   //only for debugging
            make_path(path[b],path[b+1]);
            blue(path[b]);

           }

           blue(path[b]);

           


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

        function make_path(x,y){

            var a,b,c,d,e,f,g;

            a = Math.floor(x/100); b = x%100;

            c = Math.floor(y/100); d = y%100;

            e = Math.floor((a+c)/2);

            f = Math.floor((b+d)/2);

            if (e==a & f==b) {

              g = 100*c +b ;
              greenify(g);


            }

            else if (e==c & f==d) {

              g = 100*a +d ;
              greenify(g);


            } else {

              g = 100*e + f;

              greenify(g);

              make_path(g,x);

              make_path(g,y);

            }

        }

        function blue(i) {
          document.getElementById(i).style.backgroundColor = "blue";
        }

        function red(i) {
          document.getElementById(i).style.backgroundColor = "red";
        }

        //SAMPLE=>{"cords":[{"value":5626,"connected_nodes":[4726],"Tags":["entry"]},{"value":3226,"connected_nodes":[4726,3229,2226],"Tags":[]},{"value":3229,"connected_nodes":[3226],"Tags":["stairs","help desk"]},{"value":2226,"connected_nodes":[3226,2240],"Tags":[]},{"value":2240,"connected_nodes":[2226],"Tags":[]},{"value":4726,"connected_nodes":[3226,5626,4750],"Tags":[]},{"value":4750,"connected_nodes":[4726],"Tags":["gents washroom","ladies washroom"]}]}

        function Submit(){
         reset();
	       src_tag = document.getElementById("source").value;
	       dest_tag = document.getElementById("destination").value;
	      // var tr = '{"cords":[{"value":5626,"connected_nodes":[4726],"Tags":["entry"]},{"value":3226,"connected_nodes":[4726,3229,2226],"Tags":[]},{"value":3229,"connected_nodes":[3226],"Tags":["stairs","help desk"]},{"value":2226,"connected_nodes":[3226,2240],"Tags":[]},{"value":2240,"connected_nodes":[2226],"Tags":[]},{"value":4726,"connected_nodes":[3226,5626,4750],"Tags":[]},{"value":4750,"connected_nodes":[4726],"Tags":["gents washroom","ladies washroom"]}]}'
         var obj = JSON.parse(tr);
         for(var b=0;b<obj.cords.length;b++){
          cords[b] = obj.cords[b].value;
          for(var c=0;c<obj.cords[b].connected_nodes.length;c++){
            connected_nodes[b][c] = obj.cords[b].connected_nodes[c];
          }
          for(var c=0;c<obj.cords[b].Tags.length;c++){
            if(obj.cords[b].Tags[c]==src_tag)
              src = obj.cords[b].value;
            if(obj.cords[b].Tags[c]==dest_tag)
              dest = obj.cords[b].value;
          }
         }
         console.log(src+" "+dest);
         shortest_path();
         red(src);
         blue(dest);
	      }

      </script>
   </head>
   <body>
      <h1>AIIMS Navigation</h1>
      <p id = "mapping"></p>
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
      Source:
      <select name="source" id = "source">
	     <script language="javascript" type="text/javascript">
          //var tr = '{"cords":[{"value":5626,"connected_nodes":[4726],"Tags":["entry"]},{"value":3226,"connected_nodes":[4726,3229,2226],"Tags":[]},{"value":3229,"connected_nodes":[3226],"Tags":["stairs","help desk"]},{"value":2226,"connected_nodes":[3226,2240],"Tags":[]},{"value":2240,"connected_nodes":[2226],"Tags":[]},{"value":4726,"connected_nodes":[3226,5626,4750],"Tags":[]},{"value":4750,"connected_nodes":[4726],"Tags":["gents washroom","ladies washroom"]}]}'
         var obj = JSON.parse(tr);
          for(var b=0;b<obj.cords.length;b++){
            for(var c=0;c<obj.cords[b].Tags.length;c++){
              document.write("<option>"+obj.cords[b].Tags[c]+"</option>");
            }
          }
        </script>
      </select>
      Destination:
      <select name="destination" id = "destination">
	      <script language="javascript" type="text/javascript">
          //var tr = '{"cords":[{"value":5626,"connected_nodes":[4726],"Tags":["entry"]},{"value":3226,"connected_nodes":[4726,3229,2226],"Tags":[]},{"value":3229,"connected_nodes":[3226],"Tags":["stairs","help desk"]},{"value":2226,"connected_nodes":[3226,2240],"Tags":[]},{"value":2240,"connected_nodes":[2226],"Tags":[]},{"value":4726,"connected_nodes":[3226,5626,4750],"Tags":[]},{"value":4750,"connected_nodes":[4726],"Tags":["gents washroom","ladies washroom"]}]}'
         var obj = JSON.parse(tr);
          for(var b=0;b<obj.cords.length;b++){
            for(var c=0;c<obj.cords[b].Tags.length;c++){
              document.write("<option>"+obj.cords[b].Tags[c]+"</option>");
            }
          }
        </script>
      </select><br>

	<button id = "submit" type = "button" onclick = "Submit()">Submit</button>
  <script>
    if(path.length!=0){
      var obj = JSON.parse(tr);
      document.write("<textarea rows="4" cols="50">");
      for(var b=0;b<obj.cords.length;b++){
          document.write(obj.cords[b].Tags+", ");
      }

    }
  </script>
   </body>
</html>
