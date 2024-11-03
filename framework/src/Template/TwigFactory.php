<?php
namespace ChidoUkaigwe\Framework\Template;

use ChidoUkaigwe\Framework\Session\SessionInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;

class TwigFactory
{
    public function __construct(
        private SessionInterface $session,
        private string $templatesPath
    )
    {

    }
    public function create(): Environment
    {
        // instantiate FileSystemLoader with templates path
        $loader = new FilesystemLoader($this->templatesPath);

        //  instantiate Twig Environment with loader
        $twig = new Environment($loader, [
            'debug' => true,
            'cache' => false
        ]);

        //  add new twig session() function to Environment
        $twig->addExtension(new \Twig\Extension\DebugExtension());
        $twig->addFunction(new TwigFunction('session', [$this, 'getSession']));

        return $twig;

        //  instantiate Twig Environment with loader

        //  add new twig session() function to Environment
    }

    public function getSession(): SessionInterface
    {
        return $this->session;
    }
}