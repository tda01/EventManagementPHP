<?php
require_once "dbClasses/eventDBController.php";
require_once "dbClasses/ticketsDBController.php";
require_once "eventPage.php";

session_start();

if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
    $id = $_GET["id"];

} else {
    exit("ID-ul nu a fost primit");
}

$eventController = new eventDBController();
$event = $eventController->getEvent($id);
$style = "eventSpeakers.css";

$content = '<div class="speakPage hero flex items-centre justify-between">
  <div class="left flex flex-1 justify-center">
    <p>Tickets</p>
  </div>
</div>';

$ticketController = new ticketsDBController();
$ticketType = $ticketController->getEventTicketTypes($id);

if (!empty($ticketType)) {
    $content .= '<section class="about">
  <div class="container flex items-centre">
    <div class="right flex-1 contact">
      <h1><span>Details</span></h1>
      <p>'.$ticketType[0]["ticketDescription"].'</p>
      <h1>Price: <span>'.$ticketType[0]["price"].' RON</span></h1>
    </div>
  </div>
</section><section class="register">
  <div class="container flex items-centre">
    <div class="right flex-1 contact">
      <h1>Buy tickets now</h1>
      <form action="buyTickets.php?id='.$id.'" method="post">
        <div class="input-group">
          <input type="text" name="buyerFirstName" placeholder="First Name" required/>
          <input type="text" name="buyerLastName" placeholder="Last Name" required/>
          <input type="number" name="numberOfTickets" placeholder="Number of tickets" required/>
        </div>
        <button class="btn btn-secondary" id="btnBuyTicket">Buy Tickets</button>
      </form>
    </div>
  </div>
</section>';

} else {
    $content .= '<section class="about">
  <div class="container flex items-centre">
    <div class="right flex-1 contact">
      <h1><span>Details</span></h1>
      <p>Nu exista detalii</p>
    </div>
  </div>
</section>';
}





$keywordsContent = $event[0]["title"];
$keywords = '<meta name="keywords" content="'. $keywordsContent. '">';
$pageGenerator = new eventPage($event[0], $style, $content, $keywords);
$pageGenerator->displayPage();