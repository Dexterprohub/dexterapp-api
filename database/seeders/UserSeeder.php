<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
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
        $password =  \Hash::make(12345678);

        $first_name1 = 'Victor';
        $second_name1 = 'Obi';
        $email1 = 'Jayvictor999@gmail.com';
        $phone1 = "09026896420";
        // $api_token1 = "eyJ0e4XAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhV556rfOQ8H2gCuUvOZXd0SSNZO1o8Y2ZoDhDSpgJabglxVTXobwC73PLpORPNQJm_2uYbi2RVT9o5m3tDXKRCDR7_BsJxPJGrlmDODOCwA7A3YZiD9AGMgZqSOdWK86Okj3sLwzjTBN4V_OpgROWLf1lG0eU5d1hRgCinUvXAMPMs8V7bH_PtFIGm5PsQbPNqAa5tCYSWNQrE4bgiNroFGzXBFoG6--GqZI1p8ki19e8RRruiicjv6d3MATviNJXcadZfDlku-fhzaG2fiaih6qsu77WEAlwQ_lKmVt4MWzJn0WkKb_DLtxBe6e4a3EXnFIO6HYd4lI_MpLDe8sQZWXTLMeCCZdAZSLg_ZHt0fuac40BCySSr21pwY";
        $password1 =  \Hash::make(12345678);
        
        $user = [
            'first_name' => $first_name,
            'last_name' => $second_name,
            'email' => $email,
            'phone' => $phone,
            // 'api_token' => $api_token,
            'password' => $password
        ];
        
        User::create($user);
        
        $user1 = [
            'first_name' => $first_name1,
            'last_name' => $second_name1,
            'email' => $email1,
            'phone' => $phone1,
            // 'api_token' => $api_token1,
            'password' => $password1
        ];
        
        User::create($user1);
    }
}
