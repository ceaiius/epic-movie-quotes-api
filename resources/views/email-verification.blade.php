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


<body style="background: #181624; color:white;font-family: 'Montserrat', sans-serif; word-wrap: break-word; ">
    <div style="padding:2% 8%">
        <div style="text-align: center;font-size: 12px;margin-bottom: 73px">
            
            <h1 style="color:#DDCCAA; font-weight: 500">MOVIE QUOTES</h1>
        </div>
        <p style="margin-bottom: 24px">Hola! </p>
        <p style="margin-bottom: 32px">Thanks for joining Movie quotes! We really appreciate it. Please click the button
            below to verify your account:
        </p>
        <a href="{{ $url }}"
            style="max-width: 128px;padding:7px 13px;color:white;background:#E31221;text-decoration: none;font-weight: 400;
            border-radius:4px">Verify
            account</a>
        <p style="margin-bottom: 24px;margin-top:40px">If clicking doesn't work, you can try copying and pasting it to
            your
            browser:</p>
        <a href="{{ $url }}"
            style="margin-bottom: 40px;color:#DDCCAA;text-decoration: none;cursor: pointer">
            {{ $url }}</a>
        <p style="margin-bottom: 24px">If you have any problems, please contact us: support@moviequotes.ge</p>
        <p>MovieQuotes Crew</p>
    </div>
</body>
</html>