<?php

namespace App\Http\Controllers;

use App\Models\Artisan;
use App\Models\User;

use Illuminate\Http\Request;

class APIController extends Controller
{
    /**
     * Return user from api binding
     *
     * @return User
     * @author Abdullah Al-Faqeir <abdullah@devloops.net>
     */
    public function getUser(): ?User
    {
        return auth('api-user')->user();
    }

    /**
     * Return driver from api binding
     *
     * @return Driver
     * @author Abdullah Al-Faqeir <abdullah@devloops.net>
     */
    public function getDriver(): ?Driver
    {
        return auth('api-driver')->user();
    }
}
