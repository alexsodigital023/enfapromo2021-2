<?php

namespace App\Http\Controllers;

use App\Ticket;
use Illuminate\Http\Request;
use App\Mutators\Storage\Spaces;
use App\Sodigital\Services\Regex\Regex;
use App\Sodigital\Interfaces\Controllers\ServiceControllerInterface;
use App\Sodigital\Services\Ocr\GoogleOcr;
use App\Providers\CdpServiceProvider;
use App\Providers\AdvantageServiceProvider;

class ServiceController extends Controller implements ServiceControllerInterface
{
    use Spaces;
    use GoogleOcr;

    public function run(Request $request){
        set_time_limit(60);
        $ticket=Ticket::find($request->get("id"));
        if(!$ticket){
            throw new \Exception("ticket inexistente");
        }
        if(true||$ticket->status_id==1
            ||$ticket->status_id==7
            ||$ticket->status_id==8
            ){
            $ticket->status_id=8;
            $ticket->save();
            $url=$this->temporaryUrl($ticket->path,10);
            $time=time();
            $txt = $this->checkInGoogle($url);
            $time2=time();
            $ticket->status_id=strlen($ticket->data)>5?4:7;
            $ticket->submited=1;
            $ticket->data=base64_encode(json_encode($txt));
            $ticket->process_time=$time2-$time;
            $ticket->save();
            }
        if(strlen($ticket->data)>5){
            $regex=new Regex();
            $ticket->status_id=9;
            $ticket->save();
            $regex->processTicket($ticket);
        }
        return response()->json([
            "id"=>$ticket->id,
            "status_id"=>$ticket->status_id
        ]);
    }
    public function report(Request $request){
        $ticket=Ticket::find($request->get("id"));

        $config = (object)config('services.cdp');
        $cdp = new CdpServiceProvider($config);
        $payload = [
                "FirstName" => $ticket->nombre,
                "LastName" => $ticket->apellido,
                "LanguageCode"=>  "SPA",
                "Emails"=>  [
                  (object)[
                    "EmailAddress" =>  $ticket->email,
                    "DeliveryStatus" =>  "G"
                    ]
                ],
                "SourceCode"=>  $config->AccountSourceCode,
                "EnrollmentStatus"=>  "A",
                "EnrollChannelCode"=>  "WEB",
                "TierCode"=>  $config->TierCode,
                "BirthDate"=> (new \DateTime($ticket->created_at))->format("Y-m-d\TH:i:s.u\Z"),
                "JsonExternalData"=>  [
                  "Agreements"=>  [
                    (object)[
                      "BusinessId"=>  $config->legal_id,
                      "RevisionId"=>  $config->legal_version,
                      "ConsentAcceptedInd"=>  true,
                      "ConsentDesc"=>  $config->legal_description,
                      "MandatoryInd"=>  true,
                      "AgreementDate"=>   (new \DateTime($ticket->created_at))->format("Y-m-d H:i:s"),
                      "ActivityDate"=>  (new \DateTime($ticket->created_at))->format("Y-m-d\TH:i:s.u\Z"),
                      "Status"=>  "A"
                    ],
                    (object)[
                      "BusinessId"=>  "LT-PP-MX-es-Enfagrow-PrivacyPolicyGoldenPromo",
                      "RevisionId"=>  "60fffe67207a4c0001942941",
                      "ConsentAcceptedInd"=>  true,
                      "ConsentDesc"=>   "Privacy Policy for Enfagrow",
                      "MandatoryInd"=>  false,
                      "AgreementDate"=>   (new \DateTime($ticket->created_at))->format("Y-m-d H:i:s"),
                      "ActivityDate"=>  (new \DateTime($ticket->created_at))->format("Y-m-d\TH:i:s.u\Z"),
                      "Status"=>  "A"
                    ]
                  ],
                  "ProfileSubscriptions"=> [
                      [
                          "SubscriptionId"=> "882ddb48-dc46-42f7-8a17-8c9a12247084",
                          "OptSource"=> "WEB",
                          "ChannelCode"=> "EM",
                          "OptStatus"=> true,
                          "ActivityDate"=> (new \DateTime($ticket->created_at))->format("Y-m-d\TH:i:s.u\Z"),
                          "Status"=> "A",
                          "JsonExternalData"=> [
                              "ContactPointValue"=> $ticket->email,
                              "EmailOptFlag"=> "Y"
                        ]
                      ]
                  ],
                  "ProfileActivity"=> [
                      "ActivityInput"=> (object)[],
                      "ActivityType"=> "REGISTRATION",
                      "Status"=> "A",
                      "DataSourceCode"=> "MJNMEXAPP2021",
                      "JsonExternalData"=> [
                          "ActivityDate"=> (new \DateTime($ticket->created_at))->format("Y-m-d\TH:i:s.u\Z"),
                          "CountryCode"=> "SPA"
                      ]
                    ],
                  "UnmappedAttributes"=>  (object)[
                    "Retail"=> "test"
                ],
                  "UtmAttributes"=>  [
                    [
                      "CsProfileUtmAttrId"=> "f372381f-de26-4ee1-bed5-e4ad07ddece1",
                      "CampaignSource"=> "Web Enfapromo",
                      "CampaignMedium"=> "WEB",
                      "CampaignName"=> "Enfapromo",
                      "CampaignTerm"=> "",
                      "CampaignContent"=> "From site registration link",
                      "ActivityDate"=> "2020-10-06T18:06:45Z",
                      "Status"=> "A",
                      "UtmCampaign"=> "",
                      "UtmSource"=> "",
                      "CDPAutoGenerateInd"=> ""
                    ]
                  ]
            ]
        ];
        $res = $cdp->process($payload);
        $config = (object)config('services.advantage');
        $owner=[
          "usuario"=>$ticket->email,
          "cliente"=>$ticket->user_id,
          "firstname"=>$ticket->nombre,
          "lastname"=>$ticket->apellido,
          "phonenumber"=>0
        ];
        $advantage=new AdvantageServiceProvider($config,$owner);
        $payload=[
          "source"=>0,
          "TX"=>$ticket->fingerprint
        ];
        $tmpFile=tempnam(sys_get_temp_dir(),'ticket_');
        file_put_contents($tmpFile,$this->getFile($ticket->path));
        $file=[
          "tmp_name"=>$tmpFile
        ];
        $advantage->sendPhotoTicket($payload,$file);
        return response()->json([$res]);
    }
}