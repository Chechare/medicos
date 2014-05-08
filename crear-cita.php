<?php
include "driver.php";
include "connect.php";
sec_session_start();

$alert = isset($_GET["alert"]) ? $_GET["alert"] : 0;
$alert2 = isset($_GET["alert2"]) ? $_GET["alert2"] : 0;

if($alert){
  echo "<script>alert('¡Cita y paciente registrados!');</script>";
}
if($alert2){
  echo "<script>alert('¡Error! El Paciente puede no estar registrado');</script>";
}

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

        function formatDate(num){
          if(num<10){
            return "0"+num;
          }
          return num+"";
        }

        $(document).ready(function() {

          $('#registrado').addClass("ocultar");

          var calendar = $('#calendar').fullCalendar({
            defaultView:'agendaWeek',
            eventDurationEditable: false,
            eventStartEditable: false,
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
                    endDate=new dateTime(end.getDate(),end.getMonth(),end.getFullYear(),start.getHours()+getHour(),start.getMinutes()+getMinute());              // Fin de la cita.

                    document.getElementById("horaInicio").innerHTML=formatDate(startDate.hours)+":"+formatDate(startDate.minutes);
                    document.getElementById("fechaInicio").innerHTML=start.toLocaleDateString();
                    document.getElementById("horaInicio2").innerHTML=formatDate(startDate.hours)+":"+formatDate(startDate.minutes);
                    document.getElementById("fechaInicio2").innerHTML=start.toLocaleDateString();

                    document.getElementById("horaFin").innerHTML=formatDate(endDate.hours)+":"+formatDate(endDate.minutes);
                    document.getElementById("fechaFin").innerHTML=end.toLocaleDateString();
                    document.getElementById("horaFin2").innerHTML=formatDate(endDate.hours)+":"+formatDate(endDate.minutes);
                    document.getElementById("fechaFin2").innerHTML=end.toLocaleDateString();

                    document.getElementById("app_date").value=startDate.day+"-"+(startDate.month+1)+"-"+startDate.year+" "+startDate.hours+":"+startDate.minutes;
                    document.getElementById("app_date2").value=startDate.day+"-"+(startDate.month+1)+"-"+startDate.year+" "+startDate.hours+":"+startDate.minutes;
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

        function getHour(){
          <?php 
            include 'connect.php';

            if(isset($_GET['dr'])){
              $drid= $_GET['dr'];
            }
            else{
              $drid="D01";                        
            }

              $query=oci_parse($conn, "SELECT to_Char(app_lenght,'HH24') AS lenght FROM doctor WHERE drid='".$drid."'");
              if (!$query) {
                $e = oci_error($conn);
                trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
              }

              $r = oci_execute($query);

              if (!$r) {
                  $e = oci_error($query);
                  trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
              }
              $row=oci_fetch_array($query,OCI_ASSOC+OCI_RETURN_NULLS);
                
              $lenght=$row['LENGHT'];

              echo "return parseInt('".$lenght."');";            
              oci_close($conn);
          ?> 
       }


      function getMinute(){
          <?php 
            include 'connect.php';

            if(isset($_GET['dr'])){
              $drid= $_GET['dr'];
            }
            else{
              $drid="D01";                        
            }

              $query=oci_parse($conn, "SELECT to_Char(app_lenght,'MI') AS lenght FROM doctor WHERE drid='".$drid."'");
              if (!$query) {
                $e = oci_error($conn);
                trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
              }

              $r = oci_execute($query);

              if (!$r) {
                  $e = oci_error($query);
                  trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
              }
              $row=oci_fetch_array($query,OCI_ASSOC+OCI_RETURN_NULLS);
                
              $lenght=$row['LENGHT'];

              echo "return parseInt('".$lenght."');";            
              oci_close($conn);
          ?> 
       }

       function changeDiv(){

          if($('#registrado').hasClass("ocultar")){
            $('#registro').addClass("ocultar");
            $('#registrado').removeClass("ocultar");
            $('#registrado').addClass("visible");                 
          }
          else{
            if($('#registrado').hasClass("visible")){
              $('#registrado').addClass("ocultar");
              $('#registro').removeClass("ocultar");
              $('#registro').addClass("visible"); 
            }    
         }

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
              if(isset($_GET['dr'])) { 
                if($_GET['dr']==$row['DRID']){
                  echo "document.write(\"<option value='".$row['DRID']."' selected>".$row['DFNAME']." ".$row['DLNAME']." - ".$row['SPECIALTY']."  </option>\");";              
                }else{
                  echo "document.write(\"<option value='".$row['DRID']."'>".$row['DFNAME']." ".$row['DLNAME']." - ".$row['SPECIALTY']."  </option>\");";              
                }
              }else{
                echo "document.write(\"<option value='".$row['DRID']."'>".$row['DFNAME']." ".$row['DLNAME']." - ".$row['SPECIALTY']."  </option>\");";                  
              }
            }
              //cerrar conexion
            oci_free_statement($stid);
            oci_close($conn);

          ?>
       }

       function getMedico(){
          <?php
            include "connect.php";

            if(isset($_GET['dr'])){
              $drID= $_GET['dr'];
            }
            else{
              $drID="D01";                        
            }

           $stid = oci_parse($conn, "SELECT DFNAME||' '||DLNAME AS name FROM doctor_data WHERE drid='".$drID."'");
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

            $row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);

            echo "document.write('".$row['NAME']."');";
            oci_close($conn);

          ?>
       }

       
      </script>

    </head>
    <body style="background-color:white">
     <div class="row">
      <form action="crear-cita.php" method="get">
        <h3><div class="large-2 column left" style="padding:0.36rem 0.39rem 0.5rem 4.2rem">Médico:</div>
      <div class="large-8 column left">
          <select name='dr' onChange='this.form.submit()'>
            <script>getMedicos()</script>
          </select>
      </div>
      <div class="large-1 column left" >
      <noscript>
      <input type="submit"  value="Buscar" class="button" style="height:2.3rem;font-size: 1.2rem; padding:0.36rem 0.39rem 0.5rem 0.39rem;">
      </noscript>
      </div>
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

          <fieldset>
            <div class="large-8 column" >
              <label><strong>¿Primera Visita?</strong> </label>
              <input type="radio" name="visita" value="si" onClick="changeDiv()" checked><label>Si</label>
              <input type="radio" name="visita" value="no" onClick="changeDiv()"><label>No</label>
            </div>

            <legend><h4>Nueva Cita</h4></legend>     

            <div id='registro'>
              <form action="queriesInsert.php" method="post" >

                <div class="large-4 column" >
                  <label><strong>Medico</strong> </label>
                  <text id="doctor" >
                    <script>getMedico()</script>
                  </text>
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
                  <input type="text" name="phone"> </input>
                </div>
                <div class="large-6 column">
                  <label>Correo Eléctronico</label>
                  <input type="text" name="email"> </input>
                </div>

                <div class="large-12 column">
                  <label><strong>Detalles:</strong> </label>
                  <textarea rows="4" cols="50" name="description" placeholder="Información útil que pueda servir para un dianóstico previo para el médico."></textarea>
                </div>
                <div class="row">
                  <legend><h4>Información de Cita:</h4></legend></p>
                  <div class="large-6 column">
                    <legend><strong>Inicio </strong></legend>
                    Hora: <text id="horaInicio"> </text></br>
                    Fecha: <text id="fechaInicio"> </text>
                  </div>
                  <div class="large-6 column">
                    <legend><strong>Fin </strong></legend>
                    Hora: <text id="horaFin" > </text></br>
                    Fecha: <text id="fechaFin" > </text>
                  </div>   
                  <input type="hidden" name='drID' value=<?php if(isset($_GET['dr'])){ echo "'".$_GET['dr']."'";} else{ echo "'D01'";} ?> />
                  <input type="hidden" name='app_date' id="app_date"></input>
                  <input type="hidden" name='approved' value="A"></input>
                  <input type="submit" name="agregarCitaRegistro" value="Agregar" class="button" >
                  <input type="button" value="Cancelar" class="button" Style="background-color:GRAY" onclick="closeModal()">
                </form>
              </div> 
            </div>

              <div id="registrado">
              <form action="queriesInsert.php" method="post" >
                 <div class="large-4 column" >
                  <label><strong>Medico</strong> </label>
                  <text id="dr" name="dr">
                     <script>getMedico()</script>
                 </text>
                </div>

                <div class="large-6 column">
                  <label>Teléfono</label>
                  <input type="text" name="phone"> </input>
                </div>
                <div class="large-6 column">
                  <label>Correo Eléctronico</label>
                  <input type="text" name="email"> </input>
                </div>

                <div class="large-12 column">
                  <label><strong>Detalles:</strong> </label>
                  <textarea rows="4" cols="50" name="description" placeholder="Información útil que pueda servir para un dianóstico previo para el médico."></textarea>
                </div>
                <div class="row">
                  <legend><h4>Información de Cita:</h4></legend></p>
                  <div class="large-6 column">
                    <legend><strong>Inicio </strong></legend>
                    Hora: <text id="horaInicio2" name="horaInicio"> </text></br>
                    Fecha: <text id="fechaInicio2" name="fechaInicio"> </text>
                  </div>
                  <div class="large-6 column">
                    <legend><strong>Fin </strong></legend>
                    Hora: <text id="horaFin2" name="horaFin"> </text></br>
                    Fecha: <text id="fechaFin2" name="fechaFin"> </text>
                  </div>   
                  <input type="hidden" name='drID' value=<?php if(isset($_GET['dr'])){ echo "'".$_GET['dr']."'";} else{ echo "'D01'";} ?> />
                  <input type="hidden" name='app_date' id="app_date2"></input>
                  <input type="hidden" name='approved' value="A"></input>
                  <input type="submit" name="crearCitaRegistrado" value="Agregar" class="button" >
                  <input type="button" value="Cancelar" class="button" Style="background-color:GRAY" onclick="closeModal()">
                </form>
              </div> 


            </fieldset>


          </div>
        </div>
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