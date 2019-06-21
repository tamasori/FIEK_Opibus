<?php

use Illuminate\Database\Seeder;
use App\EmailText;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        EmailText::create(array(
            "name" => "Felhasználó elfogadása -> elfogadott felhasználónak",
            "description" => '
            <p>Használható változók:</p>
            <code>{{ $user->name }} : A felhasználó teljes neve</code>
            <code>{{ $user->email }} : A felhasználó email címe</code>
            <code>{{ $user->github }} : A felhasználó github felhasználóneve</code>
            <code>{{ $user->phone_number }} : A felhasználó github felhasználóneve</code>
            <code>{{ $user->created_at }} : A felhasználó létrehozásának dátuma</code>
            ',
            "command_name" => "user_accepted_toUser",
            "message" => ""
        ));
        EmailText::create(array(
            "name" => "Felhasználó regisztrált -> adminisztrátornak",
            "description" => '
            <p>Használható változók:</p>
            <code>{{ $user->name }} : A felhasználó teljes neve</code>
            <code>{{ $user->email }} : A felhasználó email címe</code>
            <code>{{ $user->github }} : A felhasználó github felhasználóneve</code>
            <code>{{ $user->phone_number }} : A felhasználó github felhasználóneve</code>
            <code>{{ $user->created_at }} : A felhasználó létrehozásának dátuma</code>
            ',
            "command_name" => "user_registration_toAdmin",
            "message" => ""
        ));
        EmailText::create(array(
            "name" => "Felhasználó regisztrált -> felhasználónak",
            "description" => '
            <p>Használható változók:</p>
            <code>{{ $user->name }} : A felhasználó teljes neve</code>
            <code>{{ $user->email }} : A felhasználó email címe</code>
            <code>{{ $user->github }} : A felhasználó github felhasználóneve</code>
            <code>{{ $user->phone_number }} : A felhasználó github felhasználóneve</code>
            <code>{{ $user->created_at }} : A felhasználó létrehozásának dátuma</code>
            ',
            "command_name" => "user_registration_toUser",
            "message" => ""
        ));
        EmailText::create(array(
            "name" => "Elfogadott foglalás -> felhasználónak",
            "description" => '
            <p>Használható változók:</p>
            <code>{{ $user->name }} : A felhasználó teljes neve</code>
            <code>{{ $user->email }} : A felhasználó email címe</code>
            <code>{{ $user->github }} : A felhasználó github felhasználóneve</code>
            <code>{{ $user->phone_number }} : A felhasználó github felhasználóneve</code>
            <code>{{ $user->created_at }} : A felhasználó létrehozásának dátuma</code>
            </br>
            <code>{{ $foglalas->from_date }} : A foglalás kezdeti dátuma</code>
            <code>{{ $foglalas->to_date }} : A foglalás vég dátuma</code>
            <code>{{ $foglalas->created_at }} : A foglalás leadása</code>
            <code>{{ $foglalas->updated_at }} : A foglalás elfogadása</code>
            </br>
            <code>{{ $eszkoz->name }} : Az eszköz neve</code>
            <code>{{ $eszkoz->youtube_link }} : Az eszközhöz tartozó youtube videó linkje</code>
            <code>{{ $eszkoz->description }} : Az eszköz leírása</code>
            </br>
            <code>{{ $labor->name }} : A labor neve</code>
            <code>{{ $labor->short_name }} : A labor kód neve</code>
            <code>{{ $labor->place }} : A labor területi elhelyezkedése</code>
            ',
            "command_name" => "reservation_accepted_toUser",
            "message" => ""
        ));

        EmailText::create(array(
            "name" => "Elutasított foglalás -> felhasználónak",
            "description" => '
            <p>Használható változók:</p>
            <code>{{ $user->name }} : A felhasználó teljes neve</code>
            <code>{{ $user->email }} : A felhasználó email címe</code>
            <code>{{ $user->github }} : A felhasználó github felhasználóneve</code>
            <code>{{ $user->phone_number }} : A felhasználó github felhasználóneve</code>
            <code>{{ $user->created_at }} : A felhasználó létrehozásának dátuma</code>
            </br>
            <code>{{ $foglalas->from_date }} : A foglalás kezdeti dátuma</code>
            <code>{{ $foglalas->to_date }} : A foglalás vég dátuma</code>
            <code>{{ $foglalas->created_at }} : A foglalás leadása</code>
            <code>{{ $foglalas->updated_at }} : A foglalás elfogadása</code>
            </br>
            <code>{{ $eszkoz->name }} : Az eszköz neve</code>
            <code>{{ $eszkoz->youtube_link }} : Az eszközhöz tartozó youtube videó linkje</code>
            <code>{{ $eszkoz->description }} : Az eszköz leírása</code>
            </br>
            <code>{{ $labor->name }} : A labor neve</code>
            <code>{{ $labor->short_name }} : A labor kód neve</code>
            <code>{{ $labor->place }} : A labor területi elhelyezkedése</code>
            ',
            "command_name" => "reservation_declined_toUser",
            "message" => ""
        ));

        EmailText::create(array(
            "name" => "Új hibabejelentés -> adminisztrátornak",
            "description" => '
            <p>Használható változók:</p>
            <code>{{ $user->name }} : A bejelentő felhasználó teljes neve</code>
            <code>{{ $user->email }} : A bejelentő felhasználó email címe</code>
            <code>{{ $user->github }} : A bejelentő felhasználó github felhasználóneve</code>
            <code>{{ $user->phone_number }} : A bejelentő felhasználó github felhasználóneve</code>
            <code>{{ $user->created_at }} : A bejelentő felhasználó létrehozásának dátuma</code>
            </br>
            <code>{{ $hiba->description }} : A hiba leírása</code>
            <code>{{ $hiba->created_at }} : A hiba létrehozásának dátuma</code>
            </br>
            <code>{{ $eszkoz->name }} : Az eszköz neve</code>
            <code>{{ $eszkoz->youtube_link }} : Az eszközhöz tartozó youtube videó linkje</code>
            <code>{{ $eszkoz->description }} : Az eszköz leírása</code>
            </br>
            <code>{{ $labor->name }} : A labor neve</code>
            <code>{{ $labor->short_name }} : A labor kód neve</code>
            <code>{{ $labor->place }} : A labor területi elhelyezkedése</code>
            ',
            "command_name" => "itemerror_toAdmin",
            "message" => ""
        ));
    }
}
