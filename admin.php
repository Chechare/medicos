<?php
include "driver.php";
include 'connect.php';
sec_session_start();
if(login_check($conn) == true) {
   ?>
    <!doctype html>
    <html class="no-js" lang="en">

    <head>

        <script> 
            function changeIframeSrc(direccion) { 
                var url=direccion;
                document.getElementById('frameCambiante').src=url;
        }
        </script>

        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Appointment System | Administración</title>
        <link rel="icon" type="image/png" href="./img/icon.png" />

        <link rel="stylesheet" href="css/foundation.css" />
        <link rel="stylesheet" href="./img/icons/foundation-icons.css" />

        <script src="js/vendor/modernizr.js"></script>    
    </head>

        <body>
        <div class="sticky">
            <nav class="top-bar" data-topbar data-options="sticky_on: large">
                <section class="top-bar-section">
                    <ul class="title-area" >
                        <li class="name"><!-- Leave this empty --></li>
                        <li>
                            <a>
                                <img heigth="29px" width="73" src="./img/logoadview.png">

                            <b><font size="2.5" color="d4ee1c"> Appointment System </font></b> </a>
                            
                        </li>
                    </ul>
                </section>
                <section>
                    <ul class="right">
                        <li class="name">
                            <button onclick="window.location.href='logout.php'" type="button"> Cerrar Sesión </<button></button>>
                        </li>
                    </ul>
                </section>
            </nav>
        </div>


        <div class="large-2 column vscrollbar" style="height:100%">
            
         <ul class="off-canvas-list" style="height:100%" >
                    <li><label>Administración de Citas</label></li>
                    <li><a href="#" onclick="changeIframeSrc('calendario_Confirmados.php')">Citas Confirmadas</a></li>
                    <li><a href="#" onclick="changeIframeSrc('calendario-solicitudes.php')">Citas Pendientes</a></li>
                    <li><a href="#" onclick="changeIframeSrc('crear-cita.php')">Crear Cita</a></li>        
                    <li><label>Administración del Sitio</label></li>        
                    <li><a href="#" onclick="changeIframeSrc('./paciente.php')">Pacientes</a></li>
                    <li><a href="#" onclick="changeIframeSrc('medico.php')">Médicos</a></li>
                    <li><a href="#" onclick="changeIframeSrc('horario.php')">Horarios</a></li>
        </ul>

        </div>    
        <div class="large-10 column" style="height:100%">
                <iframe id="frameCambiante" src="./calendario_Confirmados.php" name="iframe_a" style="height:100%;width:100%"></iframe>
        <div/>

        


        <script src="js/vendor/jquery.js"></script>
        <script src="js/foundation.min.js"></script>
        <script>
        $(document).foundation();
        </script>
    </body>
    </html>
    <?php
} else {
    $url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    $_SESSION['url'] =$url;
    header('Location: ./login.php?err=2');
    }
?>


