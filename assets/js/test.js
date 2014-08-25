var net = require('net');
var rest = require('restler');
var express = require('express');
var storage = require('node-persist');
var mysql = require('mysql'),
    mysqlUtilities = require('mysql-utilities');

    var connection = mysql.createConnection({
        host: 'localhost',
        user: 'root',
        password: '11235813',
        database: 'GazovikDB'
    });

// Mix-in for Data Access Methods and SQL Autogenerating Methods
mysqlUtilities.upgrade(connection);

// Mix-in for Introspection Methods
mysqlUtilities.introspection(connection);

connection.connect();

var client = net.connect(6003, '91.196.6.1');
var client2 = net.connect(6004, '91.196.6.1');
var app = express();

// Создаем HTTP-сервер с помощью модуля HTTP, входящего в Node.js.
// Связываем его с Express и отслеживаем подключения к порту 8580.

var server = require('http').createServer(app).listen(8383);
var io = require('socket.io').listen(server, {log: true});
var n = 1;
io.sockets.on('connection', function (socket) {

client.on('data', function(data) {

    var string = data.toString();
    var array = string.match(/\w+|"[^"]+"/g);
    var year = new Date().getFullYear();
    var call_id = array[0];
    var internal_number = array[2];
    var call_date = array[5]+"/"+array[4]+"/"+year;
    var call_time = array[6]+":"+array[7]+":"+array[8];
    var duration = array[9]+":"+array[10]+":"+array[11];
    var call_type = array[12];
    var dst = array[13];
    var src = array[16];

    if(call_type === "IR"){
        socket.emit('message', "Входящий вызов с номера " + src + " на номер " + dst);
	socket.emit('phoneNumberCheck', internal_number);
	socket.emit('allData', {"call_date": call_date, "call_time": call_time,
	"call_type":call_type, "dst":dst, "src":src});
    }

    if(call_type === "IA"){
        socket.emit('message', "Разговор с абонентом " + src+ " (внешн."+ dst +" внутр."+internal_number+" ) ");
	socket.emit('phoneNumberCheck', internal_number);
	socket.emit('allData', {"internal_number":internal_number, "call_date": call_date, "call_time": call_time, 
        "call_type":call_type, "dst":dst, "src":src});
    }

    if(call_type === "I"){
        socket.emit('message', "Разговор с абонентом "+src+" (внешн."+ dst +" внутр."+internal_number+" ) завершен");
	socket.emit('phoneNumberCheck', internal_number);
	socket.emit('allData', {"internal_number":internal_number, "call_date": call_date, "call_time": call_time, "duration":duration,
        "call_type":call_type, "dst":dst, "src":src});
    }

    if(call_type === "T"){
        socket.emit('message', "Разговор с абонентом "+src+" (внешн."+ dst +" внутр."+internal_number+" ) завершен");
	socket.emit('phoneNumberCheck', internal_number);
	socket.emit('allData', {"internal_number":internal_number, "call_date": call_date, "call_time": call_time, "duration":duration,
        "call_type":call_type, "dst":dst, "src":src});
    }

    }); //client block
    
    
    
    //Подключение ко второй железке
    
    client2.on('data', function(data) {

    var string = data.toString();
    var array = string.match(/\w+|"[^"]+"/g);
    var year = new Date().getFullYear();
    var call_id = array[0];
    var internal_number = array[2];
    var call_date = array[5]+"/"+array[4]+"/"+year;
    var call_time = array[6]+":"+array[7]+":"+array[8];
    var duration = array[9]+":"+array[10]+":"+array[11];
    var call_type = array[12];
    var dst = array[13];
    var src = array[16];

    
    if(call_type === "IR"){
        socket.emit('message', "Входящий вызов с номера " + src + " на номер " + dst);
	socket.emit('phoneNumberCheck', internal_number);
	socket.emit('allData', {"call_date": call_date, "call_time": call_time,
	"call_type":call_type, "dst":dst, "src":src});
    }

    if(call_type === "IA"){
        socket.emit('message', "Разговор с абонентом " + src+ " (внешн."+ dst +" внутр."+internal_number+" ) ");
	socket.emit('phoneNumberCheck', internal_number);
	socket.emit('allData', {"internal_number":internal_number, "call_date": call_date, "call_time": call_time, 
        "call_type":call_type, "dst":dst, "src":src});
    }

    if(call_type === "I"){
        socket.emit('message', "Разговор с абонентом "+src+" (внешн."+ dst +" внутр."+internal_number+" ) завершен");
	socket.emit('phoneNumberCheck', internal_number);
	socket.emit('allData', {"internal_number":internal_number, "call_date": call_date, "call_time": call_time, "duration":duration,
        "call_type":call_type, "dst":dst, "src":src});
    }

    if(call_type === "T"){
        socket.emit('message', "Разговор с абонентом "+src+" (внешн."+ dst +" внутр."+internal_number+" ) завершен");
	socket.emit('phoneNumberCheck', internal_number);
	socket.emit('allData', {"internal_number":internal_number, "call_date": call_date, "call_time": call_time, "duration":duration,
        "call_type":call_type, "dst":dst, "src":src});
        
    }

    }); //client block
});

client.on('data', function(data) {

    var string = data.toString();
    var array = string.match(/\w+|"[^"]+"/g);

    console.info(string);
    var year = new Date().getFullYear();
    var call_id = array[0];
    var internal_number = array[2];
    var call_date = array[5]+"/"+array[4]+"/"+year;
    var call_time = array[6]+":"+array[7]+":"+array[8];
    var duration = array[9]+":"+array[10]+":"+array[11];
    var call_type = array[12];
    var dst = array[13];
    var src = array[16];



    if(call_type === 'O'){
            var sql = 'INSERT INTO cdr (call_id, internal_number, call_date, call_time, duration, call_type, dst) ' +
                            'VALUES("' + call_id + '","' + internal_number + '", "' + call_date + '", "' + call_time + '", "' + duration + '", "' + call_type + '", "' + dst + '")';
            connection.query(sql);
    }
    
    if(call_type === 'IR'){
            var sql = 'INSERT INTO cdr (call_id, internal_number, call_date, call_time, duration, call_type, dst, src, unanswered) ' +
                            'VALUES("' + call_id + '","' + internal_number + '", "' + call_date + '", "' + call_time + '", "' + duration + '", "' + call_type + '", "' + dst + '", "' + src + '","yes")';
            connection.query(sql);
    }else{
	var sql = 'INSERT INTO cdr (call_id, internal_number, call_date, call_time, duration, call_type, dst, src) ' +
                            'VALUES("' + call_id + '","' + internal_number + '", "' + call_date + '", "' + call_time + '", "' + duration + '", "' + call_type +'", "' + dst + '","' + src + '")';
        connection.query(sql);

	var update = 'update cdr set unanswered = "no" where call_id = "' + call_id + '"';
	connection.query(update);

	 }
    if (call_type === 'I') {
        getUnansweredCalls();
    }
    
    }); //client block
    
    //Подключение ко второй железке
    
    client2.on('data', function(data) {

    var string = data.toString();
    var array = string.match(/\w+|"[^"]+"/g);

    console.info(string);
    var year = new Date().getFullYear();
    var call_id = array[0];
    var internal_number = array[2];
    var call_date = array[5]+"/"+array[4]+"/"+year;
    var call_time = array[6]+":"+array[7]+":"+array[8];
    var duration = array[9]+":"+array[10]+":"+array[11];
    var call_type = array[12];
    var dst = array[13];
    var src = array[16];



    if(call_type === 'O'){
            var sql = 'INSERT INTO cdr (call_id, internal_number, call_date, call_time, duration, call_type, dst) ' +
                            'VALUES("' + call_id + '","' + internal_number + '", "' + call_date + '", "' + call_time + '", "' + duration + '", "' + call_type + '", "' + dst + '")';
            connection.query(sql);
    }
    
    if(call_type === 'IR'){
            var sql = 'INSERT INTO cdr (call_id, internal_number, call_date, call_time, duration, call_type, dst, src, unanswered) ' +
                            'VALUES("' + call_id + '","' + internal_number + '", "' + call_date + '", "' + call_time + '", "' + duration + '", "' + call_type + '", "' + dst + '", "' + src + '","yes")';
            connection.query(sql);
    }else{
	var sql = 'INSERT INTO cdr (call_id, internal_number, call_date, call_time, duration, call_type, dst, src) ' +
                            'VALUES("' + call_id + '","' + internal_number + '", "' + call_date + '", "' + call_time + '", "' + duration + '", "' + call_type +'", "' + dst + '","' + src + '")';
        connection.query(sql);

	var update = 'update cdr set unanswered = "no" where call_id = "' + call_id + '"';
	connection.query(update);
        
        
	 }
         
     if(call_type === 'I') {
        getUnansweredCalls();
    }

    }); //client block

client.on('error', function(err) {
    console.log('error:', err.message);
});

client2.on('error', function(err) {
    console.log('error:', err.message);
});

function getContactUser(internal_number){
    
    var query = connection.query('select company from users where phone = "' + internal_number);
 
    query.on('result', function(row) {
        console.info(row.company);
        
    });

}

function getUnansweredCalls(){
    connection.connect(function(err){
        var sql = "SELECT * FROM  `cdr` inner join `users` on `users`.`phone` = `cdr`.`internal_number` WHERE `cdr`.`unanswered` =  'yes' AND `cdr`.`sent` =  'no' AND `call_time` ='00:00:00' AND `cdr`.`call_type` =  'IR'";

        connection.query(sql, function(err, rows, fields) {
            if (err) return console.log(err);
                //  you need to end your connection inside here.
                //connection.end();
                
                rows.forEach(function(item) {
                    sendEmailData2Func(item.id, item.call_id, item.internal_number, item.call_date, item.call_time, item.duration, item.call_type, item.dst, item.src, item.unanswered, item.email);
                });
                //socket.emit('getUnansweredCalls',rows);
                //connection.end();
        });
    });
}


function sendEmailData2Func(id, call_id, internal_number, call_date, call_time, duration, call_type, dst, src, unanswered,email){
    rest.post('http://gaz.dialog64.ru/general/sendMail', {
  data: {"call_id":call_id, "internal_number":internal_number, "call_date":call_date, "call_time":call_time, "duration":duration, "call_type":call_type, "dst":dst, "src":src, "unanswered":unanswered,"email":email}
}).on('complete', function(data, response){
  if (response.statusCode === 201) {
    // you can get at the raw response like this...
  }
});
}