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
        $app->get('/admin/news', '\KSL\Controllers\AdminNews:show')->setName('admin-news');
        $app->get('/admin/news/new', '\KSL\Controllers\AdminNews:showNew')->setName('admin-news#new');
        $app->post('/admin/news/create', '\KSL\Controllers\AdminNews:showCreate')->setName('admin-news#create');


        $app->get( '/welcome', function($request, $response, $args) {
            $body = $response->getBody();
            $body->write('Welcome dear user '.$_SESSION['auth']);

            return $response;
        });

        $app->get('/login/{idp}', function($request, $response, $args){
            try {
                require DIR_ROOT.'/KSL/config.php';
                $hybridauth     = new \Hybridauth\Hybridauth($config['hybridauth']);
                $adapter        = $hybridauth->authenticate( ucwords($args['idp']) );
                $isConnected    = $adapter->isConnected();
                $userProfile    = $adapter->getUserProfile();

                if(empty($userProfile)) $response->withRedirect('/error');

                $identifier = $userProfile->identifier;

                if(\KSL\Models\User::IdentifierExists($identifier)) {
                    $user   = new \KSL\Models\User();
                    $user->Login($identifier);

                    return $response->withHeader('Location', '/welcome?again=1');
                }
                else {
                    $user   = \KSL\Models\User::Register($identifier, $userProfile->email, $userProfile->firstName, $userProfile->lastName, $userProfile->photoURL);
                    $user->Login($identifier);
                    
                    return $responseres->withHeader('Location', '/welcome');
                }
            }
            catch(Exception $e) {
                die($e->getMessage());
            }
        });

        $app->get('/logout', function($request, $response, $args){
            $user   = new \KSL\Models\User();
            $user->Logout();
            \Hybrid_Auth::logoutAllProviders();
            $response->withRedirect('/');                
        });

/*
        $app->get( '/hybrid', function($request, $response, $args) {
            require_once( 'vendor/hybridauth/hybridauth/hybridauth/Hybrid/Auth.php' );
            require_once( 'vendor/hybridauth/hybridauth/hybridauth/Hybrid/Endpoint.php' );

            \Hybrid_Endpoint::process();
        });
        */
    }
}