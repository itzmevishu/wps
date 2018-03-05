<!DOCTYPE html>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><style type="text/css"></style></head><body data-pinterest-extension-installed="cr1.35">
<table border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse" width="100%">
    <tbody>
    <tr>
        <td align="center" bgcolor="#F1F1F1" style="padding-right:10px;padding-left:10px" width="100%">
            <table border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse" width="600">
                <tbody>
                <tr>
                    <td align="left" style="padding-right:20px;padding-bottom:20px" valign="top"><a href="http://pivotal.io" target="_blank"><img alt="" border="0" src="http://play.gopivotal.com/rs/pivotal/images/Pivotal-email-header-logo.png" style="display:block"></a></td>
                </tr>
                </tbody>
            </table>


            <table border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse" width="600">
                <tbody>
                <tr>
                    <td align="left" bgcolor="#FFFFFF" valign="top">
                        <table border="0" cellpadding="40" cellspacing="0" style="border-collapse:collapse">
                            <tbody>
                            <tr>
                                <td style="color:#666666;font-size:14px;line-height:22px">
                                    <div>
                                        <div style="font-size:10pt;font-family:helvetica,arial,verdana">
                                            <p><span style="color:rgb(0,0,0);font-family:Arial;white-space:pre-wrap">Hello {{ $user['first_name'] }},</span></p>
                                            <p><span style="color:rgb(0,0,0);font-family:Arial;white-space:pre-wrap">You have requested to reset your password for the Pivotal Academy Store.</span></p>
                                            <p><span style="color:rgb(0,0,0);font-family:Arial;white-space:pre-wrap">Please click the following link to finish resetting your password: {{ URL::to('password/reset', array($token)) }}.</span></p>
                                            <p><span style="color:rgb(0,0,0);font-family:Arial;white-space:pre-wrap">This link will expire in {{ Config::get('auth.reminder.expire', 60) }} minutes.</span></p>
                                            <p><span style="color:rgb(0,0,0);font-family:Arial;white-space:pre-wrap">Questions? Contact Pivotal Academy at <a href="mailto:academy@pivotal.io" target="_blank">academy@pivotal.io</a>.</span></p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>


            <table border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse" width="600">
                <tbody>
                <tr>
                    <td align="left" style="padding-top:15px;padding-bottom:15px;padding-left:40px" valign="middle"><a href="http://pivotal.io" style="color:#3ea7bc;text-decoration:none;font-size:15px" target="_blank">pivotal.io</a></td>
                    <td align="right" style="padding-top:15px;padding-right:40px;padding-bottom:15px" valign="middle">
                        <table border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse" width="189">
                            <tbody>
                            <tr>
                                <td style="padding-right:16px"><a href="https://twitter.com/pivotal" target="_blank"><img alt="Follow us on Twitter" border="0" src="http://play.gopivotal.com/rs/pivotal/images/email-social-twitter-small.png" style="max-width:25px;height:24px;display:block"></a></td>
                                <td style="padding-right:16px"><a href="http://www.linkedin.com/company/3048967" target="_blank"><img alt="Join the conversation on LinkedIn" border="0" src="http://play.gopivotal.com/rs/pivotal/images/email-social-linkedin-small.png" style="max-width:25px;height:24px;display:block"></a></td>
                                <td style="padding-right:16px"><a href="https://www.facebook.com/pivotalsoftware" target="_blank"><img alt="Like us on Facebook" border="0" src="http://play.gopivotal.com/rs/pivotal/images/email-social-facebook-small.png" style="max-width:25px;height:24px;display:block"></a></td>
                                <td style="padding-right:16px"><a href="https://plus.google.com/105320112436428794490/posts" target="_blank"><img alt="Add us on Google+" border="0" src="http://play.gopivotal.com/rs/pivotal/images/email-social-google-small.png" style="max-width:25px;height:24px;display:block"></a></td>
                                <td style="padding-right:16px"><a href="http://www.youtube.com/gopivotal" target="_blank"><img alt="Visit our YouTube channel" border="0" src="http://play.gopivotal.com/rs/pivotal/images/email-social-youtube-small.png" style="max-width:25px;height:24px;display:block"></a></td>
                                <td><a href="http://www.instagram.com/pivotalsoftware" target="_blank"><img alt="Follow us on Instagram" border="0" src="http://play.gopivotal.com/rs/pivotal/images/email-social-instagram-small.png" style="max-width:25px;height:24px;display:block"></a></td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>


            <table border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse" width="600">
                <tbody>
                <tr>
                    <td align="center" style="padding-top:30px;padding-right:40px;padding-bottom:20px;padding-left:40px;border-top:1px solid #cccccc;color:#999999;font-size:12px;line-height:14px" valign="top">Pivotal’s Cloud Native platform drives software innovation for many of the world’s most admired brands. With millions of developers in communities around the world, Pivotal technology touches billions of users every day. After shaping the software development culture of Silicon Valley's most valuable companies for over a decade, today Pivotal leads a global technology movement transforming how the world builds software. More at <a href="http://pivotal.io" style="color:#3ea7bc;text-decoration:none" target="_blank">pivotal.io.</a></td>
                </tr>
                <tr>
                    <td align="center" style="padding-top:20px;padding-right:40px;padding-bottom:60px;padding-left:40px;color:#999999;font-size:12px;line-height:14px" valign="top">© Pivotal, and the Pivotal logo are registered trademarks or trademarks of Pivotal Software, Inc. in the United States and other countries. All other trademarks used herein are the property of their respective owners. © 2015 Pivotal Software, Inc. All rights reserved. Published in the USA.</td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
</body></html>
