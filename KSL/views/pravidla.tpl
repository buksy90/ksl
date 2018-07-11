{% extends 'layout.tpl' %}

{% block title %}Pravidlá | {% endblock %}

{% block content %}

<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="page-header">
                <h1>Pravidlá</h1>
            </div>
        </div>
    </div>
    
   
    <div class="row form-group">
        <div class="col-xs-12">
            <ul class="nav nav-pills">
                <li class="active"><a href="#zakladne-ustanovenia" data-toggle="tab">Základné ustanovenia</a></li>
                <li><a href="#zvlastne-ustanovenia" data-toggle="tab">Zvláštne ustanovenia</a></li>
                <li><a href="#pravidla" data-toggle="tab">Pravidlá</a></li>
            </ul>
        </div>
    </div>
    <div class="row rules-row">
        <div class="col-xs-12">
            <ol id="tabs-content" class="tab-content">
                <li class="tab-pane fade active in" id="zakladne-ustanovenia">
                    <ol>
                        <li><p>Súťaž riadi občianske združenie Košická streetballová liga so sídlom v Košiciach, na Krosnianskej č.29 a pod vedením prezidenta Ing. Martina Kočiša.<p></li>
                        <li><p>Hrá sa podľa upravených pravidiel basketbalu pre streetballové účely (uvedených ďalej v rozpise). Hrací čas je <strike class="text-danger">2 x 30 minút (5.min prestávka)</strike> alebo až pokiaľ jedno družstvo nedosiahne 100 bodov. Hrací čas je hrubý, nezastavuje sa, okrem posledných troch minút, ktoré sa berú ako čistý čas. Prípadné predĺženie trvá 5 minút čistého času. Družstvo si môže vybrať až tri oddychové časy v dĺžke 60 sekúnd v ľubovolnom polčase. Oddychový čas hlási kapitán rozhodcovi zápasu.</p></li>
                        <li><p><strike>1.3 Systém súťaže – viď liga resp. pohár</strike></p></li>
                        <li><p><strike>Začiatok ligy – liga sa začína v sobotu 19.06.2016 o 14:00</strike></p></li>
                        <li><p>Hracie dni ligových zápasov sú sobota a nedeľa</p></li>
                        <li>
                            <p>
                                Každé družstvo musí mať na každom zápase jednotné dresy označené číslami. Čísla by mali byť umiestené na chrbte a mali by byť dosť výrazné, aby boli dobre identifikovateľné rozhodcom. Družstvo, ktoré nenastúpi v zápase s jednotnými dresmi, trestá sa pokutou za každý zápas! (viď <a href="{{ router.pathFor('pokuty-poplatky') }}">Pokuty a poplatky</a>). 
                                Každé družstvo má mať na rozcvičenie svoju loptu, pričom rozhodca vyberie najlepšiu loptu na hranie.
                            </p>
                        </li>
                        <li>
                            <p>
                                Kapitáni družstiev sú nútení uzavrieť najneskôr 24 hodín pred začiatkom ligy, vyplniť a zaslať priložený formulár súpisky družstiev alebo ho vyplniť na www.ksl.sk. 
                                Každé družstvo obdrží oficiálnu súpisku družstva, resp. si ju vytlačí na www.ksl.sk v sekcii Hráči. Súpiska sa predkladá pri každom zápase kvôli kontrole (na požiadanie kapitána druhého družstva kvôli neoprávnenému štartu niektorého hráča, resp. hráčov). 
                                Každé družstvo je povinné zaplatiť štartovné v plnej výške pred začiatkom ligy.
                                Ak družstvo nesplní všetky tieto podmienky bude vylúčené zo súťaže, bez nároku na vrátenie zaplatenej sumy.
                            </p>
                        </li>
                        <li><p>Za družstvo môžu nastúpiť iba hráči, ktorí už dovŕšili 15. rok svojho života. Na pohlavie nie je obmedzenie. Výnimky na vek udeľuje výkonný výbor ligy na základe žiadosti družstiev.</p></li>
                        <li>
                            <p>Hráči sa delia do dvoch kategórií:</p>
                            <ul>
                                <li><b>Trieda A:</b> hráči, ktorí hrali posledných 5 rokov, hrajú a budú hrať prvú alebo vyššiu basketbalovú ligu (okrem žien)</li>
                                <li><b>Trieda B:</b> ostatní hráči</li>
                            </ul>
                            <p>
                                Za každé družstvo môže nastúpiť v jednom zápase ľubovolný počet hráčov kategórie A. 
                                Na ihrisku môže byť však iba jeden, pričom títo hráči sa môžu striedať.
                            </p>
                        </li>
                        <li><p><strike>Rozpis zápasov – Spolu s týmto rozpisom obdrží každé družstvo rozpis zápasov ligy a pohára a takisto adresár všetkých družstiev.</strike></p></li>
                        <li><p>Na každom zápase bude prítomný jeden <b>rozhodca</b>, ktorý bude zodpovedný za dodržiavanie pravidiel počas hry, kontrolu času a skóre.</p></li>
                        <li><p><b>Námietky</b> sa podávajú telefonickou formou a riadia sa riadiacim orgánom ligy.</p></li>
                        <li><p><b>Protest</b> sa podáva najneskôr 24 hodín po skončení zápasu. Protest sa podáva písomne, e-mailom alebo telefonicky prezidentovi ligy. Ak protest nebude uznaný Výkonným výborom ligy, družstvo podávajúce protest zaplatí pokutu.</p></li>
                        <li><p>Liga a pohár sa hrá na ihrisku na ulici Amurská (sídlisko nad Jazerom). Rezervnými ihriskami sú : Pajorová, Bernoláková, Cottbuská. FINAL FOUR sa hrá na Amurskej ulici.</p></li>
                    </ol>
                </li>
                
                
                <li class="tab-pane fade" id="zvlastne-ustanovenia">
                    <ol>
                        <li>
                            <p>
                            Doplnenie súpisky môže kapitán družstva urobiť iba počas prvej polovice základnej časti ligy (telefonicky, internet) a to vždy za príslušný správny poplatok (viď <a href="{{ router.pathFor('pokuty-poplatky') }}">Pokuty a poplatky</a>). 
                            Každý rozhodca bude mať k dispozícii súpisky oboch družstiev pre prípadný protest, ktorý môže dať kapitán jedného, či druhého družstva kvôli neoprávnenému štartu niektorého hráča. 
                            Každý neoprávnený štart hráča sa trestá kontumáciou 30:0 v prospech súpera a príslušnou pokutou. Svojvoľné porušovanie tohto predpisu sa trestá vylúčením družstva zo súťaže. 
                            V playoff a finálovom turnaji môžu nastúpiť iba hráči, ktorí odohrali minimálne 5 zápasov základnej časti ligy (nie pohára).
                            Do odohratých zápasov sa počíta aj zápas, ak druhému družstvu sa zápas skontumuje pre nízky počet hráčov, resp. nedostavenie sa družstva na zápas.
                            </p>
                        </li>
                        <li>
                            <p>
                            Každá zmena termínu alebo začiatku zápasu musí byť schválená telefonicky prezidentom ligy najneskôr do 10:00 hod. v sobotu pred víkendovým dvojkolom (týka sa aj nedeľňajšieho zápasu). 
                            So zmenou musí byť oboznámený kapitán súpera a takisto prezident ligy, ktorý zabezpečí na preložený zápas predelegovanie rozhodcu. 
                            Preložený zápas musi byť odohratý najneskôr do 5 dní od termínu pôvodného zápasu. 
                            Predohrávka musí byť oznámená najneskôr 48 hodin pred začiatkom termínu predohrávaného zápasu Porušenie tohoto predpisu sa trestá pokutou. 
                            Každé družstvo môže počas celého trvania ligy (aj playoff) preložiť maximálne tri zápasy z iného dôvodu ako je nepriazeň počasia.
                            </p>
                        </li>
                        <li>
                            <p>
                            Ak sa družstvo nedostaví na zápas bez ohlásenia (telefonicky kapitánovi súpera a zároveň prezidentovi ligy), trestá sa kontumáciou 30:0 v prospech súpera a príslušnou pokutou. 
                            Čakacia doba na družstvo je 5 minút. Ak po uplynutí tejto doby sa niektoré z družstiev nedostaví, resp. nebude mať k dispozícii minimálne troch hráčov (hra 2:2 je zakázaná), trestá sa kontumáciou 30:0 v prospech súpera a pokutou. 
                            Kontumácia je vždy bez priznania bodu.
                            </p>
                        </li>
                        <li>
                            <p>
                            Ak sa v hrací deň zápasy nebudú môcť uskutočniť kvôli zlému počasiu (silný dážď), o zmene termínu sa dohodnú družstvá priamo na mieste, pričom musí byť fyzicky prítomný aspoň jeden hráč z každého družstva alebo telefonicky, 
                            pričom zmenu musia nahlásiť prítomnému rozhodcovi na ihrisku, prípadne prezidentovi ligy, ktorý so zmenou musí súhlasiť a oznámi zmenu rozhodcovi alebo rozhodca jemu.
                            </p>
                        </li>
                        <li>
                            <p>
                            Pokuty, resp. správne poplatky treba zaplatiť do 5 dní po doručení oznámenia o zaplatení pokuty. 
                            Nezaplatenie pokuty do stanoveného termínu sa trestá zdvojnásobovaním tejto pokuty, až po vylúčenie družstva z ligy. 
                            Ak pri poplatku za zaradenie hráča nového hráča na súpisku a vystavenie novej súpisky nedôjde k jeho úhrade a daný hráč nastúpi v niektorom ďalšom zápase, 
                            každý zápas sa kontumuje 30:0 v prospech súpera s príslušnou pokutou. 
                            Ak hráč dostane pokutu za vylúčenie v zápase, nemôže nastúpiť v ďalšom zápase po uplynutí trestu, až kým príslušnú pokutu neuhradí.
                            </p>
                        </li>
                        <li><p>Košická streetballová liga, ako organizátor ligy si vyhradzuje právo na zmeny a doplnky v tomto rozpise.</p></li>
                        <li><p>Vo všetkých náležitostiach zastupujú prezidenta ligy ostatní členovia vedenia ligy.</p></li>
                    </ol>
                </li>
                
                
                <li class="tab-pane fade" id="pravidla">
                    <ol>
                        <li>
                            <p>
                            Hrajú dve družstvá a to traja na troch.2. Hrá sa <strike class="text-danger">2 x 25 minút</strike> hrubého času (okrem posledných troch minút, ktoré sa berú ako čistý čas); 
                            ak je výsledok po uplynutí tohto času nerozhodný, nasleduje predĺženie, ktoré trvá 5 minút čistého času.
                            </p>
                        </li>
                        <li><p>Striedať môže družstvo len počas prerušenia hry.</p></li>
                        <li><p>Hra začína vhadzovaním spoza postrannej čiary. Loptu má hosťujúce družstvo. V druhom polčase má loptu domáce družstvo. Ak je nutné predĺženie, o loptu losujú kapitáni družstiev.</p></li>
                        <li><p>Kôš má hodnotu 2 body, ak bol dosiahnutý spoza trojkovej čiary, tak 3 body.</p></li>
                        <li><p>Ak brániace družstvo získa loptu (vypichnutím, doskočením, po neúspešnej streľbe, autovým vhadzovaním po strate lopty súpera), začína útok vynesením lopty za trojkový oblúk.</p></li>
                        <li><p>Po vhadzovaní môže byť kôš dosiahnutý až po dvoch prihrávkach, ale len keď ide o vhadzovanie po koši súpera (ak nejde o vhadzovanie po koši súpera, platí pravidlo č. 6).</p></li>
                        <li><p>Ak je vhadzovanie za trojkovým oblúkom, môže družstvo strieľať na kôš po prvej prihrávke, ak je vhadzovanie spod koša alebo pred trojkovým oblúkom, <strike>musí byť prvá prihrávka vedená za trojkový oblúk</strike>.</p></li>
                        <li><p>Po koši je pri vhadzovaní "mŕtva" lopta.</p></li>
                        <li><p>Útočiace družstvo môže doskočiť loptu a prípadne skórovať bez toho, aby muselo vyjsť za trojkový oblúk.</p></li>
                        <li><p>Ak je rozskok, loptu má spoza postrannej čiary brániace družstvo.</p></li>
                        <li><p>Ak je faul pri streľbe na kôš a kôš nebol, zahráva faulované družstvo loptu zboku. Pravidlo trestných hodov po faule pri streľbe na kôš sa ruší.</p></li>
                        <li><p>Ak bol po faule kôš, tak sa tento kôš priznáva za dva body a loptu má brániace družstvo. Pravidlo pokračovania v rozohrávaní útočiacim družstvom sa ruší.</p></li>
                        <li><p>Rozhodca môže posúdiť faul, ktorý sa nemusel udiať len pri streľbe na kôš, ako nešportovú chybu, čo má vždy za následok 2 voľné hody a loptu má faulované družstvo spoza koncovej čiary.</p></li>
                        <li><p>Kôš pri voľnom hode platí za 1 bod.<strike>Striela faulovany hrac alebo lubovolny ? ? ? !!!</strike></p></li>
                        <li><p>Ak sa hráč v jednom zápase dopustí dvoch nešportových chýb, rozhodca ho automaticky vylúči do konca zápasu.</p></li>
                        <li><p>Ak hráč pri bránení sústavne a evidentne fauluje útočiaceho hráča, môže takto faulovaný hráč požiadať rozhodcu, aby bola faulujúcemu hráčov udelená nešportová chyba (pozri tiež pravidlá 14 a 16). Rozhodca rozhodne na základe vlastného uváženia.</p></li>
                        <li><p>Ak rozhodca posúdi faul hráča ako mimoriadne závažný (likvidačný, brutálny), môže takto faulujúceho hráča ihneď vylúčiť.</p></li>
                        <li><p>Závažnosť vylúčenia hráča v dôsledku 2 nešportových chýb v jednom zápase, prípadne v dôsledku mimoriadne závažného faulu, posúdi Výkonný výbor ligy, pričom hráčovi môže udeliť dištanc minimálne na jeden zápas nepodmienečne.</p></li>
                        <li><p>Ak sa počas zápasu strhne bitka, resp. menšia potýčka, rozhodca automaticky udelí zainteresovaným hráčom nešportovú chybu a v útoku pokračuje družstvo, ktoré malo pred touto potýčkou loptu v držaní. Ak sa takto potrestaní hráči opäť zúčastnia ďalšej potýčky v zápase, rozhodca ich automaticky vylúči do konca zápasu.</p></li>
                        <li><p>Pri sebamenšom náznaku roztržky je rozhodca oprávnený ukončiť zápas a o jeho konečnom výsledku rozhodne riadiaci orgán ligy.</p></li>
                        <li><p>Závažnosť vylúčenia hráča v dôsledku bitky posúdi Výkonný výbor ligy, pričom hráčovi môže udeliť dištanc minimálne na 2 zápasy nepodmienečne.</p></li>
                        <li><p>Celá hra by mala byť v duchu dohody oboch družstiev a ak sa družstvá, resp. dvaja protihráči nevedia dohodnúť, rozhoduje rozhodca.</p></li>
                        <li>
                            <p>
                            Počas posledných troch minút riadneho hracieho času a počas celého trvania prípadného predĺženia môže mať družstvo loptu v držaní maximálne 30 sekúnd, pričom tento čas hlási rozhodca. 
                            Ak v tomto časovom intervale družstvo vystrelí na kôš (pričom sa lopta musí dotknúť obruče), príp. bolo faulované, počíta sa tento čas odznovu.
                            </p>
                        </li>
                        <li>
                            <p>
                            Ak sa niektorý hráč alebo družstvo správa nešportovo (odkopnutie lopty, slovné provokácie, pľuvanie na protihráča, nadávanie na rozhodcu a pod.), rozhodca takéto správanie posúdi ako nešportovú chybu, 
                            čo má vždy za následok 2 voľné hody poškodeného družstva a toto družstvo následne zahráva loptu spoza koncovej čiary.
                            </p>
                        </li>
                        <li>
                            <p>
                            Ak dôjde k fyzickému napadnutiu rozhodcu niektorým z hráčov, rozhodca tento zápas automaticky ukončí a o ďalšom osude stretnutia rozhodne Výkonný výbor ligy. 
                            Zároveň sa hráčovi, ktorý napadol rozhodcu, automaticky udelí dištanc na 3 zápasy a o jeho prípadnom ďalšom postihu rozhodne taktiež Výkonný výbor ligy.
                            </p>
                        </li>
                        <li><p>Zvyšné pravidlá sú podľa platných pravidiel FIBA.</p></li>
                        <li>
                            <p>
                            Rozhodcovia nie sú klasickými rozhodcami, nerozhodujú zápas, len zasahujú v prípade výskytu nezhôd. Ak sa zápas pritvrdí, hráči sú nervózni, 
                            rozhodca má právo viesť zápas ako klasický rozhodca, teda bude pískať každý faul, resp. technický priestupok. 
                            O klasické rozhodovanie môže požiadať rozhodcu aj kapitán družstva. Môže tak urobiť už pred začiatkom zápasu alebo kedykoľvek počas hry.
                            </p>
                        </li>
                        <li>
                            <p>
                            Rozhodca má pri evidentnom porušení pravidiel (prešľap, kroky, dvojitý dribling, rozkývanie koša a pod.) právo kedykoľvek zasiahnuť do hry podľa vlastného uváženia.
                            </p>
                        </li>
                        <li>
                            <p>
                            Pred každým začiatkom zápasu kapitáni oboch družstiev nahlásia rozhodcovi zoznam svojich hráčov podľa súpisky, ktorí nastúpia na zápas a rozhodca ich zapíše do oficiálneho zápisu o stretnutí. 
                            Kapitáni podpíšu zápis a tým pádom už nemôžu doplniť žiadneho iného hráča.
                            </p>
                        </li>
                        <li><p>Kapitáni sa pred zápasom nemôžu dohodnúť na nových pravidlách, ani na zmenách pravidiel.</p></li>
                        <li><p class="text-info">Ak lopta prejde celým objemom obručou a vypadne z koša, kôš platí.</p></li>
                    </ol>
                </li>
            </ol>
        </div>
    </div>
</div>
{% endblock %}

{% block styles %}
<style>
#tabs-content { padding: 0; }
#tabs-content > li > ol { padding-left: 20px; }
/*
.rules-row ol { counter-reset: item }
.rules-row li{ display: block }
.rules-row li:before { content: counters(item, ".") " "; counter-increment: item }
*/
</style>
{% endblock %}