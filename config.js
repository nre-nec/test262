// Supabase Configuration
const SUPABASE_URL = "https://kbouwhempbjybtnkhjrh.supabase.co";
const SUPABASE_KEY = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Imtib3V3aGVtcGJqeWJ0bmtoanJoIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NjkxNzU3MTQsImV4cCI6MjA4NDc1MTcxNH0.Rr3zIxkBMfaFFagxPdPWHDj10vyd3M_pwt5ObKxE1C8";

/**
 * Helper function for SHA-256 hashing in the browser
 */
async function hashPassword(password) {
    const msgUint8 = new TextEncoder().encode(password);
    const hashBuffer = await crypto.subtle.digest('SHA-256', msgUint8);
    const hashArray = Array.from(new Uint8Array(hashBuffer));
    const hashHex = hashArray.map(b => b.toString(16).padStart(2, '0')).join('');
    return hashHex;
}

/**
 * Generic Fetch function to interact with Supabase REST API
 */
async function supabaseRequest(method, endpoint, data = null) {
    const url = SUPABASE_URL + endpoint;
    const headers = {
        "apikey": SUPABASE_KEY,
        "Authorization": `Bearer ${SUPABASE_KEY}`,
        "Content-Type": "application/json",
        "Prefer": "return=representation"
    };

    const options = {
        method: method,
        headers: headers
    };

    if (data) {
        options.body = JSON.stringify(data);
    }

    try {
        const response = await fetch(url, options);
        const result = await response.json();
        return {
            status: response.status,
            body: result
        };
    } catch (error) {
        console.error("Supabase Request Error:", error);
        alert("خطأ في الاتصال بالقاعدة: " + error.message);
        return {
            status: 500,
            body: { message: "Network Error: " + error.message }
        };
    }
}
