include "connect.php";
sec_session_start();

if(login_check($conn)){

?>
  <!doctype html>
  <html class="no-js" lang="en">
    <head>
      <meta charset="utf-8" />

      <script src="js/vendor/jquery.js"></script>
      <script src="js/foundation.min.js"></script>
      <script src="js/vendor/modernizr.js"></script> 

      <link href='./calendar/fullcalendar.css' rel='stylesheet' />
      <link rel="stylesheet" href="css/foundation.css" />
     
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
            defaultView:'agendaWeek',
            header: {
              left: 'prev,next today',
              center: 'title',
              right: 'month,agendaWeek,agendaDay',
            },
            selectable: true,
            selectHelper: true,
            select:function (start,end,allDay){
                    $('#firstModal').foundation('reveal', 'open'); //Abre ventana emergente
                    startDate=new dateTime(start.getDate(),start.getMonth(),start.getFullYear(),start.getHours(),start.getMinutes());  // Comienzo de la cita.
                    endDate=new dateTime(end.getDate(),end.getMonth(),end.getFullYear(),end.getHours(),end.getMinutes());              // Fin de la cita.
                    document.getElementById("horaInicio").innerHTML=start.toLocaleTimeString();
                    document.getElementById("fechaInicio").innerHTML=start.toLocaleDateString();

                    document.getElementById("horaFin").innerHTML=end.toLocaleTimeString();
                    document.getElementById("fechaFin").innerHTML=end.toLocaleDateString();
                  },
            editable: true,    
            eventSources: [

              // your event source
              {
                url: 'appointmentFeed.php', // use the `url` property
                type: 'POST',
                data: {
                  dr: <?php if(isset($_GET['dr'])){ echo "'".$_GET['dr']."'";} else echo "'D01'"; ?>,
                  status: 'A'
                },
                error: function() {
                  alert('there was an error while fetching events!');
                },
                color: 'teal',    // an option!
                textColor: 'white',  // an option!
                allDayDefault: false,
                editable:false
              }

        ]
      });
          
        });

      //más funciones!

        function closeModal(){ 
          $('#firstModal').foundation('reveal', 'close'); //Cierra ventana emergente
        }

        function appLength(){
          <?php 
            include 'connect.php';
            function lenght($drid){
              $drid=$drid;
              $query=oci_parse($conn, "SELECT lenght FROM doctor_data WHERE drid='".$drid."'");
              if (!$query) {
                $e = oci_error($conn);
                trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
              }

              $r = oci_execute($query);

              $r = oci_execute($query);
              if (!$r) {
                  $e = oci_error($query);
                  trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
              }
              $lenght=oci_fetch_array($connect,OCI_ASSOC+OCI_RETURN_NULLS);
              echo $lenght;
            }
              oci_close($conn);
          ?> 
          var drid = document.getElementById('dr').value;
          return lenght(drid);
       }

       function getMedicos(){
       <?php
            //iniciar la conexión
            include "connect.php";

            // Prepare the statement
            //El querie tal como lo usarias en el DBM, parse lo prepara, recive la coneccion y el string
            $stid = oci_parse($conn, 'SELECT * FROM doctor_data ORDER BY drid');
            if (!$stid) {
              $e = oci_error($conn);
              trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
            }

            // Perform the logic of the query
            // Ejecuta el querie
            $r = oci_execute($stid);
            if (!$r) {
              $e = oci_error($stid);
              trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
            }
  
            // Fetch the results of the query
            //Toma los datos, revisa y mientras alla una fila crea una opcion para el select
            while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {          
                 echo "document.write('<option value=".$row['DRID'].">".$row['DFNAME']." ".$row['DLNAME']." - ".$row['SPECIALTY']."  </option>');";              
            }
            //cerrar conexion
            oci_free_statement($stid);
            oci_close($conn);

          ?>
       }

      </script>

    </head>
    <body style="background-color:white">

      <div class="row">
      <form action="crear-cita.php" method="get">
        <h3>Doctor:
          <label><strong>Médico:</strong></label>
          <select name='dr' id='dr'>
            <script>getMedicos()</script>
          </select>
          <input type="submit"  value="Buscar" class="button" >
          </h3>
          
        </form>
      </div>

      <!-- Calendario -->
      <div class="large-12 column">                          
        <div id='calendar' style="width:60%" ></div>
      </div>

      <!-- Ventana Emergente (Formulario)-->
      
      <div id="firstModal" class="reveal-modal close" data-reveal="" style="visibility: invisible; display: block; opacity: 1; " align="left">
        <div class="row vscrollbar" style="height:40%" id="datosUsuario">
        <form action="queriesInsert.php" method="post" >
          
        <fieldset>
        <legend><h4>Nueva Cita</h4></legend>     
       
                <div class="large-8 column" >
                    <label><strong>¿Primera Visita?</strong> </label>
                    <input type="radio" name="visita" value="si" checked><label>Si</label>
                    <input type="radio" name="visita" value="no"><label>No</label>
                </div>

                <div class="large-4 column" >
                    <label><strong>Medico</strong> </label>
                    <text id="dr" name="dr"><script>document.write(document.getElementById("dr").value)</script></text>
                </div>
                           
                <div class="large-6 column">
                  <label>Nombre(s)</label>
                  <input type="text" name="fname"> </input>
                </div>
                <div class="large-6 column">
                  <label>Apellido(s)</label>
                  <input type="text" name="lname"> </input>
                </div>
                
                 <div class="large-6 column">
                  <label>Teléfono</label>
                  <input type="text" name="tel"> </input>
                </div>
                <div class="large-6 column">
                  <label>Correo Eléctronico</label>
                  <input type="text" name="email"> </input>
                </div>

                <div class="large-12 column">
                    <label><strong>Detalles:</strong> </label>
                    <textarea rows="4" cols="50" name="details" placeholder="Información útil que pueda servir para un dianóstico previo para el médico."></textarea>
                </div>
                <div class="row">
                  <legend><h4>Información de Cita:</h4></legend></p>
                <div class="large-6 column">
                  <legend><strong>Inicio </strong></legend>
                  Hora: <text id="horaInicio" name="horaInicio"> </text></br>
                  Fecha: <text id="fechaInicio" name="fechaInicio"> </text>
                </div>
                <div class="large-6 column">
                  <legend><strong>Fin </strong></legend>
                  Hora: <text id="horaFin" name="horaFin"> </text></br>
                  Fecha: <text id="fechaFin" name="fechaFin"> </text>
                </div>                  
                </div>
       
        </fieldset>

          <input type="submit" name="crearCita" value="Agregar" class="button" >
          <input type="button" value="Cancelar" class="button" Style="background-color:GRAY" onclick="closeModal()">
          </form>
           </div>
      </div>
      
         


         <!-- <h4>Nueva Cita</h4>
          <p ><b id="demo"></b><p>
          <p>Inicio: <b id="horaInicio"></b></p>
          <p>Final: <b id="end"></b></p>
          <p>Duración: <b id="allday"></b></p>

         
          <form>
  			Cita: <input type="text" id="cita">
  			<input type="button" value="Crear Cita" class="button" onclick="createAppoiment()">
        <input type="button" value="Cancelar" class="button" Style="background-color:GRAY" onclick="closeModal()">

  		</form>
      </div>-->

      
      
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