<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="color-scheme" content="light">
<meta name="supported-color-schemes" content="light">
<style>

*{
    text-align: center;
    box-sizing: border-box;
    margin: 0   
}

@media only screen and (max-width: 600px) {
div{
    font-size: 10px;
}
}


</style>
</head>
<body>

<div style="width:100%; height:100vh; background: linear-gradient(187.16deg, #181623 0.07%, #191725 51.65%, #0D0B14 98.75%);">
        <div style="padding-top:5%">
            <img style=" object-fit: cover" src="/images/verification.png" alt="">
            <p style="color: #DDCCAA">MOVIE QUOTES</p>

            <div style="color:white; margin-top: 20px; text-align: left; display:flex; flex-direction: column">
                
                <h2 style="text-align: left; padding-left: 50px">Hola {{ $user->username }}!</h2>
                <h2 style="text-align: left; padding-left: 50px; padding-top:20px;">Thanks for joining Movie quotes! We really appreciate it. Please click the button below to verify your account:</h2>
                <a href="{{env('APP_URL').'home/verify-new-email?token='.$email->token}}" style="align-self:flex-start; margin-left:50px; margin-top:20px; background-color:#E31221; padding:10px; border-radius:5px; color:white; text-decoration:none ">Verify account</a>
                
               <h2 style="text-align:left; padding-left:50px; padding-top:20px">If clicking doesn't work, you can try copying and pasting it to your browser:</h2> 
                
               <a href="{{env('APP_URL').'home/verify-new-email?token='.$email->token}}"><p style="color: #DDCCAA ; text-decoration: none; text-align:left; padding-left:50px; padding-top:20px">{{env('APP_URL').'home/verify-new-email?token='.$email->token}}</p></a>
                <p style="text-align:left; padding-left:50px; padding-top:20px">If you have any problems, please contact us: support@moviequotes.ge</p>
                <p style="text-align:left; padding-left:50px; padding-top:20px">MovieQuotes Crew</p>

                
            </div>
        </div>
        

</div>
</body>
</html>