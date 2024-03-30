<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class CheckUsers
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check()) {
            return $next($request);
        }

        if (!$request->hasCookie('guest_user_id') || !is_numeric($request->cookie('guest_user_id'))) {
            $guestSessionId = $this->generateUniqueSessionId();
            Cookie::queue('guest_user_id', $guestSessionId, 30 * 24 * 60); // 30 days expiry
        }

        return $next($request);
    }

    private function generateUniqueSessionId(): int
    {
        $ip = request()->ip(); // Lấy địa chỉ IP của người dùng
        $microtime = microtime(true) * 1000; // Lấy timestamp hiện tại và nhân với 1000 để tăng độ chính xác
        // Kết hợp timestamp và địa chỉ IP để tạo một session ID
        $sessionId = (int) ($microtime . ip2long($ip)); // Chuyển đổi kết quả thành số nguyên
        return $sessionId;
    }

}
