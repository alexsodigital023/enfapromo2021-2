<?php

namespace App\Http\Controllers;

use App\Ticket;
use Illuminate\Http\Request;
use App\Mutators\Storage\Spaces;
use App\Sodigital\Services\Regex\Regex;
use App\Sodigital\Interfaces\Controllers\ServiceControllerInterface;
use App\Sodigital\Services\Ocr\GoogleOcr;
use App\Providers\CdpServiceProvider;

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
                              "ContactPointValue"=> "test.calctose@rb.com",
                              "EmailOptFlag"=> "Y"
                        ]
                      ]
                  ],
                  "ProfileActivity"=> [
                      "ActivityInput"=> (object)[],
                      "ActivityType"=> "REGISTRATION",
                      "Status"=> "A",
                      "DataSourceCode"=> "RBMEXCALAPP2021",
                      "JsonExternalData"=> [
                          "ActivityDate"=> (new \DateTime($ticket->created_at))->format("Y-m-d\TH:i:s.u\Z"),
                          "CountryCode"=> "SPA"
                      ]
                    ],
                  "UnmappedAttributes"=>  (object)[
                    "Retail"=> "test"
                ],
                  "UtmAttributes"=>  []
            ]
        ];
        $res = $cdp->process($payload);
        return response()->json($res);
    }
}