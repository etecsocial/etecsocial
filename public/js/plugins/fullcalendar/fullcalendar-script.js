$(document).ready(function () {
    
    function f(data){
    var dia = data.getDate();
    if (dia.toString().length == 1)
      dia = "0"+dia;
    var mes = data.getMonth()+1;
    if (mes.toString().length == 1)
      mes = "0"+mes;
    var ano = data.getFullYear();  
    return ano + '-' + mes + '-' + dia;
}

    /* initialize the external events
     -----------------------------------------------------------------*/
    $('#external-events .fc-event').each(function () {

        // store data so the calendar knows to render an event upon drop
        $(this).data('event', {
            title: $.trim($(this).text()), // use the element's text as the event title
            stick: true, // maintain when user navigates (see docs on the renderEvent method)
            color: '#00bcd4'
        });

        // make the event draggable using jQuery UI
        $(this).draggable({
            zIndex: 999,
            revert: true, // will cause the event to go back to its
            revertDuration: 0  //  original position after the drag
        });

    });

    /* initialize the calendar
     -----------------------------------------------------------------*/

    /* initialize calendar widget
     -----------------------------------------------------------------*/
    $('#calendar').fullCalendar({
         dateFormat: 'dd/mm/yy',
    dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado','Domingo'
        ],
    dayNamesMin: [
    'D','S','T','Q','Q','S','S','D'
    ],
    dayNamesShort: [
    'Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'
    ],
    monthNames: [  'Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro',
    'Outubro','Novembro','Dezembro'
    ],
    monthNamesShort: [
    'Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set',
    'Out','Nov','Dez'
    ],
    nextText: 'Próximo',
    prevText: 'Anterior',
        events: 'ajax/agenda',
        eventDataTransform: function (rawEventData) {
            if (rawEventData.is_publico) {
                var color = '#742404';
            } else {
                var color = '#380474';
            }
            
            return {
                id: rawEventData.id,
                title: rawEventData.title,
                start: rawEventData.start,
                end: rawEventData.end,
                description: rawEventData.description,
                nome: rawEventData.nome,
                iduser:  rawEventData.id_user,
                color : color,
            };
        },
        lang: 'pt-br',
        header: {
            left: 'prev',
            center: 'title',
            right: 'next'
        },
        editable: true,
        droppable: true, // this allows things to be dropped onto the calendar
        eventLimit: true, // allow "more" link when too many events
        eventDrop: function (event, delta, revertFunc) {
            if (event.end === null) {
                event.end = event.start;
            }

            $.ajax({
                url: '/ajax/agenda/' + event.id + '/edit',
                type: 'GET',
                data: {
                    start: event.start.format(), 
                    end: event.end.format()
                },
                error: function () {
                      Materialize.toast('<span>Você não pode editar esse evento</span>', 3000);
                    revertFunc();
                }
            });
        },
        eventClick: function(event){
         $('#agenda-title').html(event.title);
         
         if ($('#iduser').val() == event.iduser) { 
            $("#opcoes").show();
            $("#user").hide();
            $("#data-opcoes").html(event.start.format('LL') + ' - adicionado por você');
            $("#excluir").attr({ "action": "/ajax/agenda/" + event.id });
         } else {       
            $("#user").show();
            $("#opcoes").hide();
            $('#user').html(event.start.format('LL') + ' - agendado por ' + event.nome);
         }
         $('#agenda-content').html(event.description);
        
         $('#evento').openModal();
     
        },
        
        dayClick: function(date, allDay, jsEvent, view) {
    $('#novoevento').openModal();
 
    
  $('input[type=date][name=start]').val(moment(date).format('YYYY-MM-DD'));

},
        
       
    });
    
    
     $('#calendar-widget').fullCalendar({
         
      header: {
        left: 'prev',
        center: 'title',
        right: 'next'
      },
      
      
       dateFormat: 'dd/mm/yy',
    dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado','Domingo'
        ],
    dayNamesMin: [
    'D','S','T','Q','Q','S','S','D'
    ],
    dayNamesShort: [
    'Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'
    ],
    monthNames: [  'Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro',
    'Outubro','Novembro','Dezembro'
    ],
    monthNamesShort: [
    'Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set',
    'Out','Nov','Dez'
    ],
    nextText: 'Próximo',
    prevText: 'Anterior',
        events: '/ajax/agenda',
     
      droppable: true, // this allows things to be dropped onto the calendar
      eventLimit: true, // allow "more" link when too many events
      
      
    });
    
});