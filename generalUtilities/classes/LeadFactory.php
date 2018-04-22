<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 12/04/2018
 * Time: 09:22
 */

class LeadFactory
{
    public static function create($leadToPopulateJson)
    {
        $campaign_id = $leadToPopulateJson['lead']['campaign_id'];
        $channel_id = $leadToPopulateJson['lead']['channel_id'];
        switch ($campaign_id){
            case 17967:// policy campaign
                switch ($channel_id){
                    case 19582: //old DB channel
                        //do nothing
                        return null;
                    default:
                        return new LeadPolicy($leadToPopulateJson);
                }
            case 18491:// serut lakochot campaign
                switch ($channel_id){
                    case 18600: // bitulim channel
                        return new LeadToCancel($leadToPopulateJson);
                    default:
                        return null;
                }
            case 18679: // muzarey zmicha campaign
                switch ($channel_id){
                    case 18681://mislaka pensionit channel
                        return new LeadMislakaPensyonit($leadToPopulateJson);
                    case 19904://loan channel
                        return new LeadLoans($leadToPopulateJson);
                    case 19648://pedion channel
                        return new LeadPedion($leadToPopulateJson);
                    case 19944://pedion hishtalmut channel
                        return new LeadPedionHishtalmut($leadToPopulateJson);
                    case 19942://pigurim/hafkadot chaserot channel
                        return new LeadPigurim($leadToPopulateJson);
                    case 19940://edkun mutavim channel
                    return new LeadEdcunMutavim($leadToPopulateJson);
                    case 19939://edkun pratim channel
                        return new LeadEdKunPratim($leadToPopulateJson);
                    default:
                        return null;
                }
        }
    }
}