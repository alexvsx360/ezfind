<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 18/03/2018
 * Time: 08:52
 */

include_once "TicketFactory.php";
class CreateTicket
{
    protected $ticket;

    public function __construct()
    {
        $this->ticket = new TicketFactory();
    }

    public function createTicket($type=null, $customerCount, $details=null)
    {
        $ticket =  $this->ticket->makeTicket($type, $details, $customerCount);
        $this->ticket = $ticket;
    }

    public function getTicket()
    {

        return  $this->ticket;
    }
}

