<?php
// (string) $message - message to be passed to Slack
// (string) $room - room in which to write the message, too
// (string) $icon - You can set up custom emoji icons to use with each message
​
function slack($message, $room = "gmri", $icon = ":longbox:") {
    $room = ($room) ? $room : "gmri";
    $data = "payload=" . json_encode(array(
            "channel"       =>  "#{$room}",
            "text"          =>  $message,
            "icon_emoji"    =>  $icon
        ));
    ​
    // You can get your webhook endpoint from your Slack settings
    $ch = curl_init("https://hooks.slack.com/services/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");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    ​
    // Laravel-specific log writing method
    // Log::info("Sent to Slack: " . $message, array('context' => 'Notifications'));
    return $result;
}