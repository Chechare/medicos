<?php
include "driver.php";
include "connect.php";
sec_session_start();
if(login_check($conn)==true){
?>
	<!DOCTYPE html>
	<html>
	<head>
	<link href='./calendar/fullcalendar.css' rel='stylesheet' />
	<link href='./calendar/fullcalendar.print.css' rel='stylesheet' media='print' />

	    <script src="js/vendor/jquery.js"></script>
	    <script src="js/foundation.min.js"></script>

	<script src='./calendar/lib/jquery.min.js'></script>
	<script src='./calendar/lib/jquery-ui.custom.min.js'></script>
	<script src='./calendar/fullcalendar.min.js'></script>
	<script>

		$(document).ready(function() {
		
		
			/* initialize the external events
			-----------------------------------------------------------------*/
		
			$('#external-events div.external-event').each(function() {
			
				// create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
				// it doesn't need to have a start or end
				var eventObject = {
					title: $.trim($(this).text()) // use the element's text as the event title
				};
				
				// store the Event Object in the DOM element so we can get to it later
				$(this).data('eventObject', eventObject);
				
				// make the event draggable using jQuery UI
				$(this).draggable({
					zIndex: 999,
					revert: true,      // will cause the event to go back to its
					revertDuration: 0  //  original position after the drag
				});
				
			});
		
		
			/* initialize the calendar
			-----------------------------------------------------------------*/
			
			$('#calendar').fullCalendar({
				header: {
					left: 'prev,next today',
					center: 'title',
					right: 'month,agendaWeek,agendaDay'
				},
				editable: true,
				droppable: true, // this allows things to be dropped onto the calendar !!!
				drop: function(date, allDay) { // this function is called when something is dropped
				
					// retrieve the dropped element's stored Event Object
					var originalEventObject = $(this).data('eventObject');
					
					// we need to copy it, so that multiple events don't have a reference to the same object
					var copiedEventObject = $.extend({}, originalEventObject);
					
					// assign it the date that was reported
					copiedEventObject.start = date;
					copiedEventObject.allDay = allDay;
					
					// render the event on the calendar
					// the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
					$('#calendar').fullCalendar('renderEvent', copiedEventObject, true);
					
						// if so, remove the element from the "Draggable Events" list
					$(this).remove();
					
				}
			});

			/*--------------------------------------------------------------------------------------------------------------------------*/
			
		});

	</script>
	<style>

		#wrap {
			width: 1100px;
			margin: 0 auto;
			}
			
		#external-events, #external-canceledEvents {
			width: 150px;
			padding: 0 10px;
			border: 1px solid #ccc;
			background: #eee;
			text-align: left;
			}
			
		#external-events h4 {
			font-size: 16px;
			margin-top: 0;
			padding-top: 1em;
			height: 50%;
			}
			
		.external-event { /* try to mimick the look of a real event */
			margin: 10px 0;
			padding: 2px 4px;
			background: #3366CC;
			color: #fff;
			font-size: .85em;
			cursor: pointer;
			}
			
		.external-canceledEvent { /*evento cancelado*/
			margin: 10px 0;
			padding: 2px 4px;
			background: red;
			color: #fff;
			font-size: .85em;
			cursor: pointer;
			}

		#external-events p {
			margin: 1.5em 0;
			font-size: 11px;
			color: #666;
			}
			
		#external-events p input {
			margin: 0;
			vertical-align: middle;
			}

		.fc-view { /* prevents dragging outside of widget */
	                overflow: visible;
	        }

	     
	</style>
	</head>
	<body>
		<div id='wrap'>
			
			<div class="large-7 column">
				<div id='calendar' style="width:90%"></div>
			</div>
			
			<div class="large-5 column" align="center" style="height:500px">
				<div id='external-events' style="width:70%;height:50%;margin-bottom:1%">	
					<div style="height:10%">
						<h2>Socitudes</h2>
					</div>
					<div style="height:80%" class="vscrollbar">
						<div class='external-event'>cita 1</div>	
						<div class='external-event'>cita 2</div>			
						<div class='external-event'>cita 3</div>			
						<div class='external-event'>cita 4</div>			
						<div class='external-event'>cita 5</div>			
						<div class='external-event'>cita 6</div>
						<div class='external-event'>cita 7</div>			
						<div class='external-event'>cita 8</div>
					</div>
				</div>
			</div>
			

		</div>
	</body>
	</html>
<?php
	}
	else{
		$url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	    $_SESSION['url'] =$url;
	    header('Location: ./login.php?err=2');
	}
?>