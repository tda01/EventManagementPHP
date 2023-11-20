<?php

class eventPage
{
    private $event;
    private $style;
    private $buttons = array("Home" => "home.php", "Agenda" => "agenda.php", "Speakers" => "eventSpeakers.php",
        "Partners" => "eventPartners.php", "Contact" => "contact.php");

    private $content;
    function __construct($event, $style, $content) {
        $this->event = $event;
        $this->style = $style;
        $this->content = $content;
    }

    function displayPage() {
        // head
        echo "<html><head>";

        $this->displayMeta();
        $this->displayTitle();
        $this->setStyle();
        echo "</head><body>";
        // body
        $this->displayNavBar();
        echo $this->content;

        echo "</body></html>";
    }

    function displayTitle() {
        echo "<title>".$this->event["title"]."</title>";
    }

    function setStyle() {
        echo '<link rel="stylesheet" href="css/' . $this->style . '">';
    }

    function displayMeta() {
            echo '<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">';
    }

    function displayNavBar() {
        echo '<header>
    <div class="container">
        <nav class="flex items-center justify-between">
            <div class="left flex justify-right">
                <div>';

        foreach ($this->buttons as $pageName => $link) {
            echo '<a href="' . $link . '?id=' . $this->event["eventID"] . '">' . $pageName . '</a>';
        }

        echo '</div>
            </div>
            <div class="right">
                                <a href="controlPanel.php"><button class="btn btn-primary" id="btnControlPanel">Control Panel</button></a>
            </div>
        </nav>
    </div>
</header>';
    }

}