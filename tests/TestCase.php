<?php
namespace Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;

/**
 * Class TestCase
 * @author MohammadNiknab <MohammadNiknab@gmail.com>
 */
abstract class TestCase extends OrchestraTestCase
{
    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'test');
        $app['config']->set('database.connections.test', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);


        // setup routes from file
        \Route::group([], __DIR__ . '/../src/Http/Routes/web.php');

        // setup configs
        \Config::set('surl.identifier_hash_length', 5);
        \Config::set('surl.cache_prefix', 'surl.identifier-');
        \Config::set('surl.items_per_page', 5);
    }

    /**
     * Get package providers.  At a minimum this is the package being tested, but also
     * would include packages upon which our package depends, e.g. Cartalyst/Sentry
     * In a normal app environment these would be added to the 'providers' array in
     * the config/app.php file.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            '\Mniknab\Surl\SurlServiceProvider',
        ];
    }

    /**
     * Get random id (fake) for tests
     *
     * @return int
     */
    protected function getRandomId(): int
    {
        return rand(1, 99);
    }

    /**
     * Get short url (redirect url) string
     *
     * @param $identifier
     * @return string
     */
    protected function getShortUrl($identifier): string
    {
        return route('surl.redirect',$identifier);
    }

    /**
     * Create surl with POST method
     *
     * @return \Illuminate\Testing\TestResponse
     */
    protected function newSurl()
    {
        return $this->getJson(route('surl.create'));
    }

    /**
     * Create surl with POST Json method
     *
     * @param array $parameters
     * @param bool $returnJson
     * @return \Illuminate\Testing\TestResponse|mixed
     */
    protected function createSurl(array $parameters = [], $returnJson = false)
    {
        $response = $this->postJson(route('surl.store'), $parameters);

        return $returnJson ? $response->json() : $response;
    }

    /**
     * Create surl with POST method - Not json
     *
     * @param array $parameters
     * @return \Illuminate\Testing\TestResponse|mixed
     */
    protected function createSurlWithNormalPostMethod(array $parameters = [])
    {
        return $this->post(route('surl.store'), $parameters);
    }

    /**
     * Update surl with PUT method
     *
     * @param $id
     * @param array $parameters
     * @return \Illuminate\Testing\TestResponse
     */
    protected function updateSurl($id, array $parameters = [],$withNormalPutMethod = false)
    {
        if($withNormalPutMethod){
            return $this->put(route('surl.update',$id), $parameters);
        }
        return $this->putJson(route('surl.update',$id), $parameters);
    }

    /**
     * Get edit surl page
     *
     * @param $id
     * @return \Illuminate\Testing\TestResponse
     */
    protected function editSurl($id)
    {
        return $this->getJson(route('surl.edit',$id));
    }

    /**
     * Destroy surl with DELETE method
     *
     * @param $id
     * @return \Illuminate\Testing\TestResponse
     */
    protected function destroySurl($id,$withNormalDeleteMethod = false)
    {
        if($withNormalDeleteMethod){
            return $this->delete(route('surl.destroy',$id));
        }

        return $this->deleteJson(route('surl.destroy',$id));
    }

    /**
     * Get all surl list
     *
     * @return \Illuminate\Testing\TestResponse
     */
    protected function listSurl()
    {
        return $this->getJson(route('surl.list'));
    }

    /**
     * Get redirect page
     *
     * @param $identifier
     * @return \Illuminate\Testing\TestResponse
     */
    protected function redirectSurl($identifier)
    {
        $shortUrl = $this->getShortUrl($identifier);
        return $this->getJson($shortUrl);
    }

}
