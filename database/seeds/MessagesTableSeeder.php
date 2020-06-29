<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\ActiveSponsorship;
use App\Apartment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class MessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $messagesText1 = [
            "Buongiorno, siamo molto interessati a prendere in affitto il vostro appartamento per il prossimo week-end. È possibile anche fare un late-checkin dopo le ore 22 del venerdi? Grazie e buona giornata. Massimo",
            'Salve, scrivo per sapere se è disponibile un asciugacapelli. Grazie e a presto, Marisa.',
            'Gentile host, il vostro appartamento sembra davvero perfetto per il soggiorno che stiamo programmando. Sono previsti sconti per soggiorni prolungati di circa 2 settimane? Grazie, Luca.',
            'Buongiorno, è presente una lavatrice in casa? È possibile usarla senza problemi? In caso affermativo, siamo pronti per prenotare un soggiorno di 2 settimane per il mese prossimo.',
            'Salve, complimenti per la casa. È possibile accedere la prima volta anche arrivando in orario notturno? Grazie, Samuele',
            'Hello, do you speak english? I would like to have more informations about the house. Regards, Alicia'
        ];

        $messagesText2 = [
            'Salve, è possibile avere un contatto telefonico per maggiori dettagli?',
            'Sono ammessi cani di grossa taglia? Manuela',
            'Gradirei avere maggiori informazioni sulle modalità di pagamento.',
            'Buonasera, a quanto dista il supermercato più vicino?',
            'Il prezzo comprende i servizi di pulizia? Buona serata, Gianluca R.',
            'È possibile avere ulteriori foto della casa? Grazie Samantha A. Libert'
        ];
        $messagesText3 = [
            'Buongiorno, è possibile pagare con bonifico? L.',
            'Salve, volevo sapere se è necessario versare una caparra.',
            "A quanto dista la stazione ferroviaria con i mezzi pubblici?",
            'È presente una culla o fasciataio per neonati? Carmen',
            'È possibile pagare in contanti in loco?',
            'Buonasera, accetatte già prenotazioni per il prossimo anno? Lucrezia e Maurizio'
        ];
        for ($i = 1; $i <= 13; $i++) {
            DB::table('messages')->insert([
                'apartment_id' => $i,
                'sender' => $faker->email,
                'text' => $messagesText1[rand(0, 5)],
                'created_at' => $faker->dateTimeBetween($startDate = '-30 days', $endDate = 'now', $timezone = 'Europe/Rome'),
                'updated_at' => Carbon::now()
            ]);
        }
        for ($i = 1; $i <= 13; $i++) {
            DB::table('messages')->insert([
                'apartment_id' => $i,
                'sender' => $faker->email,
                'text' => $messagesText2[rand(0, 5)],
                'created_at' => $faker->dateTimeBetween($startDate = '-60 days', $endDate = '-46 days', $timezone = 'Europe/Rome'),
                'updated_at' => Carbon::now()
            ]);
        }
        for ($i = 1; $i <= 13; $i++) {
            DB::table('messages')->insert([
                'apartment_id' => $i,
                'sender' => $faker->email,
                'text' => $messagesText3[rand(0, 5)],
                'created_at' => $faker->dateTimeBetween($startDate = '-90 days', $endDate = '-61 days', $timezone = 'Europe/Rome'),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
