<?php
namespace KSL;

class Routes {
    public static function set(\Slim\App $app) {
        $instance = new Routes();
        return $instance->setNonStatic($app);
    }
    
    public function setNonStatic(\Slim\App $app) {
        $container  = $app->getContainer();
        $twig       = $container['twig'];
        
        $app->get('/liga/o-nas', function ($request, $response, $args) {
            return $response->write( $twig->render('o-nas.tpl', [
                'navigationSwitch' => 'liga'
            ]));
        })->setName('o-nas');
        
        $app->get('/liga/pravidla', function ($request, $response, $args) {
            return $response->write( $this->twig->render('pravidla.tpl', [
                'navigationSwitch' => 'liga'
            ]));
        })->setName('pravidla');
        $app->get('/liga/pokuty-poplatky', function ($request, $response, $args) {
            return $response->write( $this->twig->render('pokuty_poplatky.tpl', [
                'navigationSwitch' => 'liga'
            ]));
        })->setName('pokuty-poplatky');

        $app->get('/', '\KSL\Controllers\Index:show')->setName('index');
        $app->get('/rozpis', '\KSL\Controllers\Rozpis:show')->setName('rozpis');
        $app->get('/tabulka', '\KSL\Controllers\Tabulka:show')->setName('tabulka');
        $app->get('/nova-sezona', '\KSL\Controllers\NovaSezona:show')->setName('nova-sezona');
        $app->post('/nova-sezona/generate', '\KSL\Controllers\NovaSezona:generate')->setName('nova-sezona#generate');
        $app->get('/nova-sezona/save', '\KSL\Controllers\NovaSezona:save')->setName('nova-sezona#save');
        $app->get('/playground', '\KSL\Controllers\Playground:showList')->setName('playground');
        $app->get('/playground/{link}', '\KSL\Controllers\Playground:showPlayground')->setName('playgroundByLink');
        $app->get('/teams', '\KSL\Controllers\Teams:show')->setName('timy');
        $app->get('/teams/{short}', '\KSL\Controllers\Teams:showTeam')->setName('tim');
        $app->get('/players/{seo}', '\KSL\Controllers\Players:showPlayer')->setName('player');
    }
}