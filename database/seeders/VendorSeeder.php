<?php

namespace Database\Seeders;

use App\Models\Vendor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Hash;
class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $first_name = 'Prince';
        $second_name = 'Efik';
        $email = 'princezonik@gmail.com';
        $phone = "09018278443";
        // $api_token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhV556rfOQ8H2gCuUvOZXd0SSNZO1o8Y2ZoDhDSpgJabglxVTXobwC73PLpORPNQJm_2uYbi2RVT9o5m3tDXKRCDR7_BsJxPJGrlmDODOCwA7A3YZiD9AGMgZqSOdWK86Okj3sLwzjTBN4V_OpgROWLf1lG0eU5d1hRgCinUvXAMPMs8V7bH_PtFIGm5PsQbPNqAa5tCYSWNQrE4bgiNroFGzXBFoG6--GqZI1p8ki19e8RRruiicjv6d3MATviNJXcadZfDlku-fhzaG2fiaih6qsu77WEAlwQ_lKmVt4MWzJn0WkKb_DLtxBe6e4a3EXnFIO6HYd4lI_MpLDe8sQZWXTLMeCCZdAZSLg_ZHt0fuac40BCySSr21pwY";
        $password = \Hash::make(12345678);

        $first_name2 = 'Victor';
        $second_name2 = 'Obi';
        $email2 = 'obi.victor@dexterprolimited.com';
        $phone2 = "09018278423";
        // $api_token2 = "eyH0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhV556rfOQ8H2gCuUvOZXd0SSNZO1o8Y2ZoDhDSpgJabglxVTXobwC73PLpORPNQJm_2uYbi2RVT9o5m3tDXKRCDR7_BsJxPJGrlmDODOCwA7A3YZiD9AGMgZqSOdWK86Okj3sLwzjTBN4V_OpgROWLf1lG0eU5d1hRgCinUvXAMPMs8V7bH_PtFIGm5PsQbPNqAa5tCYSWNQrE4bgiNroFGzXBFoG6--GqZI1p8ki19e8RRruiicjv6d3MATviNJXcadZfDlku-fhzaG2fiaih6qsu77WEAlwQ_lKmVt4MWzJn0WkKb_DLtxBe6e4a3EXnFIO6HYd4lI_MpLDe8sQZWXTLMeCCZdAZSLg_ZHt0fuac40BCySSr21pwY";
        $password2 = \Hash::make(12345678);

        $user = [
            'first_name' => $first_name,
            'last_name' => $second_name,
            'email' => $email,
            'phone' => $phone,
            // 'api_token' => $api_token,
            'password' => $password
        ];
        $user2 = [
            'first_name' => $first_name2,
            'last_name' => $second_name2,
            'email' => $email2,
            'phone' => $phone2,
            // 'api_token' => $api_token2,
            'password' => $password2
        ];
        Vendor::create($user);
        Vendor::create($user2);
    }
}
