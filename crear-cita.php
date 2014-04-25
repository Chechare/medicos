<?php
include "driver.php";
include "connect.php";
sec_session_start();

if(login_check($conn)==true){

?>
  <!doctype html>
  <html class="no-js" lang="en">
    <head>
      <meta charset="utf-8" />

      <script src="js/vendor/jquery.js"></script>
      <script src="js/foundation.min.js"></script>
      <script src="js/vendor/modernizr.js"></script>    

      <link rel="stylesheet" href="css/foundation.css" />

      <link href='./calendar/fullcalendar.css' rel='stylesheet' />
      <link href='./calendar/fullcalendar.print.css' rel='stylesheet' media='print' />

      <script src='./calendar/lib/jquery-ui.custom.min.js'></script>
      <script src='./calendar/fullcalendar.min.js'></script>
  	<script type="text/javascript" src="./js/jquery.qtip-1.0.0-rc3.min.js"></script> 
      
      <script>
        var startDate, endDate;

        function dateTime(day,month,year,hours,minutes){     //Función que crea un objeto DateTime (Fecha-Tiempo) para definir horario de la cita.
            this.day=day;
            this.month=month;
            this.year=year;
            this.hours=hours;
            this.minutes=minutes;
        }

        $(document).ready(function() {
          var calendar = $('#calendar').fullCalendar({
            header: {
              left: 'prev,next today',
              center: 'title',
              right: 'month,agendaWeek,agendaDay'
            },
            selectable: true,
            selectHelper: true,
            select:function (start,end,allDay){
                    $('#firstModal').foundation('reveal', 'open'); //Abre ventana emergente
                    startDate=new dateTime(start.getDate(),start.getMonth(),start.getFullYear(),start.getHours(),start.getMinutes());  // Comienzo de la cita.
                    endDate=new dateTime(end.getDate(),end.getMonth(),end.getFullYear(),end.getHours(),end.getMinutes());              // Fin de la cita.
                    document.getElementById("horaInicio").innerHTML=start.toLocaleTimeString();

                    document.getElementById("end").innerHTML=end;
                  },
            editable: true,
          });
          
        });

        function createAppoiment(){
          closeModal(); 
          var title=document.getElementById("cita").value;
          document.getElementById("demo").innerHTML=title;
          $('#calendar').fullCalendar('renderEvent', 
                {                
                  title:title,
                  start:new Date(startDate.year,startDate.month,startDate.day,startDate.hours,startDate.minutes),
                  end:new Date(endDate.year,endDate.month,endDate.day,endDate.hours,endDate.minutes),
                  allDay:false,
                },
              true // make the event "stick"
              );	
           $('#calendar').fullCalendar('unselect');
     		}  

        function closeModal(){ 
          $('#firstModal').foundation('reveal', 'close'); //Cierra ventana emergente
        }
      </script>

    </head>
    <body>


      <!-- Calendario -->
      <div class="large-12 column">                          
        <div id='calendar' style="width:60%" ></div>
      </div>

      <!-- Ventana Emergente (Formulario)-->
      
      <div id="firstModal" class="reveal-modal close" data-reveal="" style="visibility: invisible; display: block; opacity: 1" align="left">
          <h4>Nueva Cita</h4>
          <p ><b id="demo"></b><p>
          <p>Inicio: <b id="horaInicio"></b></p>
          <p>Final: <b id="end"></b></p>
          <p>Duración: <b id="allday"></b></p>

         
          <form>
  			Cita: <input type="text" id="cita">
  			<input type="button" value="Crear Cita" class="button" onclick="createAppoiment()">
        <input type="button" value="Cancelar" class="button" Style="background-color:GRAY" onclick="closeModal()">

  		</form>
      </div>

      
      
      <script>
        $(document).foundation();
      </script>
    </body>
  </html>

<?php
  }else{
    $url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    $_SESSION['url'] =$url;
    header('Location: ./login.php?err=2');
  }

?>