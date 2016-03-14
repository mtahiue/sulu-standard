<?php

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\HttpFoundation\Request;

final class KernelManager
{
    /**
     * @var array
     */
    private $kernels = [
        AdminKernel::CONTEXT => AdminKernel::class,
        WebsiteKernel::CONTEXT => WebsiteKernel::class,
    ];

    /**
     * @var string
     */
    private $environment;

    /**
     * @var bool
     */
    private $debug;

    /**
     * @param string $environment
     * @param bool $debug
     */
    public function __construct($environment, $debug)
    {
        $this->environment = $environment;
        $this->debug = $debug;
    }

    /**
     * Creates a kernel for the console.
     *
     * @param InputInterface $input
     *
     * @return AppKernel
     *
     * @throws \RuntimeException
     */
    public function createConsoleKernel(InputInterface $input)
    {
        $context = $input->getParameterOption(['--context', '-c'], getenv('SULU_CONTEXT') ?: AdminKernel::CONTEXT);

        return $this->createKernelFromContext($context);
    }

    /**
     * Creates a kernel based on request info.
     *
     * @param Request $request
     *
     * @return AppKernel
     *
     * @throws \RuntimeException
     */
    public function createKernelFromRequest(Request $request)
    {
        $context = $request->server->get(
            'SULU_CONTEXT',
            0 === strpos($request->getPathInfo(), '/admin') ? AdminKernel::CONTEXT : WebsiteKernel::CONTEXT
        );

        return $this->createKernelFromContext($context);
    }

    /**
     * Creates a kernel based on globals.
     *
     * @return AppKernel
     *
     * @throws \RuntimeException
     */
    public function createKernelFromGlobals()
    {
        if (isset($_SERVER['SULU_CONTEXT'])) {
            $context = $_SERVER['SULU_CONTEXT'];
        } else {
            $context = WebsiteKernel::CONTEXT;

            if (0 === strpos($_SERVER['REQUEST_URI'], '/admin')) {
                $context = AdminKernel::CONTEXT;
            }
        }

        return $this->createKernelFromContext($context);
    }

    /**
     * Creates a kernel after the context has been determined.
     *
     * @param string $context
     *
     * @return AppKernel
     */
    protected function createKernelFromContext($context)
    {
        if (false === isset($this->kernels[$context])) {
            throw new \RuntimeException(sprintf('Kernel "%s" not found', $context));
        }

        return new $this->kernels[$context]($this->environment, $this->debug);
    }
}
