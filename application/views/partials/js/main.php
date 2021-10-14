<script>
  var $calendar;
  $(document).ready(function () {
      <? if(isset($CalendarEventsList)): ?>
      if($("#eventsCalendar").length){
          console.log(new Date(new Date().setHours(new Date().getHours() + 24)).toDateString());
        let container = $("#eventsCalendar").simpleCalendar({
            fixedStartDay: 0,
            disableEmptyDetails: true,
            events: <?=$CalendarEventsList?>,
            onInit: function (calendar) {}, 
            onMonthChange: function (month, year) {}, 
            onDateSelect: function (date, events) {
                console.log(date);
                console.log(events);
                $(".event-hour").html("")
                $(".event-date").addClass("float-right")
            }, 
            onEventSelect: function() {
                if(typeof $(this).data('event').entity != "undefined")
                {
                    window.location.assign('/city/events/view/'+$(this).data('event').entity)
                }
            },
            onEventCreate: function( $el ) {
                console.log('onEventCreate---',$el);
                $(".event-hour").html("")
            },
            onDayCreate:   function( $el, d, m, y ) {
                console.log('onDayCreate---',$el);
            }
        });
        $calendar = container.data('plugin_simpleCalendar')
      }    
      <? endif; ?>
  });
</script>