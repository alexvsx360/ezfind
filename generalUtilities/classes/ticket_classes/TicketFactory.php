<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 18/03/2018
 * Time: 08:49
 */
include_once "Loan.php";
include_once "Pedion.php";
include_once "PedionHishtalmut.php";
include_once "update_details.php";
include_once "update_beneficiaries.php";
include_once "missing_deposits.php";
include_once "basicTicket.php";
class TicketFactory
{
    protected $ticket;

    public function makeTicket($type,$programDetails,$customerCount){
        if ($type == 'loan'){
             $ticket = new Loan();
            return $this->ticket=$ticket->getHeader($customerCount). $ticket->dinamicData($programDetails).$ticket->getFooter();
        }
        if($type == 'pedion'){
            $ticket = new Pedion();
            return $this->ticket=$ticket->getHeader($customerCount). $ticket->dinamicData($programDetails).$ticket->getFooter();
        }
        if($type == 'pedion_hishtalmut'){
          $ticket = new PedionHishtalmut();
          return $this->ticket=$ticket->getHeader($customerCount). $ticket->dinamicData().$ticket->getFooter();
        }
        if($type == 'update_details'){
             $ticket = new update_details($programDetails);
            return $this->ticket=$ticket->getHeader($customerCount). $ticket->dinamicData($programDetails).$ticket->getFooter();
        }
        if($type == 'update_beneficiaries'){
             $ticket = new update_beneficiaries($programDetails);
            return $this->ticket=$ticket->getHeader($customerCount). $ticket->dinamicData($programDetails).$ticket->getFooter();
        }
        if($type == 'missing_deposits'){
            $ticket = new missing_deposits();
            return $this->ticket=$ticket->getHeader($customerCount). $ticket->dinamicData($programDetails).$ticket->getFooter();
        }
    }
}