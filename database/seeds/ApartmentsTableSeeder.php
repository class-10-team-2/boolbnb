<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Apartment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ApartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    //factory(Apartment::class, 50)->create();
    public function run()
    {
        $seedApts = [
            [
                'title' => "Loft nel centro storico di Pavia",
                'description' => "Il nostro Loft è ampio e luminoso, recentemente ristrutturato, era anticamente una chiesa. Ormai sconsacrata da diversi secoli, nel 1930 circa è stato ristrutturato una prima volta, e utilizzato dal Collegio Borromeo.

                Ceduto a privati nel 1992, è divenuto abitazione, e poi ristrutturato ancora nel 2018. Oggi è pronto per accogliervi con una grande sala con cucina a vista, camera da letto principale soppalcata e seconda camera doppia, 2 bagni principali con doccia e sauna, e 1 bagno di servizio. È presente un posto auto privato scoperto. Free Wi-Fi.
                
                Location: il loft si trova nel pieno centro storico di Pavia, a due passi da tutte le principali attrazioni turistiche, il Duomo, il Ponte Coperto, e l'Università.",
                'address' => "via Siro Comi 36, Pavia, PV",
                'lat' => 45.1834,
                'lng' => 9.1555,
                'user_id' => rand(1, 5),
                'rooms' => 2,
                'beds' => 4,
                'baths' => 3,
                'mq' => 165,

            ],
            [
                'title' => "Attico ai piedi della Madonnina",
                'description' => "Un trilocale nel pieno centro di Milano, con vista su piazza del Duomo. Il nostro appartamento è all’ultimo piano di un antico e prestigioso palazzo meneghino. La vista offerta dalle ampie vetrate del salone è mozzafiato!

                L’attico comprende 4 camere da letto doppie, divano letto in salone, 3 bagni, sauna con idromassaggio, cucina abitabile con ampio tavolo per 12 persone, terrazzo con piscina di 10 metri. La reception è attiva dalle 6 alle 20.",
                'address' => "Piazza del Duomo 3, Milano, MI",
                'lat' => 45.4643,
                'lng' => 9.1895,
                'user_id' => rand(1, 5),
                'rooms' => 4,
                'beds' => 10,
                'baths' => 3,
                'mq' => 230,

            ],
            [
                'title' => "Open space in zona Isola",
                'description' => "Per un soggiorno a Milano, il nostro open space di recente ristrutturazione offre 6 posti letto, 2 bagni con una piccola sauna, e grande comodità. A pochi minuti da una delle zone più alla moda di Milano, e da tutti i mezzi pubblici che raggiungono il centro città. Accettiamo animali di piccola taglia. Posto auto scoperto.",
                'address' => "Via Francesco Arese, 13, 20159 Milano MI",
                'lat' => 45.4915,
                'lng' => 9.1903,
                'user_id' => rand(1, 5),
                'rooms' => 3,
                'beds' => 6,
                'baths' => 2,
                'mq' => 120,

            ],
            [
                'title' => "Il bilocale di San Siro",
                'description' => "Il nostro bilocale in zona San Siro è piccolo ma accogliente. Perfetto per un weekend in coppia a Milano, o per un soggiorno a scopo lavorativo. Comprende una camera con letto king size, sala con cucina a vista, un ampio bagno finestrato con vasca e doccia e un balcone di 6mq. Terzo piano con ascensore. WiFi ultraveloce e portineria mezza giornata. A meno di 10 minuti dalla metro lilla (M5).",
                'address' => "Via Isaac Newton 2, 20148 Milano MI, Italia",
                'lat' => 45.4737,
                'lng' => 9.1327,
                'user_id' => rand(1, 5),
                'rooms' => 1,
                'beds' => 2,
                'baths' => 1,
                'mq' => 60,

            ],
            [
                'title' => "Appartamento a Torino a pochi passi dalla metro",
                'description' => "Si tratta di un trilocale con due camere da letto, perfetto per 4 persone, ma ne può ospitare fino a 6 grazie al divano letto posto in soggiorno. WiFi e portineria mezza giornata. Posto auto coperto. A 2 minuti dalla metropolitana. Terzo piano SENZA ascensore. Non sono ammessi animali a causa dell’allergia del proprietario.",
                'address' => "Via Vincenzo Vela, 26/B 10128 Torino",
                'lat' => 45.0655,
                'lng' => 7.6660,
                'user_id' => rand(1, 5),
                'rooms' => 2,
                'beds' => 6,
                'baths' => 1,
                'mq' => 95,

            ],
            [
                'title' => "Loft nel quadrilngero Romano a Torino",
                'description' => "Il nostro loft è stato recentemente ristrutturato e presenta 10 posti letto divisi in 3 camere (due quadruple e una doppia). Sauna, portineria, posto auto, 4 bagni. Animali ammessi. Per info contattateci.",
                'address' => "Via San Domenico, 16, 10122 Torino",
                'lat' => 45.0749,
                'lng' => 7.6796,
                'user_id' => rand(1, 5),
                'rooms' => 3,
                'beds' => 10,
                'baths' => 4,
                'mq' => 240,

            ],
            [
                'title' => "Casa vista mare a Rapallo",
                'description' => "Una piccola e accogliente abitazione sul lungomare di Rapallo. Al 3 piano con terrazzo ampio, ideale per pranzi e cene. Garage coperto. Non è presente la connessione internet, ma il segnale 4G è buono. Sono ammessi animali di piccola taglia. Piscina condominiale.",
                'address' => "Lungomare Vittorio Veneto, 16035 Rapallo GE, Italia",
                'lat' => 44.3484,
                'lng' => 9.2302,
                'user_id' => rand(1, 5),
                'rooms' => 1,
                'beds' => 2,
                'baths' => 1,
                'mq' => 55,

            ],
            [
                'title' => "Una mansarda sul mare a Recco",
                'description' => "Recco, città famosa per la sua focaccia al formaggio, è un luogo ideale per le vacanze all’insegna del sole e del mare. Se volete passare pochi giorni o intere settimane in questa cittadina ligure, offriamo una mansarda ampia e luminosa, per 4 persone, con vista mare. Sebbene sia una mansarda, la recente ristrutturazione ha allargato gli spazi, consentendo la piena vivibilità di ogni ambiente. 2 camere da letto, sala con cucina, studio (o sala relax), 2 bagni con doccia. WiFi, posto auto inclusi. Non è presente l’ascensore.",
                'address' => "Via 4 Novembre, 16036 Recco GE, Italia",
                'lat' => 44.3618,
                'lng' => 9.1432,
                'user_id' => rand(1, 5),
                'rooms' => 2,
                'beds' => 4,
                'baths' => 2,
                'mq' => 85,

            ],
            [
                'title' => "Appartamento storico nel centro di Bologna",
                'description' => "Piccolo, silenzioso e caratteristico monolocale di 25 mq, situato nel pieno centro storico, a due passi dalle torri (300 mt) e comodo alla fiera (1,5 km). Costituito da un letto matrimoniale, soppalco con un letto doppio, angolo cottura e bagno. Lenzuola e asciugamani inclusi.",
                'address' => "Vicolo Sant'Arcangelo, 2, 40123 Bologna BO, Italia",
                'lat' => 44.4930,
                'lng' => 11.340,
                'user_id' => rand(1, 5),
                'rooms' => 2,
                'beds' => 4,
                'baths' => 1,
                'mq' => 90,

            ],
            [
                'title' => "Appartamento comodo a Modena centro",
                'description' => "Ampia e luminosa camera doppia (due letti singoli) con bagno privato. Ingresso indipendente dal giardino. Adiacente al centro ma fuori ZTL, a 20 minuti a piedi dalla stazione ferroviaria. Aria condizionata, colazione inclusa, Wi-Fi. Non c'è la cucina ma sono presenti caffettiera elettrica, frigo, microonde e fornello elettrico.",
                'address' => "Strada Morane, 15, 41125 Modena MO, Italia",
                'lat' => 44.6388,
                'lng' => 10.9257,
                'user_id' => rand(1, 5),
                'rooms' => 1,
                'beds' => 2,
                'baths' => 1,
                'mq' => 45,

            ],
            [
                'title' => "Roma a due passi dal centro",
                'description' => "Loft al piano terra, con entrata indipendente, in un palazzo del 1800, 40 mq più un letto soppalcato (10 mq), bagno con lavatrice ed asciugatrice, biancheria completa a disposizione. Porremo, come di consueto, la massima attenzione alla pulizia dell'appartamento.",
                'address' => "Via di Sant'Alessio, 00153 Roma",
                'lat' => 41.8831,
                'lng' => 12.4795,
                'user_id' => rand(1, 5),
                'rooms' => 2,
                'beds' => 4,
                'baths' => 1,
                'mq' => 55,

            ],
            [
                'title' => "Appartamento sotto le mura Vaticane",
                'description' => "‘Parva sed apta mihi’ (Piccola ma adatta a me) scrisse il poeta Ludovico Ariosto, sopra l'ingresso della sua casa. E così si può definire il nostro appartamento. Si compone di un piccolo ingresso, camera da letto matrimoniale (con possibilità di due letti singoli e di aggiunta di un lettino per bambini), soggiorno (con divano letto matrimoniale), piccola cucina completamente attrezzata, bagno (con cabina doccia e bidet). Troverete tutti gli accessori che renderanno confortevole il vostro soggiorno, in un ambiente dai colori allegri, situato in una zona centralissima.",
                'address' => "Via Sebastiano Veniero, 10 00192 Roma ",
                'lat' => 41.9080,
                'lng' => 12.4547,
                'user_id' => rand(1, 5),
                'rooms' => 2,
                'beds' => 4,
                'baths' => 1,
                'mq' => 60,

            ],
            [
                'title' => "Casa nel cuore di Napoli",
                'description' => "La nostra casa è lo spazio ideale per trascorrere un piacevole soggiorno nel centro antico di Napoli.
                I punti di interesse storico-artistico sono facilmente raggiungibili a piedi in pochi minuti, Museo Archeologico, Piazza Dante, Via Tribunali e Via Toledo.",
                'address' => "Via delle Zite, 80138 Napoli NA",
                'lat' => 40.8513,
                'lng' => 14.2614,
                'user_id' => rand(1, 5),
                'rooms' => 1,
                'beds' => 2,
                'baths' => 1,
                'mq' => 70,

            ],
        ];








        ////////////////////////////////////////////////////////////////////////////
        foreach ($seedApts as $seedApt) {
            DB::table('apartments')->insert([
                'title' => $seedApt['title'],
                'description' => $seedApt['description'],
                'address' => $seedApt['address'],
                'latitude' => $seedApt['lat'],
                'longitude' => $seedApt['lng'],
                'user_id' => $seedApt['user_id'],
                'rooms' => $seedApt['rooms'],
                'beds' => $seedApt['beds'],
                'baths' => $seedApt['baths'],
                'mq' => $seedApt['mq'],
                'img_path' => 'https://picsum.photos/600/400',
                'visible' => 1,
                'slug' => trim($seedApt['title'], '-'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()

            ]);
        }
    }
}
