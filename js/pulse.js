"use strict";
var Client = Client || {};
Client.Pulse = null; //Holds a pointer to the heartbeat timer (id)

$(document).ready(function(){

  Client.Heartbeat();
});//ready

/// Sends the heartbeat signal and retrieves the currently active user list
Client.Heartbeat = function(){
  let sUsername = $(".logged-user").text();

  $.ajax({ //Send the signal and recieve the information about active users
    url : '../php/pulse.php',
    type : 'post',
    dataType : 'json',
    data : {username : sUsername },
    success : function(response){ 
      if ( ! $.fn.DataTable.isDataTable( '#all-users-table' ) ) {
        $('#all-users-table').dataTable({
            "data": response,
            "retrieve": true,
            "bFilter": false,
            "bPaginate": false,
        "columns": [
            { "data": "username" },
            { "data": "login_time" },
            { "data": "update_time" },
            { "data": "ip" }
        ]});
      } 
      else{
          $('#all-users-table').dataTable().fnClearTable();
          $('#all-users-table').dataTable().fnAddData(response);
      }
            
      Client.Pulse = setTimeout(function(){
        Client.Heartbeat();
      },3000); //3 second delay before next trigger
    },//success
    error: function()
    {
      $("#message").html("<div class='alert alert-danger'>Error occurred</div>");
    }
  });//$.ajax
}//Heartbeat
