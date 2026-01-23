<?php
// Supabase Credentials
$SUPABASE_URL = "https://kbouwhempbjybtnkhjrh.supabase.co";
$SUPABASE_KEY = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Imtib3V3aGVtcGJqeWJ0bmtoanJoIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NjkxNzU3MTQsImV4cCI6MjA4NDc1MTcxNH0.Rr3zIxkBMfaFFagxPdPWHDj10vyd3M_pwt5ObKxE1C8";

/**
 * Generic cURL function to interact with Supabase REST API
 */
function supabase_request($method, $endpoint, $data = null) {
    global $SUPABASE_URL, $SUPABASE_KEY;
    
    $url = $SUPABASE_URL . $endpoint;
    $ch = curl_init($url);
    
    $headers = [
        "apikey: $SUPABASE_KEY",
        "Authorization: Bearer $SUPABASE_KEY",
        "Content-Type: application/json",
        "Prefer: return=representation"
    ];
    
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    
    if ($data) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    }
    
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    return [
        'status' => $http_code,
        'body' => json_decode($response, true)
    ];
}
?>
