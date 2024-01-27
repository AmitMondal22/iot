<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">

<title>Title</title>
</head>
<body>
<p>Dataaa xdnfvjkdnvjk<span id="testData"></span></p>

<script src="{{asset('public/js/app.js')}}"></script>
<script>
    Echo.channel('test').listen('EventTest',(e)=>{
        console.log(e.stData)
        document.getElementById('testData').innerHTML = e.stData;
    });


    // Echo.private('test').listen('privchannelName',(e)=>{
    //     console.log(e.msgData)
    // });



    // Echo.join('test')
    // .here((users)=>{
    //     console.log("alluser"+users)
    // })
    // .joning((user)=>{
    //     console.log("New join user"+user)
    // })
    // .leaving((user)=>{
    //     console.log("leave user"+user)
    // })
    // .listen('msgpresenceChannel',(e)=>{
    //     console.log(e.msgData)
    // });
</script>
</body>
</html>
