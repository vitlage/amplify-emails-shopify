<?php
namespace App;

// Uncomment next line if you're not using a dependency loader (such as Composer)
// require_once '<PATH TO>/sendgrid-php.php';

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use SendGrid\Mail\To;
use SendGrid\Mail\Cc;
use SendGrid\Mail\Bcc;
use SendGrid\Mail\From;
use SendGrid\Mail\Content;
use SendGrid\Mail\Mail;
use SendGrid\Mail\Personalization;
use SendGrid\Mail\Subject;
use SendGrid\Mail\Header;
use SendGrid\Mail\CustomArg;
use SendGrid\Mail\SendAt;
use SendGrid\Mail\Attachment;
use SendGrid\Mail\Asm;
use SendGrid\Mail\MailSettings;
use SendGrid\Mail\BccSettings;
use SendGrid\Mail\SandBoxMode;
use SendGrid\Mail\BypassListManagement;
use SendGrid\Mail\Footer;
use SendGrid\Mail\SpamCheck;
use SendGrid\Mail\TrackingSettings;
use SendGrid\Mail\ClickTracking;
use SendGrid\Mail\OpenTracking;
use SendGrid\Mail\SubscriptionTracking;
use SendGrid\Mail\Ganalytics;
use SendGrid\Mail\ReplyTo;
class SendEmail extends Mailable
{
    use Queueable, SerializesModels;

    public static function templateApi($user = null, $data = null)
    {

//dd($data);

        $apiKey = getenv('SENDGRID_API_KEY');

        $sg = new \SendGrid($apiKey);

        $mail = new Mail();

        $personalization0 = new Personalization();
//        $personalization0->addTo(new To("qadeersabir9@gmail.com", "Qadeer"));
        $personalization0->addTo(new To($user, ""));
//$personalization0->addCc(new Cc("jane_doe@example.com", "Jane Doe"));
//$personalization0->addBcc(new Bcc("james_doe@example.com", "Jim Doe"));
        $mail->addPersonalization($personalization0);

        $mail->setFrom(new From($data['from_email'], $data['from_name']));

        $mail->setReplyTo(new ReplyTo($data['reply_to'], $data['from_name']));

        $mail->setSubject(new Subject($data['subject']));
        if($data['type']=="regular"){
            $mail->addContent(new Content("text/html", $data['template']));

        }else{
            $mail->addContent(new Content("text/plain",$data['plain_text'] ));

        }

        /*$attachment0 = new Attachment();
        $attachment0->setContent("PCFET0NUWVBFIGh0bWw+CjxodG1sIGxhbmc9ImVuIj4KCiAgICA8aGVhZD4KICAgICAgICA8bWV0YSBjaGFyc2V0PSJVVEYtOCI+CiAgICAgICAgPG1ldGEgaHR0cC1lcXVpdj0iWC1VQS1Db21wYXRpYmxlIiBjb250ZW50PSJJRT1lZGdlIj4KICAgICAgICA8bWV0YSBuYW1lPSJ2aWV3cG9ydCIgY29udGVudD0id2lkdGg9ZGV2aWNlLXdpZHRoLCBpbml0aWFsLXNjYWxlPTEuMCI+CiAgICAgICAgPHRpdGxlPkRvY3VtZW50PC90aXRsZT4KICAgIDwvaGVhZD4KCiAgICA8Ym9keT4KCiAgICA8L2JvZHk+Cgo8L2h0bWw+Cg==");
        $attachment0->setFilename("index.html");
        $attachment0->setType("text/html");
        $attachment0->setDisposition("attachment");
        $mail->addAttachment($attachment0);*/

        /*$mail->addCategory("cake");
        $mail->addCategory("pie");
        $mail->addCategory("baking");*/

//$mail->setSendAt(new SendAt(1617260400));

//        $mail->setBatchId("AsdFgHjklQweRTYuIopzXcVBNm0aSDfGHjklmZcVbNMqWert1znmOP2asDFjkl");

        /*$asm = new ASM();
        $asm->setGroupId(12345);
        $asm->setGroupsToDisplay([12345]);
        $mail->setASM($asm);*/

//        $mail->setIpPoolName("transactional email");

        $mail_settings = new MailSettings();
        $bypass_list_management = new BypassListManagement();
        $bypass_list_management->setEnable(false);
        $mail_settings->setBypassListManagement($bypass_list_management);
        $footer = new Footer();
        $footer->setEnable(false);
        $mail_settings->setFooter($footer);
        $sandbox_mode = new SandboxMode();
        $sandbox_mode->setEnable(false);
        $mail_settings->setSandboxMode($sandbox_mode);
        $mail->setMailSettings($mail_settings);

        $tracking_settings = new TrackingSettings();
        $click_tracking = new ClickTracking();
        $click_tracking->setEnable(true);
        $click_tracking->setEnableText(false);
        $tracking_settings->setClickTracking($click_tracking);
        $open_tracking = new OpenTracking();
        $open_tracking->setEnable(true);
        $open_tracking->setSubstitutionTag("%open-track%");
        $tracking_settings->setOpenTracking($open_tracking);
        $subscription_tracking = new SubscriptionTracking();
        $subscription_tracking->setEnable(false);
        $tracking_settings->setSubscriptionTracking($subscription_tracking);
        $mail->setTrackingSettings($tracking_settings);

        $request_body = $mail;

        try {
            $response = $sg->client->mail()->send()->post($request_body);
//            print $response->statusCode() . "\n";
//            print_r($response->headers());
//            print $response->body() . "\n";
           $header=(json_decode(json_encode($response->headers())));
           foreach ($header as $x_message){
               $x_message_id=explode(':',$x_message);
               if($x_message_id[0]=="X-Message-Id"){
                   $message_id = str_replace("X-Message-Id: ", "", $x_message);
                    break;
               }
           }
            /*$message_id=$header[5];
            $message_id = str_replace("X-Message-Id: ", "", $message_id);*/
            $email_responce=EmailResponce::where('id',$data['email_responce_id'])->update([
                    'message_id'=>$message_id,
                    'event'=>"sent",
            ]);
//           dd($header);
        } catch (Exception $ex) {
            $email_responce=EmailResponce::where('id',$data['email_responce_id'])->update([
                'event'=>"failed",
            ]);
//                        dd($ex->getMessage());

        }

    }
}


