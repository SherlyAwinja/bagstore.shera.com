<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleManager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $role  The required role (admin, vendor, or customer)
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Check if user is authenticated - redirect to login with intended URL
        if (!Auth::check()) {
            return redirect()->guest(route('login'));
        }
        
        $user = Auth::user();
        $authUserRole = $user->role ?? null;

        // Validate role parameter
        $validRoles = ['admin', 'vendor', 'customer'];
        if (!in_array($role, $validRoles)) {
            // Invalid role parameter - redirect to home
            return redirect()->route('home');
        }

        // Map role names to role values
        $roleMap = [
            'admin' => 0,
            'vendor' => 1,
            'customer' => 2,
        ];

        $requiredRoleValue = $roleMap[$role];

        // Check if user has the required role
        if ($authUserRole === $requiredRoleValue) {
            return $next($request);
        }

        // User doesn't have the required role - redirect to their appropriate dashboard
        switch ($authUserRole) {
            case 0: // Admin
                return redirect()->route('admin');
            case 1: // Vendor
                return redirect()->route('vendor');
            case 2: // Customer
                return redirect()->route('dashboard');
            default:
                // Invalid or null role - redirect to login
                Auth::logout();
                return redirect()->route('login')->with('error', 'Invalid user role. Please contact administrator.');
        }
    }
}
