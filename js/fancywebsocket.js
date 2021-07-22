var FancyWebSocket = function(url)
{
	var callbacks = {};
	var ws_url = url;
	var conn;
	
	this.bind = function(event_name, callback)
	{
		callbacks[event_name] = callbacks[event_name] || [];
		callbacks[event_name].push(callback);
		return this;
	};
	
	this.send = function(event_name, event_data)
	{
		this.conn.send( event_data );
		return this;
	};
	
	this.connect = function() 
	{
		if ( typeof(MozWebSocket) == 'function' )
		this.conn = new MozWebSocket(url);
		else
		this.conn = new WebSocket(url);
		
		this.conn.onmessage = function(evt)
		{
			dispatch('message', evt.data);
		};
		
		this.conn.onclose = function(){dispatch('close',null)}
		this.conn.onopen = function(){dispatch('open',null)}
	};
	
	this.disconnect = function()
	{
		this.conn.close();
	};
	
	var dispatch = function(event_name, message)
	{
		if(message == null || message == "")//aqui es donde se realiza toda la accion
			{
			}
			else
			{
                            //alert("mensaje: " + message);
				var JSONdata    = JSON.parse(message); //parseo la informacion
                                //alert("update: " + JSONdata.update);
				switch(JSONdata.update)//que tipo de actualizacion vamos a hacer(un nuevo mensaje, solicitud de amistad nueva, etc )
				{
					case 'sendMontura':
                                            loadAlerts();
					break;
					case 'sendProducto':
                                            loadAlerts();
					break;
					case 'sendGasto':
                                            loadAlerts();
					break;
                                        case 'sendMedicion':
                                            loadall();
					break;
                                        case 'sendMensajeToTienda':
                                            loadMensajesByTienda();
					break;
					
				}
				//aqui se ejecuta toda la accion
				
				
				
				
				
				
			}
	}
};

var Server;
function send( text ) 
{
    Server.send( 'message', text );
}
$(document).ready(function() 
{
    Server = new FancyWebSocket('ws://50.87.202.215:80');
    //Server = new FancyWebSocket('ws://192.168.0.22:7001');
    Server.bind('open', function()
	{
    });
    Server.bind('close', function( data ) 
	{
    });
    Server.bind('message', function( payload ) 
	{
    });
    Server.connect();
});



function actualiza_mensaje(message)
{
	var JSONdata    = JSON.parse(message); //parseo la informacion
				var tipo = JSONdata[0].tipo;
				var mensaje = JSONdata[0].mensaje;
				var fecha = JSONdata[0].fecha;
				
				var contenidoDiv  = $("#"+tipo).html();
				var mensajehtml   = fecha+' : '+mensaje;
				
				$("#"+tipo).html(contenidoDiv+'0000111'+mensajehtml);
}
function actualiza_solicitud()
{
	alert("tipo de envio 2");
}
