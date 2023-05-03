<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://fonts.cdnfonts.com/css/manrope" rel="stylesheet">
                
    <meta charset="UTF-8">
    <title>Welcome to Dexterapp!</title>
</head>
<body  style="background-color:#f7f9fc; font-family: 'Manrope', sans-serif; line-height: 25px;">
    
    <div style="position: relative; display: flex; flex-direction: column; width: 70vw; margin-left: 15vw; margin-right: 15vw; margin-top: 10vw; background-color: #FFFFFF;">

        {{-- HEADER --}}
        {{-- #f4f5f7 --}}
        <div style="display: flex; flex-direction: column; align-items: center;background-color:  ; padding-top: 20px; padding-bottom: 20px; border-bottom: 1px solid #276E59;">

            <img src="https://res.cloudinary.com/dxjt9xfjb/image/upload/v1680195678/app/logo/dexterlogogreen_syudqf.png" alt="dexterlogo" style="width: 152px; height:58px"/>
        </div>


        <div style="display: flex; flex-direction: column; padding-top: 50px; padding-left: 80px; padding-right: 80px; font-size 14px; text-align: justify;">
            {{-- <p>Dear {{ $name }},</p> --}}
            <p style="font-size: 18px; font-weight: 600; ">Hi  {{ $name }},</p>
            <p style="font-size: 14px; font-weight: 400; "> Welcome to Dexter Your go-to {{ $otp }}
            </p>

            <img src="https://res.cloudinary.com/dxjt9xfjb/image/upload/v1680195679/app/logo/phone_pzlstj.png" style="margin-top: 20px; margin-bottom: 20px;" />

           

           
        </div> 

    </div>
    
</body>
</html>
