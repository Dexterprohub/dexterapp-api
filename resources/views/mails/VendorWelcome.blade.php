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
            <p style="font-size: 18px; font-weight: 600; ">Hi {{ $name }},</p>
            <p style="font-size: 14px; font-weight: 400; "> Welcome to Dexter. Your go-to platform for connecting with top-rated vendors offering a wide range of services, such as food ordering, laundry, AC repair, electrical repair, makeup services, and more. We are excited to have you join our community and look forward to providing you with a seamless and hassle-free experience.
            </p>

            <img src="https://res.cloudinary.com/dxjt9xfjb/image/upload/v1680195679/app/logo/phone_pzlstj.png" style="margin-top: 20px; margin-bottom: 20px;" />

            <p style="font-size: 14px;">At Dexter, our mission is to make it easy for you to find the right services at the right price, all in one place. As a new member of our community, we want to help you get started on the right foot. Here are a few things you can do:
        
                Explore our platform - Take a moment to browse through our vendors and their services. Discover how Dexter can help you find the perfect service provider for your needs.

                Customise your profile - Add a profile picture, and update your information,. This will help us personalise your experience and connect you with vendors who are a great match for you.
                
                Get in touch with us - If you have any questions or concerns, don't hesitate to contact our support team. We are always here to help and are committed to ensuring your satisfaction.
                Once again, Welcome to Dexter! We are thrilled to have you as a part of our community and can't wait to help you find the services you need.
                
                
                
                <p style="font-size: 14px;">Cheers🥂 <br /> The Dexter Team</p>
            </p>

            <div style="position: relative; display:flex; flex-direction:column;">
                <p>Download our app for Google & App Store.</p>
                
                <span style="display:flex; flex-direction:row; gap: 16px;">
                    <img src="https://res.cloudinary.com/dxjt9xfjb/image/upload/v1680196086/app/logo/Mobile_app_store_badge-3_udrgxq.png" style="max-width: 45%"/>
                    
                    <img src="https://res.cloudinary.com/dxjt9xfjb/image/upload/v1680196085/app/logo/Mobile_app_store_badge-2_k08iai.png" style="max-width: 45%"/>
                
                </span>
                <br />
                <p style="font-size: 15px; ">Follow Us</p>
                <span style="display: flex; flex-direction: row; align-items: center; gap: 16px;">
                    <a href=""><img src="https://res.cloudinary.com/dxjt9xfjb/image/upload/v1680236243/app/logo/Social_icon_-_Twitter_am3ps0.png" alt=""></a>
                    <a href=""><img src="https://res.cloudinary.com/dxjt9xfjb/image/upload/v1680236242/app/logo/Social_icon_-_FB_mqkkm5.png" alt=""></a>
                    <a href="https://www.instagram.com/dexterapp_hq/"><img src="https://res.cloudinary.com/dxjt9xfjb/image/upload/v1680236242/app/logo/Social_icon_-_IG_za2mii.png" alt=""></a>
                </span>

                <p style="font-size:14px; weight: 300px; text-align: justify;">
                    If you have any questions or need immediate help getting started? Check out our support page. Or, just reply to this email, the ChurchRUSH support team is always ready to help! 
                </p>

                {{-- background-color:#8f8f8f; --}}
                <footer style="display: flex; flex-direction: column; justify-content: space-around; align-items: center; width: 100%; @media screen and (max-width: 992px) {
                               /* footer{
                                   display: flex;
                                   flex-direction: row;
                               } */
                            }"
                        >
                    <p style="font-size: 11px; text-align: center; margin-top: 50px;">36b Jay Jay Oladimeji Close, Ikate, Lekki Phase 1, Lagos.
                    © 2022 Dexter</p>

                    <span style="display: flex; flex-direction:row; gap: 16px; font-size: 12px; color: rgba(0, 0, 0, 0.7); ">
                        <ul style="display: flex; flex-direction:row; gap: 40px; color: rgba(0, 0, 0, 0.7); 
                                @media screen and (max-width: 400px) {
                                   .bulletList {
                                       display: flex;
                                       flex-direction: column;
                                   }
                                }"
                            >
                            <li style="color: rgba(0, 0, 0, 0.7);" class="bulletList">
                                <a href="" style="text-decoration: none; color: rgba(0, 0, 0, 0.7); ">
                                    Privacy policy
                                </a>
                            </li>
                            <li>
                                <a href="" style="text-decoration: none; color: rgba(0, 0, 0, 0.7);" class="bulletList">
                                    Terms of service
                                </a>
                            </li>
                            <li>
                                <a href="" style="text-decoration: none; color: rgba(0, 0, 0, 0.7);" class="bulletList">
                                    Help center
                                </a>
                            </li>
                            <li>
                                <a href="" style="text-decoration: none; color: rgba(0, 0, 0, 0.7);" class="bulletList">
                                    Unsubscribe
                                </a>
                            </li>
                        </ul>

                    </span>

                </footer>

            </div>
         </div>

    </div>
    
</body>
</html>
