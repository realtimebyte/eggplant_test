<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IpLook;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class IpLookupController extends Controller
{
    //
    public function lookup(Request $request) {
        try {
            $request->validate(['ip' => 'required']);
            $ip = $request->input('ip');
            
            // Convert IP to long integer
            $ipLong = ip2long($ip);
            if ($ipLong === false) {
                throw new \InvalidArgumentException("Invalid IP address format");
            }
            
            // $result = DB::select("SELECT city, stateprov, INET_NTOA(CAST(CONV(HEX(ip_start), 16, 10) AS UNSIGNED)) AS rangeStart, INET_NTOA(CAST(CONV(HEX(ip_end), 16, 10) AS UNSIGNED)) AS rangeEnd FROM dbip_lookup WHERE ".$ipLong." BETWEEN INET_ATON(INET_NTOA(CAST(CONV(HEX(ip_start), 16, 10) AS UNSIGNED))) AND INET_ATON(INET_NTOA(CAST(CONV(HEX(ip_end), 16, 10) AS UNSIGNED))) Limit 1")[0];
            $result = DB::select("
                SELECT city, stateprov, 
                INET_NTOA(CAST(CONV(HEX(ip_start), 16, 10) AS UNSIGNED)) AS rangeStart, 
                INET_NTOA(CAST(CONV(HEX(ip_end), 16, 10) AS UNSIGNED)) AS rangeEnd 
                FROM dbip_lookup 
                WHERE ? BETWEEN INET_ATON(INET_NTOA(CAST(CONV(HEX(ip_start), 16, 10) AS UNSIGNED))) 
                AND INET_ATON(INET_NTOA(CAST(CONV(HEX(ip_end), 16, 10) AS UNSIGNED))) 
                LIMIT 1", [$ipLong])[0];
            if (empty($result)) {
                return response()->json(['error' => 'IP address not found'], 404);
            }
            
            if ($result) {
                return response()->json([
                    'city' => $result->city,
                    'region' => $result->stateprov,
                    'ip' => $ip,
                    'rangeStart' => $result->rangeStart,
                    'rangeEnd' => $result->rangeEnd
                ], 200);
            }
            return response()->json(['error' => 'IP address not found'], 404);
        } catch (\InvalidArgumentException $e) 
        {
            Log::error('Invalid IP address format: ' . $e->getMessage());
            return response()->json(['error' => 'Invalid IP address format'], 400);
        } catch (\Exception $e) {
            // Handle general exceptions
            Log::error('Error retrieving IP information: ' . $e->getMessage());
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }
}
